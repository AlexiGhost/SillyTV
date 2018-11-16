<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

class AlertType extends SplEnum
{
    const SUCCESS = "success";
    const INFO = "info";
    const WARNING = "warning";
    const DANGER = "danger";

    public static function isAlertType($type) {
        try {
            new AlertType($type);
            return true;
        } catch (UnexpectedValueException $uve) {
            return false;
        }
    }
}

class Alert
{
//VARIABLES
    private $_type;
    private $_message;
    //CONSTRUCTORS
    public function __construct($message, $type = AlertType::INFO) {
        $this->setAlertType($type);
        $this->setMessage($message);
    }
    //METHODS
    public function __tostring() {
        //TODO implement method
        throw new LogicException();
        return "";
    }
    //Getters/Setters
    public function getMessage() {
        return $this->_message;
    }
    public function setMessage($message) {
        $this->_message = $message;
    }
    public function getAlertType() {
        return $this->_type;
    }
    public function setAlertType($type) {
        if(AlertType::isAlertType($type)) {
            $this->_type = $type;
        } else {
            throw new InvalidArgumentException();
        }
    }
}