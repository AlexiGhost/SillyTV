<?php
require_once(__DIR__."/../constants/DatabaseInformation.php");
class Connection {
    private $_db;
    
    public function __construct($name = DatabaseInformation::DB_NAME, $user = DatabaseInformation::DB_USER, $password = DatabaseInformation::DB_PASSWORD){
        try {
            $this->_db = new PDO("mysql:host=localhost;dbname=".$name, $user, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    public function getDB(){
        return $this->_db;
    }
}