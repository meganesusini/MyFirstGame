// ROUND1 FUNCTIONS
let spanClue = document.getElementById("r1_clue");
let inputNb = document.getElementById("r1_nb");
let divDelete = document.getElementById("r1_deleteAfter");

const randomNb = Math.floor(Math.random() * 101); // generate a random number

// onclick button > displays if the user found the right number
function findTheNb(userNb, nbToFind)
{
    if (userNb == nbToFind) 
    {
        spanClue.textContent = "You are right ! The number is " + nbToFind.toString();
        divDelete.style.display="none";
        document.getElementById("r1_next").style.display="block";
    }
    else if (userNb > nbToFind)
    {
        spanClue.textContent = "less";
    }
    else
    {
        spanClue.textContent = "more";
    }
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

// END ROUND1