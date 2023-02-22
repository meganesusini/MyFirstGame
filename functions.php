<?php
// function generateNb() 
// {
// return rand_int(0,100);
// }

// function findTheNb($userNb, $nbToFind)
// {
//     if ($userNb > $nbToFind)
//     {
//         return "less";
//     }
//     else if ($userNb < $nbToFind)
//     {
//         return "more";
//     }
//     else 
//     {
//         return "You are right ! The number is " . $nbToFind;
//     }
// }

if(isset($_POST['text'])) {
    $text = $_POST['text'];
    echo "Bonjour $text !";
  }
?>