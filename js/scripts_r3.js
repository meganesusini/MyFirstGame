// ROUND3 FUNCTIONS
let calculations = new Array();
let calcResults = new Array();
let u_calcResults = new Array();

let randomNb1;
let randomNb2;
let symbol;
const symbols = ['+', '-', 'x'];
let calcNb = 0;

let inputUserAnswer = document.getElementById("r3_user-answer");
let spanTimer = document.getElementById("r3_timer");
let divUser = document.getElementById("r3_user");
let spanCalc = document.getElementById("r3_calc");

function readyButton()
{
    // DISPLAYS TIMER (5MIN)
        timer(1);

    // DISPLAYS CALCULATIONS
        displayCalc();
        // remove div#ready
        document.getElementById("r3_ready").style.display="none";

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
    document.getElementById("r3_sentence").textContent = "Calculation n°" + calcNb.toString() + " :";

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
            document.getElementById("r3_error-msg").textContent = "ERROR : You answer must be a number.";
        }
        else
        {
            document.getElementById("r3_error-msg").textContent = "";
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

            if (calcNb<3)
            {
                displayCalc();
            }
            else
            {
                document.getElementById("r3_results").style.display="block";
                divUser.style.display="none";
                spanTimer.style.display="none";
                document.getElementById("r3_display-calc").style.display="none";
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
    document.getElementById("r3_resTable").innerHTML = tableHtml;

    document.getElementById("r3_sentence2").textContent = "Number of right answers = " + rightAnswers.toString();
    document.getElementById("r3_res-button").style.display="none";
    document.getElementById("r3_nextPage").style.display="block";
}

// END ROUND3