<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */
require_once(__DIR__ . "/../model/Alert.php");
//Alerts array init
$_POST['alerts'] = isset($_POST['alerts']) ? $_POST['alerts'] : array();

class AlertManager
{
    public static function addAlert(string $message, string $type)
    {
        array_push($_POST['alerts'], new Alert($message, $type));
    }

    public static function displayAlerts()
    {
        foreach ($_POST['alerts'] as $alert) {
            echo $alert;
        }
        $_POST['alerts'] = array();
    }
}