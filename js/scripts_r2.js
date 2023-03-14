//after > array (10) which generate random words
let userWordsArray = new Array();
let arrayToMemorize = ["apple", "banana", "watermelon", "pineapple", "mango", "peach", "plum", "kiwi", "strawberry", "blueberry"];
//
let littleTimer = document.getElementById("r2_little_timer");
let inputUserWord = document.getElementById("r2_inputUserWord");
let displayUserWord = document.getElementById("r2_displayUserWord");
let timer = document.getElementById("r2_timer");

let wordsFoundNb = 0;
let countdownInterval, countdownDuration;


// displays the timer and the array with the words to memorize
function readyButton() 
{
    document.getElementById("r2_readyButton").style.display = "none";
    displayLittleTimer();
    displayTables("r2_arrayToMemorize");
}

// displays array with all the words to memorize and remove html elements
function terminateButton()
{
    stopTimer();

    // display the tables
    displayTables("r2_arrayToMemorize");
    displayTables("r2_userTable");
    document.getElementById("r2_writeTheWords").style.display="none";
    document.getElementById("r2_seeTheResults").style.display="block";

    gameResult();
    document.getElementById("r2_nextRound").style.display="block";
}

function displayLittleTimer() 
{
    document.getElementById("r2_memorizeIn10Seconds").style.display = "block"; // displays timer + table to memorize

    let secondsLeft = 10;
    littleTimer.textContent = 10;
    let countdown = setInterval(function() {
        secondsLeft--;
        littleTimer.textContent = secondsLeft;
        if (secondsLeft <= 0) {
            clearInterval(countdown);
            document.getElementById("r2_memorizeIn10Seconds").style.display="none"; // if timer = 0 -> remove div
            document.getElementById("r2_writeTheWords").style.display="block"; // if timer = 0 -> display div

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
            displayUserWord.textContent = "You have already written this word.";
        
        // displays an array with the words entered by the user
        } else {
            displayUserWord.textContent = inputUserWord.value;
            userWordsArray.push(inputUserWord.value);
            displayTables("r2_userTable");
        }

        inputUserWord.value = "";
        
    }
}

// displays the array with the words entered by the user
// or the array with all the words to memorize 
function displayTables(tableId)
{
    let tableHtml = "<tr>";

    // displays the table with the words to memorize
    if (tableId == "r2_arrayToMemorize")
    {
        for (let i = 0; i < 10; i++) {
            if (i == 5)
            {
                tableHtml += "</tr><tr><td>" + arrayToMemorize[i] + "</td>";    
            }
            else
            {
                tableHtml += "<td>" + arrayToMemorize[i] + "</td>";
            }
        }
    }
    
    // displays the table with the words found by the user
    else if (tableId == "r2_userTable")
    {
        // Array length configuration :
        let endArray;
        let arrayLengthModule5 = userWordsArray.length % 5;
        // if the length of the user array is not a multiple of 5 > enlarge table 
        if (arrayLengthModule5 != 0) 
        {
            endArray = userWordsArray.length + (5 - (arrayLengthModule5));
        }
        else
        {
            endArray = userWordsArray.length;
        }
        for (let i=0; i<endArray; i++)
        {
            if (i % 5 === 0 && i != 0)
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

    tableHtml += "</tr>";
    
    document.getElementsByClassName(tableId)[0].innerHTML = tableHtml;
    document.getElementsByClassName(tableId)[1].innerHTML = tableHtml;

}

// calculation of the score and return the result
function gameResult()
{
    let score = 0;
    let result;
    for (let i=0; i<userWordsArray.length; i++)
    {
        if (arrayToMemorize.includes(userWordsArray[i]))
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
        else if (score == 10)
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
    
    document.getElementById("r2_result").textContent = result;
    
    // send the data
    document.getElementById("r2_wordsNb").value = score;
    document.getElementById("r2_timeSpent").value = 60 - countdownDuration;
    
}

// END ROUND2