<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:27
 */

require_once(__DIR__ . "/../model/Article.php");
require_once(__DIR__ . "/../model/Connection.php");
require_once(__DIR__ . "/SessionManager.php");

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
        $articles = [];

        $sql = "SELECT * FROM article";
        if($currentUserOnly)
        $sql = $sql." WHERE author = :user";
        if($limit != 0)
        $sql = $sql." LIMIT ".$limit;
        $query = $this->_connection->getDB()->prepare($sql);
        if($currentUserOnly)
            $query->bindParam("user", $_SESSION[SessionData::USER][SessionData::USER_PSEUDO]);
        $query->execute();
        while($article = $query->fetch()){
            array_push($articles, new Article(
                $article[ArticleData::AUTHOR],
                $article[ArticleData::TITLE] ,
                $article[ArticleData::CONTENT],
                $article[ArticleData::CREATION_DATE],
                $article[ArticleData::ID]));
        }

        return $articles;
    }

    //Administration
    public function getAllowedArticles() {
        $sManager = SessionManager::getInstance();
        if($sManager->isAuthorized(GroupData::EDIT_ARTICLE_GLOBAL)){
            return $this->getArticles();
        } else {
            return $this->getArticles(true);
        }
    }

    //Display
    public function getRecentArticles() {
        return $this->getArticles(false, 10);
    }

    public function addArticle(Article $article) {
        $sql = "INSERT INTO article (author, title, content, creation_date) VALUES ("
            .$article->getAuthor().","
            .$article->getTitle().","
            .$article->getContent().","
            .$article->getCreationDate().")";
        $this->_connection->getDB()->prepare($sql)->execute();
    }

    public function deleteArticle(int $id) {
        $sql = "DELETE FROM article WHERE id = ".$id;
        $this->_connection->getDB()->prepare($sql)->execute();
    }
}