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
        echo "1";
        $pseudo = $_POST['r-pseudo']; 
        $password = $_POST['r-password'];

        if (!empty($pseudo) && !empty($password))
        {
            echo "2";
            // hash pwd
            $pwd = password_hash($password, PASSWORD_DEFAULT);

            // Connection to the database
            $newPlayerDAO = new PlayerDAO($this->connection);

            // Check if the pseudo already exist
            if ($newPlayerDAO->exists($pseudo) != false)
            {
                echo "3";
                echo "<script>document.getElementById('signon-errormsg').textContent = 'This pseudo already exists';</script>";
            }
            else
            {
                // Check if the password is not secure
                if (!$newPlayerDAO->isSecure($password))
                {
                    echo "4";
                    echo "<script>document.getElementById('signon-errormsg').textContent = 'Your password must contain : at least 12 characters, one lower case letter, one upper case letter, one special character and one number.';</script>";
                }
                // If the 2 conditions = ok
                else
                {
                    echo "5";
                    // Add the player to the database
                    $newPlayerDAO->addPlayer(new Player($pseudo, $password));
                    $_SESSION["myPseudo"] = $pseudo;

                    header('Location: view/round1.php');
                    echo "hh";
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
            if ($newPlayerDAO->exists($pseudo) == false)
            {
                echo "<script>document.getElementById('login-errormsg').textContent = \"This pseudo doesn't exist\";</script>";
            }
            else
            {
                // Check if the password matches the pseudo
                if ($newPlayerDAO->matches($password, $pseudo) == false)
                {
                    echo "<script>document.getElementById('login-errormsg').textContent = 'Your password is not correct.';</script>";
                }
                // If the 2 conditions = ok
                else
                {
                    $_SESSION["myPseudo"] = $pseudo;
                    header('Location: view/round1.php');
                    exit();
                }
            }
        }
    }
}
?>