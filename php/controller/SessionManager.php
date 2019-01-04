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

    //Return the current session manager (create if not exist)
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new SessionManager;
        }
        return self::$instance;
    }

    //Check if a session is active
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

    //Check if the current session is allowed to perform an action
    public function isAuthorized($requiredLevel){
        if($this->isSessionActive()){
            if($_SESSION[SessionData::USER][SessionData::USER_LEVEL] <= $requiredLevel){
                return true;
            } else {
                AlertManager::addAlert(Label::LEVEL_TOO_LOW, AlertType::DANGER);
                http_response_code(HttpResponseCode_ErrorClient::FORBIDDEN);
            }
        } else {
            AlertManager::addAlert(Label::SESSION_INACTIVE, AlertType::DANGER);
            http_response_code(HttpResponseCode_ErrorClient::UNAUTHORIZED);
        }
        return false;
    }

    //Log the user
    public function login(Connection $connection){
        if(isset($_POST['name'])
            & isset($_POST['password'])){
            $query = $connection->getDB()->prepare(
                "SELECT * FROM User WHERE pseudo=:pseudo");
            $query->bindParam(':pseudo', $_POST['name']);
            $query->execute();
            if($query->rowCount() > 0){
                $row = $query->fetch();
                if($this->_encrypt->checkPassword($_POST['password'], $row['password'])){
                    $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]=$row['pseudo'];
                    $_SESSION[SessionData::USER][SessionData::USER_LEVEL]=$row['level'];
                    AlertManager::addAlert(Label::WELCOME." ".$row['pseudo'], AlertType::INFO);
                } else {
                    AlertManager::addAlert(Label::INCORRECT_PASSWORD, AlertType::DANGER);
                }
            } else {
                AlertManager::addAlert(Label::INCORRECT_USERNAME, AlertType::DANGER);
            }
        }
    }

    //Destroy the current session
    public function destroySession(){
        $_SESSION = null;
        session_destroy();
        AlertManager::addAlert(Label::DISCONNECTED, AlertType::INFO);
    }
}