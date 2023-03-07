<?php
// RoundsController.php
require_once("./model/BdPdoConnection.php");
require_once("./model/RoundDAO.php");
require_once("./model/Round1DAO.php");
require_once("./model/Round2DAO.php");
require_once("./model/Round3DAO.php");
require_once("./model/RankingDAO.php");

class RoundsController 
{
    private $connection;

    public function __construct() 
    {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function r1_saveData() 
    {
        $timeSpent = $_POST["r1_timeSpent"];
        $triesNb = $_POST["r1_triesNb"];
        $found =$_POST["r1_found"];

        // Create a new round
        $newRoundDAO = new RoundDAO($this->connection);
        $newRound = new Round($_SESSION["myGame"]);
        $newRoundDAO->addRound($newRound);

        $_SESSION["myRound"] = $newRoundDAO->getLastRound()[0]; 

        // Create a new round1 and add it
        $newRound1DAO = new Round1DAO($this->connection);
        $newRound1 = new Round1($triesNb, $timeSpent, $found, $_SESSION["myRound"]);
        $newRound1DAO->addRound1($newRound1);
       
       header('Location: ./view/round2.php');
       exit();

    }

    public function r2_saveData() 
    {
        $timeSpent = $_POST["r2_timeSpent"];
        $wordsNb = $_POST["r2_wordsNb"];

        // Create a new round2
        $newRound2DAO = new Round2DAO($this->connection);
        $newRound2 = new Round2($wordsNb, $timeSpent, $_SESSION["myRound"]);
        $newRound2DAO->addRound2($newRound2);
       
        header('Location: ./view/round3.php');
        exit();

    }

    public function r3_saveData() 
    {
        $timeSpent = $_POST["r3_timeSpent"];
        $wordsNb = $_POST["r3_rightAnswers"];

        // Create a new round3
        $newRound3DAO = new Round3DAO($this->connection);
        $newRound3 = new Round3($wordsNb, $timeSpent, $_SESSION["myRound"]);
        $newRound3DAO->addRound3($newRound3);

        // Retrieve each round
        $newRound1DAO = new Round1DAO($this->connection);
        $newRound2DAO = new Round2DAO($this->connection);
        $newRound3DAO = new Round3DAO($this->connection);
        $thisRound1 = $newRound1DAO->selectRound1($_SESSION["myRound"])[0];
        $thisRound2 = $newRound2DAO->selectRound2($_SESSION["myRound"])[0];
        $thisRound3 = $newRound3DAO->selectRound3($_SESSION["myRound"])[0];

        // Create a new ranking
        $newRankingDAO = new RankingDAO($this->connection);
        $pseudo = $_SESSION["myPseudo"];
        $r1_time = $thisRound1["timeSpent"];
        $r2_time = $thisRound2["timeSpent"];
        $r3_time = $thisRound3["timeSpent"];
        $totalTimes = $r1_time + $r2_time + $r3_time;
        $r1_tries = $thisRound1["triesNb"];
        $r2_words = $thisRound2["wordsNb"];
        $r3_rightAnswers = $thisRound3["rightAnswersNb"];
        $r1_found = $thisRound1["found"];

        if ($r1_tries > 15)
        {
            $r1_tries = 15;
        }

        $totalPoints = 15 - $r1_tries + $r2_words + $r3_rightAnswers;
        $newRanking = new Ranking($pseudo, $totalTimes, $totalPoints, $r1_time, $r1_tries, $r1_found, $r2_time, $r2_words, $r3_time, $r3_rightAnswers, $_SESSION["myRound"]);
        $newRankingDAO->addRanking($newRanking);

       header('Location: ./view/ranking.php');
       exit();

    }

}
?>