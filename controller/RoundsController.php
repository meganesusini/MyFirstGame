<?php
// RoundsController.php
require_once("./model/BdPdoConnection.php");
require_once("./model/RoundDAO.php");

class RoundsController 
{
    private $connection;

    public function __construct() {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function r1_saveData() {
        $timeSpent = $_SESSION["r1_time"];
        $triesNb = $_SESSION["r1_tries"];

        // Create a new round
        $newRoundDAO = new RoundDAO($this->connection);

        // create function which select a game first
        $gameId = $_SESSION["myGame"];
        $newRound = new Round($gameId);
        $newRoundDAO->addRound($newRound);
        $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
       
       $_SESSION["myRound"] = $roundId; 
       header('Location: ./view/round2.php');
       exit();
    }
}
?>