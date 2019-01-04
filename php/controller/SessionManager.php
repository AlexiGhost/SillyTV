<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:28
 */

session_start();
require_once(__DIR__."/../model/Encrypt.php");
require_once(__DIR__."/../model/Connection.php");
require_once(__DIR__."/AlertManager.php");
require_once(__DIR__."/../model/Alert.php");

$connection = isset($connection) ? $connection : new Connection();
$sManager = SessionManager::getInstance();
if(!isset($_SESSION[SessionData::USER])){
    if(isset($_POST['name']) && isset($_POST['password'])){
        $sManager->login($connection);
    }
} else {
    if(isset($_POST['logout'])){
        $sManager->destroySession();
    }
}
class SessionManager
{
    private static $instance = NULL;
    private $_encrypt;

    private function __construct($encrypt=null){
        $this->_encrypt = $encrypt==null ? new Encrypt() : $encrypt;
    }

    /**Return the current session manager (create if not exist)
     * @return SessionManager|null
     */
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new SessionManager;
        }
        return self::$instance;
    }

    /**Check if a session is active
     * @return bool
     */
    public function isSessionActive(){
        if(session_status() == PHP_SESSION_ACTIVE){
            if(isset($_SESSION[SessionData::USER][SessionData::USER_LEVEL]) && isset($_SESSION[SessionData::USER][SessionData::USER_PSEUDO])) {
                return true;
            }
        }
        AlertManager::addAlert(Label::AUTHENTICATION_REQUIRED, AlertType::DANGER);
        http_response_code(HttpResponseCode_ErrorClient::UNAUTHORIZED);
        return false;
    }

    /**Check if the current session is allowed to perform an action
     * @param $requiredLevel
     * @return bool
     * @deprecated level system replaced by authorisation table
     */
    public function isAuthorized($requiredLevel){
        if($this->isSessionActive()){
            if($_SESSION[SessionData::USER][SessionData::USER_LEVEL] <= $requiredLevel){
                return true;
            } else {
                AlertManager::addAlert(Label::OPERATION_NOT_ALLOWED, AlertType::DANGER);
                http_response_code(HttpResponseCode_ErrorClient::FORBIDDEN);
            }
        }
        return false;
    }

    /**Log the user
     * @param Connection $connection
     */
    public function login(Connection $connection){
        if(isset($_POST['name'])
            & isset($_POST['password'])){
            $query = $connection->getDB()->prepare(
                "SELECT * FROM User WHERE pseudo=:pseudo");
            $query->bindParam(':pseudo', $_POST['name']);
            $query->execute();
            if($query->rowCount() > 0){
                $user = $query->fetch();
                if($this->_encrypt->checkPassword($_POST['password'], $user[UserData::USER_PASSWORD])){
                    $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]=$user[UserData::USER_PSEUDO];
                    $_SESSION[SessionData::USER][SessionData::USER_LEVEL]=$user[UserData::USER_LEVEL];
                    AlertManager::addAlert(Label::WELCOME." ".$_SESSION[SessionData::USER][SessionData::USER_PSEUDO], AlertType::INFO);
                } else {
                    AlertManager::addAlert(Label::INCORRECT_PASSWORD, AlertType::DANGER);
                }
            } else {
                AlertManager::addAlert(Label::INCORRECT_USERNAME, AlertType::DANGER);
            }
        }
    }

    /**Destroy the current session*/
    public function destroySession(){
        $_SESSION = null;
        session_destroy();
        AlertManager::addAlert(Label::DISCONNECTED, AlertType::INFO);
    }
}