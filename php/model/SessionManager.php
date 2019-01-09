<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:28
 */

session_start();
require_once(__DIR__ . "/../model/Encrypt.php");
require_once(__DIR__ . "/../model/Connection.php");
require_once(__DIR__ . "/AlertManager.php");
require_once(__DIR__ . "/../model/Alert.php");

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

/**
 * Class SessionManager
 */
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
            if(isset($_SESSION[SessionData::USER][SessionData::USER_GROUP]) && isset($_SESSION[SessionData::USER][SessionData::USER_PSEUDO])) {
                return true;
            }
        }
        AlertManager::addAlert(Label::AUTHENTICATION_REQUIRED, AlertType::DANGER);
        http_response_code(HttpResponseCode_ErrorClient::UNAUTHORIZED);
        return false;
    }


    /**
     * @param $action - available actions in GroupData
     * @return bool
     */
    public function isAuthorized($action){
        if($this->isSessionActive()){
            $sql = "SELECT ".$action." FROM user_group WHERE id = ".$_SESSION[SessionData::USER][SessionData::USER_GROUP];
            $query = Connection::getInstance()->getDB()->prepare($sql);
            $query->execute();
            if($query->fetchColumn() == 1)
                return true;
            else
                AlertManager::addAlert(Label::OPERATION_NOT_ALLOWED, AlertType::WARNING);
                http_response_code(HttpResponseCode_ErrorClient::FORBIDDEN);
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
                if($this->_encrypt->checkPassword($_POST['password'], $user[UserData::PASSWORD])){
                    if($user[UserData::ACTIVE]){
                        $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]=$user[UserData::PSEUDO];
                        $_SESSION[SessionData::USER][SessionData::USER_GROUP]=$user[UserData::GROUP];
                        AlertManager::addAlert(Label::WELCOME." ".$_SESSION[SessionData::USER][SessionData::USER_PSEUDO], AlertType::INFO);
                    } else {
                        AlertManager::addAlert(Label::USER_INACTIVE, AlertType::DANGER);
                    }
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