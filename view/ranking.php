<?php
session_start();
require("../model/BdPdoConnection.php");
require("../model/RankingDAO.php");

$newRankingDAO = new RankingDAO(BdPdoConnection::getConnection());
global $newRankingDAO; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking of the best players</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>There is the ranking of the best players</h2>
    <h3>The best players of the game</h3>
    <?php
        $bestPlayerRanking = $newRankingDAO->getBestPlayerRanking();

        $tableHtml = "<table class='bestPlayersRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TOTAL TIME", "TOTAL POINTS /32"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($bestPlayerRanking); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $bestPlayerRanking[$i]["pseudo"] . "</td>"; // user name
            $tableHtml .= "<td>" . $bestPlayerRanking[$i]["totalTimes"] . " seconds</td>"; // total time
            $tableHtml .= "<td>" . $bestPlayerRanking[$i]["totalPoints"] . " points</td></tr>"; // total points
        }

        $tableHtml .= "</tbody></table>";

        echo $tableHtml;
    ?>
    <h3>Round1 ranking</h3>
    <?php
        $round1Ranking = $newRankingDAO->getRound1Ranking();

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "TRIES", "FOUND"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($round1Ranking); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $round1Ranking[$i]["pseudo"] . "</td>"; // user name
            $tableHtml .= "<td>" . $round1Ranking[$i]["r1_time"] . " seconds</td>"; // round1 time
            $tableHtml .= "<td>" . $round1Ranking[$i]["r1_tries"] . " tries</td>"; // round1 tries
            $tableHtml .= "<td>" . $round1Ranking[$i]["r1_found"] . "</td></tr>"; // found
        }

        $tableHtml .= "</tbody></table>";

        echo $tableHtml;
    ?>
    <h3>Round2 ranking</h3>
    <?php
        $round2Ranking = $newRankingDAO->getRound2Ranking();

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "WORDS FOUND /14"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";

        for ($i = 0; $i < count($round2Ranking); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $round2Ranking[$i]["pseudo"] . "</td>"; // user name
            $tableHtml .= "<td>" . $round2Ranking[$i]["r2_time"] . " seconds</td>"; // round2 time
            $tableHtml .= "<td>" . $round2Ranking[$i]["r2_wordsFound"] . " word(s) found</td></tr>"; // round2 words found
        }
        $tableHtml .= "</tbody></table>";
        echo $tableHtml;
    ?>
    <h3>Round3 ranking</h3>
    <?php
        $round3Ranking = $newRankingDAO->getRound3Ranking();

        $tableHtml = "<table class='roundsRankTable'><thead><tr>";
        $headers = ["TOP", "USER NAME", "TIME", "RIGHT ANSWERS /3"];

        for ($i = 0; $i < count($headers); $i++) {
            $tableHtml .= "<th>" . strval($headers[$i]) . "</th>";
        }

        $tableHtml .= "</tr></thead><tbody>";
        for ($i = 0; $i < count($round3Ranking); $i++) {
            $tableHtml .= "<tr><td>" . strval($i+1) . "</td>"; // top
            $tableHtml .= "<td>" . $round3Ranking[$i]["pseudo"] . "</td>"; // user name
            $tableHtml .= "<td>" . $round3Ranking[$i]["r3_time"] . " seconds</td>"; // round3 time
            $tableHtml .= "<td>" . $round3Ranking[$i]["r3_rightAnswers"] . " right answer(s)</td></tr>"; // round3 right answers
        }

        $tableHtml .= "</tbody></table>";
        
        echo $tableHtml;

        session_destroy();
    ?>
    </body>
    </html>