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
    <h3>SECOND ROUND</h3>
    <p>MEMORIZE ALL THE WORDS</p>

    <?php
        $seconds = 10;
        echo '<p>You have '.$seconds.' seconds to memorize all the words you can.</p>';
    ?>

    <div id="r2_ready">
        <p>Are you ready ? Press the button !</p>
        <button onclick="readyButton();">Ready</button> <!-- displays the timer and the array with the words to memorize -->
        <span id="r2_timer"></span> <!-- displays the timer -->
        <table id="r2_tableId"></table> <!-- displays the array with the words to memorize -->
    </div>

    <div id="r2_timeUp">

        <div id="r2_timeUp1">
            <p>Time up! Write all the words you have memorized.</p>
            <p>Write each word, one by one.</p>
            <input type="text" id="r2_input-user-word" autofocus> <!-- input > user write a word -->
            <button onclick="displayUserWords();">Submit</button> <!-- button which displays each word written by the user -->
            <p id="r2_display-user-word"></p> <!-- displays a word -->
        </div>

        <table id="r2_userTable"></table> <!-- displays all the words wrote by the user -->

        <div id="r2_timeUp2">
            <p>If you have finished, press the Terminate button.</p>
            <button onclick="terminateButton();">Terminate</button> <!-- button which displays the array with all the words to memorize -->
        </div>

        <p id="r2_p-wordsToFind">There is the words to find :</p>
        <table id="r2_words-to-memorize"></table> <!-- array with all the words to memorize -->
        <p id="r2_result"></p> <!-- displays the result of the game -->
    </div>
    <form id="r2_round3" action="round3.php"><input type="submit" value="Next Round"></form>

    <script src="../js/scripts_r2.js"></script>
</body>
</html>