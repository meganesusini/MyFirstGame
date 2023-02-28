// ROUND2 FUNCTIONS
let userWordsArray = new Array();
let wordsArray = ["apple", "banana", "cherry", "orange", "pear", "grape", "watermelon", "pineapple", "mango", "peach", "plum", "kiwi", "strawberry", "blueberry"];

// displays the timer and the array with the words to memorize
function readyButton() 
{
    displayTimer();
    displayTable("r2_tableId");
}

// displays array with all the words to memorize and remove html elements
function terminateButton()
{
    displayTable("r2_words-to-memorize");
    document.getElementById("r2_timeUp1").style.display="none";
    document.getElementById("r2_timeUp2").style.display="none";
    document.getElementById("r2_round3").style.display="block";
}

function displayTimer() 
{
    let secondsLeft = 10;
    document.getElementById("r2_timer").textContent = 10;
    let countdown = setInterval(function() {
        secondsLeft--;
        document.getElementById("r2_timer").textContent = secondsLeft;
        if (secondsLeft <= 0) {
            clearInterval(countdown);
            document.getElementById("r2_timeUp").style.display="block"; // if timer = 0 -> display div
            document.getElementById("r2_ready").style.display="none"; // if timer = 0 -> remove div
        }
    }, 1000);
}

// event > when the user press the enter button
document.getElementById("r2_input-user-word").addEventListener('keydown', function(event) 
{
    if (event.key === 'Enter') 
    {
        if(document.getElementById("r2_input-user-word").value.length != 0)
        {
            inputWord = document.getElementById("r2_input-user-word");
            displayWord = document.getElementById("r2_display-user-word");
            
            // error if the user entered a word which was already entered before
            if (userWordsArray.includes(inputWord.value)) {
                displayWord.textContent = "ERROR : You have already written this word.";
            // displays an array with the words entered by the user
            } else {
                displayWord.textContent = inputWord.value;
                userWordsArray.push(inputWord.value);
                displayTable("r2_userTable");
            }

            inputWord.value = "";
        }
    }
});

// onclick button > displays all the words 
function displayUserWords()
{
    if(document.getElementById("r2_input-user-word").value.length != 0)
    {
        inputWord = document.getElementById("r2_input-user-word");
        displayWord = document.getElementById("r2_display-user-word");
        
        // error if the user entered a word which was already entered before
        if (userWordsArray.includes(inputWord.value)) {
            displayWord.textContent = "ERROR : You have already written this word.";
        
        // displays an array with the words entered by the user
        } else {
            displayWord.textContent = inputWord.value;
            userWordsArray.push(inputWord.value);
            displayTable("r2_userTable");
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
    if (tableId == "r2_userTable")
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
    document.getElementById("r2_result").textContent = result;
}

// END ROUND2