<?php
/**
 * Created by PhpStorm.
 * User: whitedumb
 * Date: 15/11/2018
 * Time: 23:14
 */

class Article
{
//Variables
    private $_id;
    private $_author;
    private $_title;
    private $_content;
    private $_creationDate;
//Constructors
    public function __construct($author, $title, $content, $creationDate, $id = 0) {
        $this->setID($id);
        $this->setAuthor($author);
        $this->setTitle($title);
        $this->setContent($content);
        $this->setCreationDate($creationDate);
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

    public function getAuthor(){
        return $this->_author;
    }
    public function setAuthor($author){
        $this->_author = $author;
    }

    public function getTitle(){
        return $this->_title;
    }
    public function setTitle($title){
        $this->_title = $title;
    }

    public function getContent(){
        return html_entity_decode($this->_content);
    }
    public function setContent($content){
        $this->_content = $content;
    }

    public function getCreationDate(){
        return date("j-m-Y \à G:i\h",strtotime($this->_creationDate));
    }
    public function setCreationDate($creationDate){
        $this->_creationDate = $creationDate;
    }
}