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
            echo "1";
            $action = "index";
        }
        else
        {
            echo "2";
            $action = $_GET["action"];
        } 

        echo "3";
        $controller = new HomeController();
        echo "4";
        
        switch($action) {
            case "index":
                echo "5";
                $controller->index();
                break;
            case "registration":
                echo "6";
                $controller->registration();
                break;
            case "authentication":
                echo "7";
                $controller->authentication();
                break;

            }
    ?>
</body>
</html>