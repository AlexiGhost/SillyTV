<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once(__DIR__ . "/../model/Planning.php");
require_once(__DIR__ . "/../model/Connection.php");

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
                $planning[PlanningData::PSEUDO],
                $planning[PlanningData::DAY],
                $planning[PlanningData::GAME],
                $planning[PlanningData::SCHEDULE],
                $planning[PlanningData::ID]
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
                $planning[PlanningData::PSEUDO],
                $planning[PlanningData::DAY],
                $planning[PlanningData::GAME],
                $planning[PlanningData::SCHEDULE],
                $planning[PlanningData::ID]
            ));
        }
        return $plannings;
    }

    public function getAllowedPlanning(int $day = 0){
        if(!isset($sManager)){ $sManager = sessionManager::getInstance(); }
        if($sManager->isAuthorized(GroupData::EDIT_PLANNING_GLOBAL)){
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
        $this->_connection->getDB()->prepare($sql)->execute();
    }

    public function deletePlanning(int $id) {
        $sql = "DELETE FROM planning WHERE id = ".$id;
        $this->_connection->getDB()->prepare($sql)->execute();
    }
}