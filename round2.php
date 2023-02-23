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
        table, td {
        border: 1px solid;
        }

        td {
            width:80px;
        }

        #timeUp, #wordsToFind {
            display:none;
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
        <button onclick="displayAll();">Ready</button>
        <span id="timer"></span>
        <table id="tableId"></table>
    </div>
    <div id="timeUp">
        <p>Time up! Write all the words you have memorized.</p>
        <p>Write each word, one by one.</p>
        <input type="text" id="word-found">
        <button onclick="displayAWordFound();">Submit</button>
        <p id="aWordFound"></p>
        <table id="userTable"></table>
        <p>If you have finished, press the Terminate button.</p>
        <button onclick="displayTable('originalTable');">Terminate</button>
        <p id="wordsToFind">There is the words to find :</p>
        <table id="originalTable"></table>
    </div>

    <script type="text/javascript">
        function displayAll() {
            displayTimer();
            displayTable("tableId");
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

        let userWordsArray = new Array();

        document.getElementById('word-found').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('aWordFound').textContent = document.getElementById('word-found').value;
                userWordsArray.push(document.getElementById('aWordFound').textContent);
                console.log("key");
                console.log(userWordsArray);
                displayTable("userTable");
            }
        });

        function displayAWordFound()
        {
            if(document.getElementById('word-found').value.length != 0)
            {
                document.getElementById('aWordFound').textContent = document.getElementById('word-found').value;
                userWordsArray.push(document.getElementById('aWordFound').textContent);
                console.log("button");
                console.log(userWordsArray);
                displayTable("userTable");


            }
        }

        function displayTable(tableId) 
        {
            if (tableId == "userTable")
            {
                var tableHtml = "<tr>";
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
                    for (let i = 7; i < userWordsArray.length; i++) 
                    {
                        tableHtml += "<td>" + userWordsArray[i] + "</td>";
                    }   
                    }
                }
                tableHtml += "</tr>";
            }
            else
            {
                var wordsArray = ["apple", "banana", "cherry", "orange", "pear", "grape", "watermelon", "pineapple", "mango", "peach", "plum", "kiwi", "strawberry", "blueberry"];

                var tableHtml = "<tr>";
                for (var i = 0; i < 7; i++) {
                    tableHtml += "<td>" + wordsArray[i] + "</td>";
                }
                tableHtml += "</tr><tr>";
                for (var i = 7; i < 14; i++) {
                    tableHtml += "<td>" + wordsArray[i] + "</td>";
                }
                tableHtml += "</tr>";

                if (tableId == "originalTable") 
                {
                    document.getElementById("wordsToFind").style.display="block";
                }
            }
            document.getElementById(tableId).innerHTML = tableHtml;
        }
        


    </script>

    <!--
    echo '<span>';
    if(isset($_POST["submit_word"])) {
        array_push($_SESSION["wordsYouFoundArray"], $_POST["word-found"]);
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