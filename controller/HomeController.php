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
        $pseudo = $_POST['pseudo']; 
        $password = $_POST['password'];

        if (!empty($_POST['pseudo']) && !empty($_POST['password']))
        {
            // hash pwd
            $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Connection to the database
            $newPlayerDAO = new PlayerDAO($connection);

            // Check if the pseudo doesn't exist
            if ($newPlayerDAO->exists($pseudo) > 0)
            {
                echo "<script>document.getElementById('signon-errormsg').textContent = 'This pseudo already exists';</script>";
            }
            else
            {
                // Check if the password is not secure
                if (!$newPlayerDAO->isSecure($password))
                {
                    echo "<script>document.getElementById('signon-errormsg').textContent = 'Your password must contain : at least 12 characters, one lower case letter, one upper case letter, one special character and one number.';</script>";
                }
                // If the 2 conditions = ok
                else
                {
                    // Add the player to the database
                    $newPlayerDAO->addPlayer(new Player($pseudo, $password));

                    include ("./view/round1.php");
                }
            }
        }
        

        // Vérifier les informations d'identification de l'utilisateur ici
        //if (/* authentification réussie */) {
        //    header('Location: index.php?controller=HomeController&action=index');
        //    exit();
        //} else {
            // Afficher un message d'erreur ou rediriger vers une page d'erreur
        //}
    }
    //public function authenticate() {
        //$username = $_POST['username'];
        //$password = $_POST['password'];

        // Vérifier les informations d'identification de l'utilisateur ici
        //if (/* authentification réussie */) {
            //header('Location: index.php?controller=HomeController&action=index');
            //exit();
        //} else {
            // Afficher un message d'erreur ou rediriger vers une page d'erreur
        //}
    //}
}
?>