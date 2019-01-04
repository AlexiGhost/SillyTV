<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once(__DIR__."/../model/Article.php");
require_once(__DIR__."/../model/Connection.php");
require_once(__DIR__."/SessionManager.php");

class ArticleManager
{
//VARIABLES
    private $_connection;

//CONSTRUCTORS
    public function __construct(Connection $connection){
        $this->_connection = $connection;
    }

//GETTERS / SETTERS
    private function getArticles(bool $currentUserOnly = false, int $limit = null){
        //TODO implement method
        $articles = [];

        $sql = "SELECT * FROM article";
        if($currentUserOnly)
        $sql = $sql." WHERE author = :user";
        if($limit != 0)
        $sql = $sql." LIMIT ".$limit;
        $query = $this->_connection->getDB()->prepare($sql);
        $query->bindParam("user", $_SESSION[SessionData::USER_ID]);
        $query->execute();
        while($article = $query->fetch()){
            array_push($articles, new Article(
                $article[ArticleData::ARTICLE_AUTHOR],
                $article[ArticleData::ARTICLE_TITLE] ,
                $article[ArticleData::ARTICLE_CONTENT],
                $article[ArticleData::ARTICLE_CREATION_DATE],
                $article[ArticleData::ARTICLE_ID]));
        }

        return $articles;
    }

    //Administration
    public function getAllowedArticles() {
        $sManager = SessionManager::getInstance();
        if($sManager->isAuthorized(2)){
            return $this->getArticles();
        } else {
            return $this->getArticles(true);
        }
    }

    //Display
    public function getRecentArticles() {
        return $this->getArticles(false, 10);
    }
}