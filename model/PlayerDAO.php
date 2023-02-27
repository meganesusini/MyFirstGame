<?php
include_once "Player.php";

class PlayerDAO
{
    private $db;

    public function __construct($pdo)
    {
        $this->setDb($pdo);
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

    public function getDb($db)
    {
        return $this->db;
    }

    // Add a player
    public function addPlayer($newPlayer)
    {
        $pseudo = $newPlayer->getPseudo();
        $password = $newPlayer->getPassword();

        $request = $this->getDb()->prepare("INSERT INTO Player VALUES (?, ?)");
        $request->execute([$pseudo, $password]);
    }

    // Check if the pseudo already exists
    // Return how many pseudo there are
    public function exists($pseudo)
    {
        $request = $this->getDb()->prepare("SELECT COUNT(*) AS nb FROM Player WHERE pseudo = ?");
        $request->execute([$pseudo]);

        return $request->fetchAll();
    }

    // Check if the password is secure
    public function isSecure($password)
    {
        if (strlen($chaine) >= 12 && preg_match('/[a-z]/', $chaine) && preg_match('/[A-Z]/', $chaine) && preg_match('/\d/', $chaine) && preg_match('/[^a-zA-Z\d]/', $chaine))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>