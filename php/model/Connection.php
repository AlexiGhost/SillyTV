<?php
require_once(__DIR__."/../constants/DatabaseInformation.php");
class Connection {
    private $_db;
    
    public function __construct(string $name = DatabaseInformation::DB_NAME, string $password = DatabaseInformation::DB_PASSWORD, string $user = DatabaseInformation::DB_USER){
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