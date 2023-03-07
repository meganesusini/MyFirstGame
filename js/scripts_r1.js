// ROUND1 FUNCTIONS
let spanClue = document.getElementById("r1_clue");
let inputNb = document.getElementById("r1_nb");
let divDelete = document.getElementById("r1_deleteAfter");
let pTimer = document.getElementById("r1_timer");

const randomNb = Math.floor(Math.random() * 101); // generate a random number

let triesNb = 0;
let countdownInterval, countdownDuration;

// onclick button > displays if the user found the right number
function findTheNb(userNb, nbToFind)
{
    if (userNb == nbToFind) 
    {
        spanClue.textContent = "You are right ! The number is " + nbToFind.toString();
        divDelete.style.display="none";
        document.getElementById("r1_next").style.display="block";

        // stop the timer > save the time spent > save the nb of tries
        stopTimer();
        document.getElementById("r1_timeSpent").value = 60 - countdownDuration;
        document.getElementById("r1_triesNb").value = triesNb+1;
        document.getElementById("r1_found").value = "yes";
        pTimer.style.display = "none";
        
    }
    else if (userNb > nbToFind)
    {
        spanClue.textContent = "less";
    }
    else
    {
        spanClue.textContent = "more";
    }
    triesNb++;
    inputNb.value ="";
}

// keydown enter > displays if the user found the right number
inputNb.addEventListener('keydown', function(event) 
{
    if (event.key === 'Enter') 
    {
        if(inputNb.value.length != 0)
        {
            findTheNb(inputNb.value, randomNb);
        }
    }
});

function timer()
{
    pTimer.textContent = "1:00";
    // Define the countdown duration in seconds
    countdownDuration = 60;

    // Definition of the function to display the countdown
    function displayCountdown() {
    const minutes = Math.floor(countdownDuration / 60);
    const seconds = countdownDuration % 60;
    pTimer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    // Start the countdown every seconds
    countdownInterval = setInterval(function() {
    countdownDuration--;

    displayCountdown();
    
    // Stop the countdown is the duration is reached
    if (countdownDuration < 1) {
        clearInterval(countdownInterval);

        // delete deleteafter div
        divDelete.style.display = "none";
        pTimer.style.display = "none";
        spanClue.textContent = "Oh no, you couldn't find the right number in time !";
        divDelete.style.display="none";
        document.getElementById("r1_next").style.display="block";

        // stop the timer > save the time spent > save the nb of tries
        document.getElementById("r1_triesNb").value = triesNb;
        stopTimer();
        document.getElementById("r1_timeSpent").value = 60 - countdownDuration;
        document.getElementById("r1_found").value = "no";
    }
    }, 1000);
}

function stopTimer()
{
    clearInterval(countdownInterval);
}

function readyButton()
{
    divDelete.style.display = "block";
    document.getElementById("displayButton").style.display = "none";
    timer();
}

// END ROUND1