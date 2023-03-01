<?php
// RoundsController.php
require_once("./model/BdPdoConnection.php");
require_once("./model/RoundDAO.php");
require_once("./model/Round1DAO.php");
require_once("./model/Round2DAO.php");

class RoundsController 
{
    private $connection;

    public function __construct() {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function r1_saveData() {
        $timeSpent = $_POST["r1_timeSpent"];
        $triesNb = $_POST["r1_triesNb"];

        // Create a new round
        $newRoundDAO = new RoundDAO($this->connection);
        $newRound = new Round($_SESSION["myGame"]);
        $newRoundDAO->addRound($newRound);

        $_SESSION["myRound"] = $newRoundDAO->getLastRound()[0]; 

        // Create a new round1
        $newRound1DAO = new Round1DAO($this->connection);
        $newRound1 = new Round1($triesNb, $timeSpent, $_SESSION["myRound"]);
        $newRound1DAO->addRound1($newRound1);
       
       header('Location: ./view/round2.php');
       exit();
    }

    public function r2_saveData() {
        $timeSpent = $_POST["r2_timeSpent"];
        $wordsNb = $_POST["r2_wordsNb"];

        // Create a new round
        $newRoundDAO = new RoundDAO($this->connection);
        $newRound = new Round($_SESSION["myGame"]);
        $newRoundDAO->addRound($newRound);

        $_SESSION["myRound"] = $newRoundDAO->getLastRound()[0]; 

        // Create a new round2
        $newRound2DAO = new Round2DAO($this->connection);
        $newRound2 = new Round2($wordsNb, $timeSpent, $_SESSION["myRound"]);
        $newRound2DAO->addRound2($newRound2);
       
       header('Location: ./view/round3.php');
       exit();
    }

    public function r3_saveData() {
        $timeSpent = $_POST["r3_timeSpent"];
        $wordsNb = $_POST["r3_rightAnswers"];

        // Create a new round
        $newRoundDAO = new RoundDAO($this->connection);
        $newRound = new Round($_SESSION["myGame"]);
        $newRoundDAO->addRound($newRound);

        $_SESSION["myRound"] = $newRoundDAO->getLastRound()[0]; 

        // Create a new round3
        $newRound3DAO = new Round3DAO($this->connection);
        $newRound3 = new Round3($wordsNb, $timeSpent, $_SESSION["myRound"]);
        $newRound3DAO->addRound3($newRound2);
       
       header('Location: ./view/ranking.php');
       exit();
    }
}
?>