<?php
session_start();
require("../model/displayRankings.php");
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
        displayBestPlayers();
    ?>
    <h3>Round1 ranking</h3>
    <?php
        displayRound1Rank();
    ?>
    <h3>Round2 ranking</h3>
    <?php
        displayRound2Rank();
    ?>
    <h3>Round3 ranking</h3>
    <?php
        displayRound3Rank();
    ?>
    <h3>The general ranking</h3>
    <?php
        
        displayRankTable();
        session_destroy();
    ?>
    </body>
    </html>