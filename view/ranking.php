<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking of the best players</title>
</head>
<body>
    <h3>There is the ranking of the best players</h3>
    <?php
        require("../model/BdPdoConnection.php");
        require("../model/PlayerDAO.php");
        require("../model/GameDAO.php");
        require("../model/RoundDAO.php");
        require("../model/Round1DAO.php");
        require("../model/Round2DAO.php");
        require("../model/Round3DAO.php");      
        
        $newPlayerDAO = new PlayerDAO(BdPdoConnection::getConnection());
        $newGameDAO = new GameDAO(BdPdoConnection::getConnection());
        $newRoundDAO = new RoundDAO(BdPdoConnection::getConnection());
        $newRound1DAO = new Round1DAO(BdPdoConnection::getConnection());
        $newRound2DAO = new Round2DAO(BdPdoConnection::getConnection());
        $newRound3DAO = new Round3DAO(BdPdoConnection::getConnection());

        // get the players
        $players = $newPlayerDAO->getAllPlayers(); // ok

        // test
        // echo "Number of players = " . count($players) . "<br>";
        // echo "<br>Each players (pseudos) : <br>";
        // for ($i=0;$i<count($players);$i++)
        // {
        //     echo $players[$i]["pseudo"] . "<br>";
        // }
        
        // $gameId = $newGameDAO->selectGame($players[0]["id"])[0]["MAX(id)"];
        // echo "<br>Game id = " . $gameId . "<br>";
        // end

        $tableHtml = "<table><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32", "ROUND1 : TIME", "ROUND1 : TRIES", "ROUND2 : TIME", "ROUND2 : WORDS FOUND /14", "ROUND3 : TIME", "ROUND3 : RIGHT ANSWERS"];

        // add the headers
        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($players); $i++) {
            $tableHtml .= "<tr><td>" . strval($i) . "</td>"; // top
            $tableHtml .= "<td>" . $players[$i]["pseudo"] . "</td>"; // user name
            // total time
            $gameId = $newGameDAO->selectGame($players[$i]["id"])[0]["MAX(id)"];
            $roundId = $newRoundDAO->selectRound($gameId)[0]["id"];
            $round1Time = $newRound1DAO->selectRound1($roundId)[0]["timeSpent"];
            $round2Time = $newRound2DAO->selectRound2($roundId)[0]["timeSpent"];
            $round3Time = $newRound3DAO->selectRound3($roundId)[0]["timeSpent"];
            $totalTime = $round1Time + $round2Time + $round3Time;

            $tableHtml .= "<td>" . strval($totalTime) . "</td>";

            // total points
            $round1Tries = $newRound1DAO->selectRound1($roundId)[0]["triesNb"]; // /15
            $round2WordsNb = $newRound2DAO->selectRound2($roundId)[0]["wordsNb"]; // /14
            $round3RightAnswers = $newRound3DAO->selectRound3($roundId)[0]["rightAnswersNb"]; // /3
            if ($round1Tries > 15)
            {
                $round1Tries = 15;
            }
            $totalPoints = $round2WordsNb + $round3RightAnswers + (15 - $round1Tries);

            $tableHtml .= "<td>" . strval($totalPoints) . "</td>";

            $tableHtml .= "<td>" . strval($round1Time) . "</td>"; // round1 time
            $tableHtml .= "<td>" . strval($round1Tries) . "</td>"; // round1 tries
            $tableHtml .= "<td>" . strval($round2Time) . "</td>"; // round2 time
            $tableHtml .= "<td>" . strval($round2WordsNb) . "</td>"; // round2 words found
            $tableHtml .= "<td>" . strval($round3Time) . "</td>"; // round3 time
            $tableHtml .= "<td>" . strval($round3RightAnswers) . "</td></tr>"; // round3 right answers
    
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    ?>
    </body>
    </html>