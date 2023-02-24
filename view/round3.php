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
    <style>
        #user, #results, form {
            display:none;
        }
        tr, td, th {
        border: 1px solid;
        }

        td, th{
            width:80px;
        }
    </style>
</head>
<body>
    <h2>MY FIRST GAME</h2>
    <h3>THIRD ROUND</h3>
    <p>RESOLVE 3 CALCULATIONS</p>
    <p>You have to resolve the 3 calculations as fast as possible.</p>
    <p>You have 5 minutes maximum.</p>
    <div id="ready">
        <p>Are you ready ? Press the button !</p>
        <button onclick="readyButton();">Ready</button> <!-- displays a timer and the calculations one by one -->
    </div>
    <span id="timer"></span>
    <div id="display-calc">
        <p id="sentence"></p>
        <span id="calc"></span>
    </div>
    <div id="user">
        <p>Your answer : </p>
        <input type="text" id="user-answer">
        <button onclick="calculate(document.getElementById('calc').textContent, document.getElementById('user-answer').value);">Submit</button>
        <p id="error-msg"></p>
    </div>
    <div id="results">
        <button id="res-button" onclick="seeResults();">See the results</button>
        <table id="resTable"></table>
        <p id="sentence2"></p>
    </div>
    <form action="" id="nextPage"><input type="submit" value="Next Page"></form>
    


    <script type="text/javascript">
        let calculations = new Array();
        let calcResults = new Array();
        let u_calcResults = new Array();

        let randomNb1;
        let randomNb2;
        let symbol;
        const symbols = ['+', '-', 'x'];
        let calcNb = 0;

        let inputUserAnswer = document.getElementById('user-answer');
        let spanTimer = document.getElementById("timer");
        let divUser = document.getElementById("user");
        let spanCalc = document.getElementById("calc");

        function readyButton()
        {
            // DISPLAYS TIMER (5MIN)
                timer(1);

            // DISPLAYS CALCULATIONS
                displayCalc();
                // remove div#ready
                document.getElementById("ready").style.display="none";

        }

        function timer(stop)
        {
            spanTimer.textContent = "5:00";
            // Define the countdown duration in seconds
            let countdownDuration = 5 * 60;

            // Definition of the function to display the countdown
            function displayCountdown() {
            const minutes = Math.floor(countdownDuration / 60);
            const seconds = countdownDuration % 60;
            spanTimer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }

            // Start the countdown every seconds
            let countdownInterval = setInterval(function() {
            countdownDuration--;
            displayCountdown();
            
            // Stop the countdown is the duration is reached
            if (countdownDuration < stop) {
                clearInterval(countdownInterval);
            }
            }, 1000);
        }

        function displayCalc()
        {
            // displays calc sentence
            calcNb++;
            document.getElementById("sentence").textContent = "Calculation n°" + calcNb.toString() + " :";

            // displays calc
            randomNb1 = Math.floor(Math.random() * 10);
            randomNb2 = Math.floor(Math.random() * 10);
            symbol = symbols[calcNb-1];

            spanCalc.textContent = randomNb1.toString() + " " + symbol.toString() + " " + randomNb2.toString();
            divUser.style.display="block";

            
        }
        inputUserAnswer.addEventListener('keydown', function(event) 
        {
            if (event.key === 'Enter') 
            {
                calculate(spanCalc.textContent, inputUserAnswer.value);
            }
        });
        
        function calculate(calculation, userAnswer)
        {
            if(inputUserAnswer.value.length != 0)
            {
                if (isNaN(inputUserAnswer.value))
                {
                    document.getElementById("error-msg").textContent = "ERROR : You answer must be a number.";
                }
                else
                {
                    document.getElementById("error-msg").textContent = "";
                    calculation = calculation.replace(/\s+/g, '');
                    calculations.push(calculation);

                    userAnswer = parseInt(userAnswer.replace(/\s+/g, ''));
                    u_calcResults.push(userAnswer);

                    let result;

                    switch (calculation[1])
                    {
                        case "+" :
                            result = parseInt(calculation[0]) + parseInt(calculation[2]);
                            break;
                        case "-" :
                            result = parseInt(calculation[0]) - parseInt(calculation[2]);
                            break;
                        case "x" :
                            result = parseInt(calculation[0]) * parseInt(calculation[2]);
                            break;
                    }

                    calcResults.push(result);

                    if (userAnswer == result)
                    {
                        console.log(true);
                    }
                    else
                    {
                        console.log(false);
                    }

                    if (calcNb<3)
                    {
                        displayCalc();
                    }
                    else
                    {
                        document.getElementById("results").style.display="block";
                        divUser.style.display="none";
                        spanTimer.style.display="none";
                        document.getElementById("display-calc").style.display="none";
                        spanTimer.textContent = timer(300);
                    }
                }
            }
            inputUserAnswer.value = "";
        }

        function seeResults()
        {
            let tableHtml = "<thead><tr>";
            let headers = ["CALCULATIONS", "USER_ANSWER", "ANSWER"]
            let rightAnswers = 0;

            for (let i = 0; i < 3; i++) {
                tableHtml += "<th>" + headers[i] + "</th>";
            }
            tableHtml += "</tr></thead><tbody>";
            for (let i = 0; i < 3; i++) {
                tableHtml += "<tr><td>" + calculations[i] + "</td>";
                tableHtml += "<td>" + u_calcResults[i] + "</td>";
                tableHtml += "<td>" + calcResults[i] + "</td></tr>";
                
                if (u_calcResults[i] == calcResults[i])
                {
                    rightAnswers++;
                }
            }
            tableHtml += "</tbody>";
            document.getElementById("resTable").innerHTML = tableHtml;

            document.getElementById("sentence2").textContent = "Number of right answers = " + rightAnswers.toString();
            document.getElementById("res-button").style.display="none";
            document.getElementById("nextPage").style.display="block";
        }
    </script>