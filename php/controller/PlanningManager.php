<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once(__DIR__."/../model/Planning.php");
require_once(__DIR__."/../model/Connection.php");

class PlanningManager
{
//VARIABLES
    const Days = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");
    var $_connection;
//CONSTRUCTORS
    public function __construct(Connection $connection){
        $this->_connection = $connection;
    }
//METHODS
    public function dayInLetters($day){
        return self::Days[$day-1];
    }
//GETTERS / SETTERS
    public function getPlannings(bool $currentUserOnly = false){
        $plannings = [];

        $sql = "SELECT * FROM planning";
        if($currentUserOnly)
            $sql = $sql." WHERE pseudo = :user";
        $query = $this->_connection->getDB()->prepare($sql);
        if($currentUserOnly)
            $query->bindParam("user", $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]);
        $query->execute();
        while($planning = $query->fetch()) {
            array_push($plannings, new Planning(
                $planning[PlanningData::PLANNING_PSEUDO],
                $planning[PlanningData::PLANNING_DAY],
                $planning[PlanningData::PLANNING_GAME],
                $planning[PlanningData::PLANNING_SCHEDULE],
                $planning[PlanningData::PLANNING_ID]
            ));
        }
        return $plannings;
    }

    public function getDailyPlannings(int $day, bool $currentUserOnly = false){
        $plannings = [];

        $sql = "SELECT * FROM planning WHERE day = ".$day;
        if($currentUserOnly)
            $sql = $sql." AND pseudo = :user";
        $query = $this->_connection->getDB()->prepare($sql);
        if($currentUserOnly)
            $query->bindParam("user", $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]);
        $query->execute();
        while($planning = $query->fetch()) {
            array_push($plannings, new Planning(
                $planning[PlanningData::PLANNING_PSEUDO],
                $planning[PlanningData::PLANNING_DAY],
                $planning[PlanningData::PLANNING_GAME],
                $planning[PlanningData::PLANNING_SCHEDULE],
                $planning[PlanningData::PLANNING_ID]
            ));
        }
        return $plannings;
    }

    //FIXME use another authorization system
    public function getAllowedPlanning(int $day = 0){
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

    public function getDayCount(int $day, bool $currentUserOnly = false){
        $sql = "SELECT * FROM planning WHERE day = ".$day;
        if($currentUserOnly)
            $sql = $sql." AND pseudo = :user";
        $query = $this->_connection->getDB()->prepare($sql);
        if($currentUserOnly)
            $query->bindParam("user", $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]);
        $query->execute();
        return $query->fetchColumn();
    }

    public function addPlanning(Planning $planning) {
        $sql = "INSERT INTO planning (pseudo, day, game, schedule) VALUES ("
            .$planning->getPseudo().","
            .$planning->getDay().","
            .$planning->getGame().","
            .$planning->getSchedule().")";
        $query = $this->_connection->getDB()->prepare($sql);
        $query->execute();
    }
}