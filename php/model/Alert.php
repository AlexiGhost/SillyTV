<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

class AlertType
{
    const SUCCESS = "success";
    const INFO = "info";
    const WARNING = "warning";
    const DANGER = "danger";

    public static function isAlertType(string $type)
    {
        switch ($type){
            case self::SUCCESS:
                break;
            case self::INFO:
                break;
            case self::WARNING:
                break;
            case self::DANGER:
                break;
            default:
                return false;
        }
        return true;
    }
}

class Alert
{
//VARIABLES
    private $_type;
    private $_message;
    //CONSTRUCTORS
    public function __construct(string $message, string $type) {
        $this->setAlertType($type);
        $this->setMessage($message);
    }
    //METHODS
    public function __tostring() {
        return
            '<div class="alert alert-'.$this->_type.' alert dismissible fade show" role="alert">'
                .$this->_message
                .'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>'
            .'</div>';
    }
    //Getters/Setters
    public function getMessage() {
        return $this->_message;
    }
    public function setMessage(string $message) {
        $this->_message = $message;
    }
    public function getAlertType() {
        return $this->_type;
    }
    public function setAlertType(string $type) {
        if(AlertType::isAlertType($type)) {
            $this->_type = $type;
        } else {
            throw new InvalidArgumentException();
        }
    }
}