<?php
// RoundsController.php
require_once("./model/BdPdoConnection.php");

class RoundsController 
{
    private $connection;

    public function __construct() {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function saveData() {
        
    }
}
?>