<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */
require_once(__DIR__ . "/../model/Alert.php");
//Alerts array init
$_SESSION[SessionData::ALERTS] = isset($_SESSION[SessionData::ALERTS]) ? $_SESSION[SessionData::ALERTS] : array();

class AlertManager
{
    public static function addAlert(string $message, string $type)
    {
        array_push($_SESSION[SessionData::ALERTS], new Alert($message, $type));
    }

    /**Display all the alerts and clear the list*/
    public static function displayAlerts()
    {
        foreach ($_SESSION[SessionData::ALERTS] as $alert) {
            echo $alert;
        }
        $_SESSION[SessionData::ALERTS] = array();
    }
}