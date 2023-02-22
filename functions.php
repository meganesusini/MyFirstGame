<?php
function generateNb() 
{
return mt_rand(0,100);
}

function findTheNb($userNb, $nbToFind)
{
    if ($userNb == $nbToFind) 
    {
        return "You are right ! The number is " . $nbToFind;
    }
    else if ($userNb > $nbToFind)
    {
        return "less";
    }
    else
    {
        return "more";
    }
}

?>