<?php
// RankingController.php
require_once("./model/BdPdoConnection.php");
require_once("./model/PlayerDAO.php");
require_once("./model/GameDAO.php");
require_once("./model/RoundDAO.php");
require_once("./model/Round1DAO.php");
require_once("./model/Round2DAO.php");
require_once("./model/Round3DAO.php");

class RankingController 
{
    private $connection;

    public function __construct() {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function displayRank() {
        $tableHtml = "<thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32", "ROUND1 : TIME", "ROUND1 : TRIES", "ROUND2 : TIME", "ROUND2 : WORDS FOUND /14", "ROUND3 : TIME", "ROUND3 : RIGHT ANSWERS"];
        
        // get the players
        $newPlayerDAO = new PlayerDAO($this->connection);
        $players = $newPlayerDAO->getAllPlayers();

        $newGameDAO = new GameDAO($this->connection);
        $newRoundDAO = new RoundDAO($this->connection);
        $newRound1DAO = new Round1DAO($this->connection);
        $newRound2DAO = new Round2DAO($this->connection);
        $newRound3DAO = new Round3DAO($this->connection);

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml += "<table><th>" + $headers[$i] + "</th>";
        }

        $tableHtml += "</tr></thead><tbody>";


        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml += "<tr><td>" + strval($i) + "</td>"; // top
            $tableHtml += "<tr><td>" + $players[$i]["pseudo"] + "</td>"; // user name
            // total time
            $gameId = $newGameDAO->selectGame($players[$i]["pseudo"])[0]["MAX(id)"];
            $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
            $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
            $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
            $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
            $totalTime = $round1Time + $round2Time + $round3Time;

            $tableHtml += "<td>" + strval($totalTime) + "</td>";

            // total points
            $round1Tries = $newRound1DAO->selectRound1($roundId)[0]["triesNb"]; // /15
            $round2WordsNb = $newRound2DAO->selectRound2($roundId)[0]["wordsNb"]; // /14
            $round3RightAnswers = $newRound3DAO->selectRound3($roundId)[0]["rightAnswersNb"]; // /3
            if ($round1Tries > 15)
            {
                $round1Tries = 15;
            }
            $totalPoints = $round2WordsNb + $round3RightAnswers + (15 - $round1Tries);

            $tableHtml += "<td>" + strval($totalPoints) + "</td>";

            $tableHtml += "<td>" + strval($round1Time) + "</td></tr>"; // round1 time
            $tableHtml += "<td>" + strval($round1Tries) + "</td></tr>"; // round1 tries
            $tableHtml += "<td>" + strval($round2Time) + "</td></tr>"; // round2 time
            $tableHtml += "<td>" + strval($round2WordsNb) + "</td></tr>"; // round2 words found
            $tableHtml += "<td>" + strval($round3Time) + "</td></tr>"; // round3 time
            $tableHtml += "<td>" + strval($round3RightAnswers) + "</td></tr>"; // round3 right answers
    
        }
        $tableHtml += "</tbody></table></body></html>";
        echo $tableHtml;
        include("view/")
    }

}
?>