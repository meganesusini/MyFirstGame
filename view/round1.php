<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My First Game</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css" />
</head>
<body>

    <?php
        echo 'Welcome '.$_SESSION["myPseudo"].' in My First Game !';
    ?>

    <p>In this game, you need to be the fastest.</p>
    <p>You have 3 rounds to complete :</p>

    <ul>
        <li>Guess a number generated by the computer the fastest</li>
        <li>Remember as many words as possible in seconds</li>
        <li>Resolve 3 simple calculations as fast as possible</li>
    </ul>

    <h3>FIRST ROUND</h3>
    <p>GUESS A NUMBER</p>
    <p>The number to guess is between 0 and 100 included</p>

    <div id="displayButton">
        <p>You have 1 minute, are you ready ?</p>
        <button onclick="readyButton();">Ready</button> <!-- start a timer (1min) -->
    </div>
    <p id="r1_timer"></p>

    <div id="r1_deleteAfter">
        <input type="text" autofocus id="r1_nb" maxlength="3">
        <!-- onclick button > displays if the user found the right number -->
        <button onclick="findTheNb(document.getElementById('r1_nb').value, randomNb)">Enter</button>
    </div>

    <!-- the span says "more" or "less" or "nb found" -->
    <span id="r1_clue"></span> 

    <!-- go to the next round -->
    <form method="post" id="r1_next" action="../index.php?controller=rounds&action=round1">
        <input type="hidden" name="r1_triesNb" id="r1_triesNb">
        <input type="hidden" name="r1_timeSpent" id="r1_timeSpent">
        <input type="hidden" name="r1_found" id="r1_found">
        <input type="submit" value="Next Round">
    </form>


    <script src="../js/scripts_r1.js"></script>
 </body>
 </html>