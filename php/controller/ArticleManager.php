<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once("PHP/model/AArticle.php");
require_once("PHP/model/Connection.php");
require_once("PHP/controller/SessionManager.php");

class ArticleManager
{
//VARIABLES
    private $_connection;

//CONSTRUCTORS
    public function __construct($connection){
        $this->_connection = $connection;
    }

//GETTERS / SETTERS
    private function getArticles($currentUserOnly = false, $limit = null){
        //TODO implement method
        throw new LogicException();
    }

    //Administration
    public function getAllowedArticles() {
        if($sManager->isAuthorized(2)){
            return getArticles();
        } else {
            return getArticles(true);
        }
    }

    //Display
    public function getRecentArticles() {
        return $this->getArticles(false, 10);
    }
}