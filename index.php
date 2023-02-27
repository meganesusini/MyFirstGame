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
    <form method="post" action="view/round1.php">
    <h3>New ? Sign on :</h3>
    <label for="">Pseudo </label><input type="text" name="pseudo">
    <label for="">Password </label><input type="text" name="password">
    <input type="submit" name="submit_pseudo" value="Submit">
    <p id="signon-errormsg"></p>
    </form>  
    <form method="post" action="view/round1.php">
    <h3>Otherwise, write your pseudo :</h3>
    <label for="">Pseudo </label><input type="text" name="pseudo">
    <label for="">Password </label><input type="text" name="pwd">
    <input type="submit" name="submit_pseudo" value="Submit">
    <p id="login-errormsg"></p>
    </form>  

    <?php
        require_once("controller/HomeController.php");

        $action = isset($_GET["action"]) ? $_GET["action"] : "index";
        
        $controller = new HomeController();
        
        switch($action) {
            case "index":
                $controller->index();
                break;
            case "registration":
                $controller->registration();
                break;
            default:
                $controller->index();
            }
    ?>
</body>
</html>