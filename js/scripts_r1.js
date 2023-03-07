let spanClue = document.getElementById("r1_clue"); // span which displays "more" / "less"
let inputNb = document.getElementById("r1_nb"); // input where the user enter a nb
let guess_nb_part = document.getElementById("r1_guess_nb"); // part where the user guess the nb
let pTimer = document.getElementById("r1_timer"); // displays timer

const randomNb = Math.floor(Math.random() * 101); // generate a random number

let triesNb = 0; // user tries nb

let countdownInterval; // function which displays the timer
let countdownDuration; // total time of timer


/* *********** FUNCTIONS ************ */


// displays the game when the player is ready
function readyButton()
{
    guess_nb_part.style.display = "block"; // displays the part where the user enter a nb
    document.getElementById("r1_readyButton").style.display = "none"; // delete the button
    timer(); // displays timer
}


// Displays if the user found the right number
function findTheNb(userNb, nbToFind)
{
    inputNb.value = inputNb.value.trim(); // delete all the spaces
    if(inputNb.value.length != 0) // check if the user entered something
    {
        if (!isNaN(inputNb.value)) // check if the user entered a nb
        {
            if (userNb == nbToFind) 
            {
                stopTimer();
                function finishRound(wonOrNot)
                {
                    let tries, found;
                    if (wonOrNot == true)
                    {
                        tries = triesNb+1;
                        found = "yes";
                    }
                    else
                    {
                        tries = triesNb;
                        found = "no";
                    }

                    pTimer.style.display = "none"; // delete the timer

                    spanClue.textContent = "You are right ! The number is " + nbToFind.toString();

                    // send the data
                    document.getElementById("r1_timeSpent").value = 60 - countdownDuration; 
                    document.getElementById("r1_triesNb").value = tries; 
                    document.getElementById("r1_found").value = found; 
                    
                    // new display
                    guess_nb_part.style.display="none"; // delete the part where the user enter a nb
                    document.getElementById("r1_next").style.display="block"; // displays the part where the user can go to the next round
                }
                finishRound(true);

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
        }

        else
        {
            spanClue.textContent = "You must enter a number."
        }
    }

    inputNb.value = "";
}

// Displays if the user found the right number
inputNb.addEventListener('keydown', function(event) 
{
    if (event.key === 'Enter') 
    {
        findTheNb(inputNb.value, randomNb);
    }
});


// Displays the timer
function timer()
{
    inputNb.focus(); // autofocus on the input

    pTimer.textContent = "1:00";
    
    // Define the countdown duration in seconds
    countdownDuration = 60;

    // Function which displays the countdown
    function displayCountdown() 
    {
        const minutes = Math.floor(countdownDuration / 60);
        const seconds = countdownDuration % 60;
        pTimer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    // Start the countdown every seconds
    countdownInterval = setInterval(function() 
    {
        countdownDuration--;

        displayCountdown();
    
        // Stop the countdown is the duration is reached
        if (countdownDuration < 1) {
            clearInterval(countdownInterval);
            finishRound(false);

        }

    }, 1000);
}

function stopTimer()
{
    clearInterval(countdownInterval);
}