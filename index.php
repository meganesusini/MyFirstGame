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
</head>
<body>
    <h2>MY FIRST GAME</h2>
    <form method="post" action="index.php?action=registration">
    <h3>New ? Sign on :</h3>
    <label for="">Pseudo </label><input type="text" name="r-pseudo">
    <label for="">Password </label><input type="text" name="r-password">
    <input type="submit" name="submit_pseudo" value="Submit">
    <!-- <a href="index.php?controller=registration">Submit</a> -->
    <p id="signon-errormsg"></p>
    </form>  
    <form method="post" action="index.php?action=authentication">
    <h3>Otherwise, write your pseudo :</h3>
    <label for="">Pseudo </label><input type="text" name="a-pseudo">
    <label for="">Password </label><input type="text" name="a-password">
    <input type="submit" name="submit_pseudo" value="Submit">
    <p id="login-errormsg"></p>
    </form>  

    <?php
        require_once("controller/HomeController.php");

        if(!isset($_GET["action"]))
        {
            $action = "index";
        }
        else
        {
            $action = $_GET["action"];
        } 

        $controller = new HomeController();
        
        switch($action) {
            case "index":
                $controller->index();
                break;
            case "registration":
                $controller->registration();
                break;
            case "authentication":
                $controller->authentication();
                break;

            }
    ?>
</body>
</html>