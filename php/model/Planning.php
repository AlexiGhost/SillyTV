<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:14
 */

class Planning
{
//Variables
    private $_id;
    private $_userPseudo;
    private $_day;
    private $_game;
    private $_schedule;
//Constructors
    public function __construct($pseudo, $day, $game, $schedule, $id = 0) {
        $this->setID($id);
        $this->setUserPseudo($pseudo);
        $this->setDay($day);
        $this->setGame($game);
        $this->setSchedule($schedule);
    }
//Methods
    public function __toString(){
        //TODO implement method
        throw new LogicException("not implemented");
        return "not implemented";
    }
//Getters / Setters
    public function getID(){
        return $this->_id;
    }
    public function setID($id){
        $this->_id = $id;
    }

    public function getUserPseudo(){
        return $this->_userPseudo;
    }
    public function setUserPseudo($pseudo){
        $this->_userPseudo = $pseudo;
    }

    public function getDay(){
        return $this->_day;
    }
    public function setDay($day){
        $this->_day = $day;
    }

    public function getGame(){
        return $this->_game;
    }
    public function setGame($game){
        $this->_game = $game;
    }

    public function getSchedule(){
        return $this->_schedule;
    }
    public function setSchedule($schedule){
        $this->_schedule = $schedule;
    }
}