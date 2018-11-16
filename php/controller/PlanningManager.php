<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once("PHP/model/Planning.php");
require_once("PHP/model/Connection.php");

class PlanningManager
{
//VARIABLES
    const Days = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    var $_connection;
//CONSTRUCTORS
    public function __construct($connection){
        $this->_connection = $connection;
    }
//METHODS
    public function dayInLetters($day){
        return self::Days[$day-1];
    }
//GETTERS / SETTERS
    public function getPlannings($currentUserOnly = false){
        //TODO implement method
        throw new LogicException();
    }

    public function getDailyPlannings($day, $currentUserOnly = false){
        //TODO implement method
        throw new LogicException();
    }

    public function getAllowedPlanning($day = 0){
        if(!isset($sManager)){ $sManager = sessionManager::getInstance(); }
        if($sManager->isAuthorized(2)){
            if($day == 0){
                return $this->getPlannings();
            } else {
                return $this->getDailyPlannings($day);
            }
        } else {
            if($day == 0){
                return $this->getPlannings(true);
            } else {
                return $this->getDailyPlannings($day, true);
            }
        }
    }

    //TODO
    public function getDayCount($day, $currentUserOnly = false){

    }
}