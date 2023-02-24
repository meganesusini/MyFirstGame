<?php
session_start();
if (!isset($_SESSION['wordsYouFoundArray'])) {
    // If the session variable doesn't exist, generate a new empty array
    $_SESSION['wordsYouFoundArray'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My First Game</title>
    <style>
        tr, td {
        border: 1px solid;
        }

        td {
            width:80px;
        }

        #timeUp, #p-wordsToFind, form {
            display:none;
            margin-top:0;
        }

    </style>
</head>
<body>
    <h2>MY FIRST GAME</h2>
    <h3>SECOND ROUND</h3>
    <p>MEMORIZE ALL THE WORDS</p>
    <?php
        $seconds = 10;
        echo '<p>You have '.$seconds.' seconds to memorize all the words you can.</p>';
    ?>

    <div id="ready">
        <p>Are you ready ? Press the button !</p>
        <button onclick="readyButton();">Ready</button> <!-- displays the timer and the array with the words to memorize -->
        <span id="timer"></span> <!-- timer -->
        <table id="tableId"></table> <!-- array with the words to memorize -->
    </div>

    <div id="timeUp">
        <div id="timeUp1">
            <p>Time up! Write all the words you have memorized.</p>
            <p>Write each word, one by one.</p>
            <input type="text" id="input-user-word" autofocus> <!-- input > user write a word -->
            <button onclick="displayUserWords();">Submit</button> <!-- button which displays each word written by the user -->
            <p id="display-user-word"></p> <!-- displays a word -->
        </div>
        <table id="userTable"></table> <!-- displays all the words wrote by the user -->

        <div id="timeUp2">
            <p>If you have finished, press the Terminate button.</p>
            <button onclick="terminateButton();">Terminate</button> <!-- button which displays the array with all the words to memorize -->
        </div>
        <p id="p-wordsToFind">There is the words to find :</p>
        <table id="words-to-memorize"></table> <!-- array with all the words to memorize -->
        <p id="result"></p> <!-- displays the result of the game -->
    </div>
    <form id="round3" action="round3.php"><input type="submit" value="Next Round"></form>

    <!-- SCRIPT -->
    <script type="text/javascript">
        let userWordsArray = new Array();
        var wordsArray = ["apple", "banana", "cherry", "orange", "pear", "grape", "watermelon", "pineapple", "mango", "peach", "plum", "kiwi", "strawberry", "blueberry"];

        // displays the timer and the array with the words to memorize
        function readyButton() 
        {
            displayTimer();
            displayTable("tableId");
        }

        function terminateButton()
        {
            displayTable('words-to-memorize');
            document.getElementById("timeUp1").style.display="none";
            document.getElementById("timeUp2").style.display="none";
            document.getElementById("round3").style.display="block";
        }
        
        
        function displayTimer() 
        {
            var secondsLeft = 2; //TEST
            document.getElementById("timer").textContent = 10;
            var countdown = setInterval(function() {
                secondsLeft--;
                document.getElementById("timer").textContent = secondsLeft;
                if (secondsLeft <= 0) {
                    clearInterval(countdown);
                    document.getElementById("timeUp").style.display="block"; // if timer = 0 -> display div
                    document.getElementById("ready").style.display="none"; // if timer = 0 -> remove div
                }
            }, 1000);
        }

        // event > when the user press the enter button
        document.getElementById('input-user-word').addEventListener('keydown', function(event) 
        {
            if (event.key === 'Enter') 
            {
                if(document.getElementById('input-user-word').value.length != 0)
                {
                    inputWord = document.getElementById('input-user-word');
                    displayWord = document.getElementById('display-user-word');
                    
                    // error if the user entered a word which was already entered before
                    if (userWordsArray.includes(inputWord.value)) {
                        displayWord.textContent = "ERROR : You have already written this word.";
                    // displays an array with the words entered by the user
                    } else {
                        displayWord.textContent = inputWord.value;
                        userWordsArray.push(inputWord.value);
                        displayTable("userTable");
                    }

                    inputWord.value = "";
                }
            }
        });

        // onclick button > displays all the words 
        function displayUserWords()
        {
            if(document.getElementById('input-user-word').value.length != 0)
            {
                inputWord = document.getElementById('input-user-word');
                displayWord = document.getElementById('display-user-word');
                
                // error if the user entered a word which was already entered before
                if (userWordsArray.includes(inputWord.value)) {
                    displayWord.textContent = "ERROR : You have already written this word.";
                
                // displays an array with the words entered by the user
                } else {
                    displayWord.textContent = inputWord.value;
                    userWordsArray.push(inputWord.value);
                    displayTable("userTable");
                }

                inputWord.value = "";
            }
        }

        // displays the array with the words entered by the user
        // or the array with all the words to memorize 
        function displayTable(tableId) 
        {
            // create the user array
            let tableHtml = "<tr>";
            if (tableId == "userTable")
            {
                if (userWordsArray.length < 7)
                {
                    for (let i = 0; i < userWordsArray.length; i++) 
                    {
                        tableHtml += "<td>" + userWordsArray[i] + "</td>";
                    }
                }
                else if (userWordsArray.length < 14)
                {
                    for (let i = 0; i < 7; i++) 
                    {
                        tableHtml += "<td>" + userWordsArray[i] + "</td>";
                        tableHtml += "</tr><tr>";
                    }
                    for (let i = 7; i < userWordsArray.length; i++) 
                    {
                        tableHtml += "<td>" + userWordsArray[i] + "</td>";
                    }   
                }
            }
            // create the array with all the words
            else
            {
                for (let i = 0; i < 7; i++) {
                    tableHtml += "<td>" + wordsArray[i] + "</td>";
                }
                tableHtml += "</tr><tr>";
                for (let i = 7; i < 14; i++) {
                    tableHtml += "<td>" + wordsArray[i] + "</td>";
                }

                // displays the sentence
                if (tableId == "words-to-memorize") 
                {
                    document.getElementById("p-wordsToFind").style.display="block";
                }
            }

            // displays the array
            tableHtml += "</tr>";
            document.getElementById(tableId).innerHTML = tableHtml;
            if (tableId == "userTable")
            {
                if (userWordsArray.length == 0)
                {
                    document.getElementById(tableId).style.display = "none";   
                }
            }

            // displays the result of the game
            if (tableId == "words-to-memorize") 
            {
                gameResult();
            }
        }

        // calculation of the score and return the result
        function gameResult()
        {
            let score = 0;
            let result;
            for (let i=0; i<userWordsArray.length; i++)
            {
                if (wordsArray.includes(userWordsArray[i]))
                {
                    score++;
                }
            }
            if (score != 0)
            {
                if (score == 1)
                {
                    result = "Good job ! You found 1 word !";
                }
                else if (score == 14)
                {
                    result = "Great ! You found all the words !";
                }
                else
                {
                    result = "Good job ! You found " + score + " words !";
                }
            }
            else
            {
                result = "Oh no ! You didn't find any words !";
            }
            document.getElementById("result").textContent = result;
        }
        
    </script>

    <!--
    echo '<span>';
    if(isset($_POST["submit_word"])) {
        array_push($_SESSION["wordsYouFoundArray"], $_POST["input-user-word"]);
        echo $_SESSION["wordsYouFoundArray"][count($_SESSION["wordsYouFoundArray"])-1];
    }
    echo '</span>';
    
    if(isset($_POST["terminate"])) {
        for ($i = 0; $i < count($_SESSION["wordsYouFoundArray"]); $i++) {
            echo $_SESSION["wordsYouFoundArray"][$i];
        }
    }
    
    /*
    PROBLEMS
    div appears &b disapears at the bad time
    session_unset()
    session_destroy()
    */
    
   
    ?> -->
</body>
</html>