<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:16
 */

class Utils
{
    public static function redirect($destination="index.php") {
        header('Location: '.$destination);
        exit();
    }
}