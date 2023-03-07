// ROUND2 FUNCTIONS
let userWordsArray = new Array();
let wordsArray = ["apple", "banana", "cherry", "orange", "pear", "grape", "watermelon", "pineapple", "mango", "peach", "plum", "kiwi", "strawberry", "blueberry"];

let littleTimer = document.getElementById("r2_little_timer");
let inputUserWord = document.getElementById("r2_input-user-word");
let displayUserWord = document.getElementById("r2_display-user-word");
let timer = document.getElementById("r2_timer");

let wordsFoundNb = 0;
let countdownInterval, countdownDuration;


// displays the timer and the array with the words to memorize
function readyButton() 
{
    document.getElementById("readyButton").style.display = "none";
    displayLittleTimer();
    displayTable("r2_tableId");
    // inputUserWord.focus();
}

// displays array with all the words to memorize and remove html elements
function terminateButton()
{
    displayTable("r2_words-to-memorize");
    document.getElementById("r2_timeUp1").style.display="none";
    document.getElementById("r2_timeUp2").style.display="none";
    document.getElementById("r2_round3").style.display="block";
    stopTimer();
    document.getElementById("r2_wordsNb").value = gameResult();
    document.getElementById("r2_timeSpent").value = 60 - countdownDuration;
}

function displayLittleTimer() 
{
    let secondsLeft = 10;
    littleTimer.textContent = 10;
    let countdown = setInterval(function() {
        secondsLeft--;
        littleTimer.textContent = secondsLeft;
        if (secondsLeft <= 0) {
            clearInterval(countdown);
            document.getElementById("r2_timeUp").style.display="block"; // if timer = 0 -> display div
            document.getElementById("r2_ready").style.display="none"; // if timer = 0 -> remove div
            displayTimer();
        }
    }, 1000);
}

function displayTimer()
{
    inputUserWord.focus();
    timer.textContent = "1:00";
    // Define the countdown duration in seconds
    countdownDuration = 60;

    // Definition of the function to display the countdown
    function displayCountdown() {
    const minutes = Math.floor(countdownDuration / 60);
    const seconds = countdownDuration % 60;
    timer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    // Start the countdown every seconds
    countdownInterval = setInterval(function() {
    countdownDuration--;

    displayCountdown();
    
    // Stop the countdown is the duration is reached
    if (countdownDuration < 1) {
        clearInterval(countdownInterval);
        terminateButton();
    }
    }, 1000);
}

function stopTimer()
{
    clearInterval(countdownInterval);
}

// event > when the user press the enter button
inputUserWord.addEventListener('keydown', function(event) 
{
    if (event.key === 'Enter') 
    {
        displayUserWords();
    }
});

// onclick button > displays all the words 
function displayUserWords()
{
    inputUserWord.value = inputUserWord.value.trim();
    if(inputUserWord.value.length != 0)
    {        
        // error if the user entered a word which was already entered before
        if (userWordsArray.includes(inputUserWord.value)) {
            displayUserWord.textContent = "ERROR : You have already written this word.";
        
        // displays an array with the words entered by the user
        } else {
            displayUserWord.textContent = inputUserWord.value;
            userWordsArray.push(inputUserWord.value);
            displayTable("r2_userTable");
        }

        inputUserWord.value = "";
        
    }
}
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("r2_userTable").focus();
  });
// displays the array with the words entered by the user
// or the array with all the words to memorize 
function displayTable(tableId) 
{
    // create the user array
    let tableHtml = "<tr>";
    if (tableId == "r2_userTable")
    {
        let endArray;
        if (userWordsArray.length % 7 != 0)
        {
            endArray = userWordsArray.length + (7 - (userWordsArray.length % 7));
        }
        else
        {
            endArray = userWordsArray.length;
        }
        for (let i=0; i<endArray; i++)
        {
            if (i % 7 === 0 && i != 0)
            {
                tableHtml += "</tr><tr><td>" + userWordsArray[i] + "</td>";
            }
            else if (i >= userWordsArray.length)
            {
                tableHtml += "<td> </td>";
            }
            else
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
        if (tableId == "r2_words-to-memorize") 
        {
            document.getElementById("r2_p-wordsToFind").style.display="block";
        }
    }

    // displays the array
    tableHtml += "</tr>";
    document.getElementById(tableId).innerHTML = tableHtml;
    if (tableId == "r2_userTable")
    {
        if (userWordsArray.length == 0)
        {
            document.getElementById(tableId).style.display = "none";   
        }
    }

    // displays the result of the game
    if (tableId == "r2_words-to-memorize") 
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
            result = "You found 1 word !";
        }
        else if (score == 14)
        {
            result = "Great ! You found all the words !";
        }
        else
        {
            result = "You found " + score + " words !";
        }
    }
    else
    {
        result = "Oh no ! You didn't find any words !";
    }
    if (document.getElementById("r2_result").textContent == "")
    {
        document.getElementById("r2_result").textContent = result;
    }
    else
    {
        return score;
    }

}

// END ROUND2