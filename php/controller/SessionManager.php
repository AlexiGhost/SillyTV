<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:28
 */

session_start();
require_once("PHP/model/Encryptor.php");
require_once("PHP/model/Connection.php");
require_once("PHP/controller/AlertManager.php");
require_once("PHP/model/Alert.php");

$connection = isset($connection) ? $connection : new Connection();
$sManager = SessionManager::getInstance();
if(!isset($_SESSION['user'])){
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
    private $_encryptor;

    private function __construct($encryptor=null){
        $this->_encryptor = $encryptor==null ? new Encryptor() : $encryptor;
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
            if(isset($_SESSION['user']['level']) && isset($_SESSION['user']['pseudo'])) {
                return true;
            }
        }
        http_response_code(401);
        AlertManager::addAlert("Authentification requise", AlertType::DANGER);
        return false;
    }

    //Check if the current session is allowed to perform an action
    public function isAuthorized($requiredLevel){
        if($this->isSessionActive()){
            if($_SESSION['user']['level'] <= $requiredLevel){
                return true;
                AlertManager::addAlert(Label::LEVEL_TOO_LOW, AlertType::DANGER);
            }
        }
        http_response_code(403);
        return false;
    }

    //Log the user
    //TODO check method (imported)
    public function login($connection){
        if(isset($_POST['name'])
            & isset($_POST['password'])){
            $query = $connection->getDB()->prepare(
                "SELECT * FROM User WHERE pseudo=:pseudo");
            $query->bindParam(':pseudo', $_POST['name']);
            $query->execute();
            if($query->rowCount() > 0){
                $row = $query->fetch();
                if($this->_encryptor->checkPassword($_POST['password'], $row['password'])){
                    $_SESSION['user']['pseudo']=$row['pseudo'];
                    $_SESSION['user']['level']=$row['level'];
                    AlertManager::addAlert("Bienvenue ".$row['pseudo']);
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
        AlertManager::addAlert(Label::DISCONNECTED);
    }
}