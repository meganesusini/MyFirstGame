<?php
// HomeController.php
require_once("./model/BdPdoConnection.php");
require_once("./model/PlayerDAO.php");

class HomeController 
{
    private $connection;

    public function __construct() {
        $this->connection = BdPdoConnection::getConnection();
    }

    public function index() {
        require_once("./index.php");
    }

    public function registration() {
        echo "test1";
        $pseudo = $_POST['r-pseudo']; 
        $password = $_POST['r-password'];

        if (!empty($pseudo) && !empty($password))
        {
            echo "test2";
            // hash pwd
            $pwd = password_hash($password, PASSWORD_DEFAULT);

            // Connection to the database
            $newPlayerDAO = new PlayerDAO($this->connection);

            // Check if the pseudo doesn't exist
            if ($newPlayerDAO->exists($pseudo)[0]["nb"] > 0)
            {
                echo "test3";
                echo "<script>document.getElementById('signon-errormsg').textContent = 'This pseudo already exists';</script>";
            }
            else
            {
                echo "test4";
                // Check if the password is not secure
                if (!$newPlayerDAO->isSecure($password))
                {
                    echo "test5";
                    echo "<script>document.getElementById('signon-errormsg').textContent = 'Your password must contain : at least 12 characters, one lower case letter, one upper case letter, one special character and one number.';</script>";
                }
                // If the 2 conditions = ok
                else
                {
                    echo "test6";
                    // Add the player to the database
                    $newPlayerDAO->addPlayer(new Player($pseudo, $password));

                    header('Location: view/round1.php');
                    exit();
                }
            }
        }
    }
    public function authentication() {
        $pseudo = $_POST['a-pseudo'];
        $password = $_POST['a-password'];

        if (!empty($pseudo) && !empty($password))
        {
            // Connection to the database
            $newPlayerDAO = new PlayerDAO($this->connection);

            // Check if the pseudo doesn't exist
            if ($newPlayerDAO->exists($pseudo)[0]["nb"] < 1)
            {
                echo "<script>document.getElementById('signon-errormsg').textContent = 'This pseudo doesn't exist';</script>";
            }
            else
            {
                // Check if the password matches the pseudo
                // in progress
                if ($newPlayerDAO->matches($password) != $pseudo)
                {
                    echo "<script>document.getElementById('signon-errormsg').textContent = 'Your password is not correct.';</script>";
                }
                // If the 2 conditions = ok
                else
                {
                    header('Location: view/round1.php');
                    exit();
                }
            }
        }
    }
}
?>