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
    <h2>MY FIRST GAME</h2>
    <h3>THIRD ROUND</h3>
    <p>RESOLVE 3 CALCULATIONS</p>
    <p>You have to resolve the 3 calculations as fast as possible.</p>

    <div id="r3_ready">
        <p>You have 1 minute maximum.</p>
        <p>Are you ready ? Press the button !</p>
        <button onclick="readyButton();">Ready</button> <!-- displays a timer and the calculations one by one -->
    </div>

    <span id="r3_timer"></span> <!-- displays the timer -->

    <div id="r3_display-calc"> 
        <p id="r3_sentence"></p> <!-- displays > Calculation n°x :" --> 
        <span id="r3_calc"></span> <!-- displays the calculation -->
    </div>

    <div id="r3_user">
        <p>Your answer : </p>
        <input type="text" id="r3_user-answer" autofocus maxlength="3"> <!-- the user write his answer -->
        <!-- button which save the user answer, the calc result and the calculation -->
        <button onclick="calculate(document.getElementById('r3_calc').textContent, document.getElementById('r3_user-answer').value);">Submit</button>
        <p id="r3_error-msg"></p> <!-- displays an error msg if the user write an NaN -->
    </div>

    <div id="r3_results">
        <!-- button which displays an array with the results of this round -->
        <button id="r3_res-button" onclick="seeResults();">See the results</button>
        <table id="r3_resTable"></table> <!-- array with the results -->
        <p id="r3_sentence2"></p> <!-- says if the user won or not -->
    </div>

    <form method="post" action="../index.php?controller=rounds&action=round3" id="r3_nextPage">
        <input type="hidden" id="r3_timeSpent" name="r3_timeSpent">
        <input type="hidden" id="r3_rightAnswers" name="r3_rightAnswers">
        <input type="submit" value="Next Page">
    </form>
    
    <script src="../js/scripts_r3.js"> </script>