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

    public function getDb()
    {
        return $this->db;
    }

    // Add a player
    public function addPlayer($newPlayer)
    {
        $pseudo = $newPlayer->getPseudo();
        $password = $newPlayer->getPassword();

        $request = $this->getDb()->prepare("INSERT INTO Player (pseudo, password) VALUES (?, ?)");
        $request->execute([$pseudo, $password]);
    }

    // Check if the pseudo already exists
    // Return pseudo or false
    public function exists($pseudo)
    {
        $request = $this->getDb()->prepare("SELECT pseudo FROM Player WHERE pseudo = ?");
        $request->execute([$pseudo]);

        return $request->fetch();
    }

    // Check if the password is secure
    public function isSecure($password)
    {
        if (strlen($password) >= 12 && preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password) && preg_match('/\d/', $password) && preg_match('/[^a-zA-Z\d]/', $password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Check if the password matches the pseudo
    public function matches($password, $pseudo)
    {
        $request = $this->getDb()->prepare("SELECT pseudo FROM Player WHERE (password = ? AND pseudo = ?)");
        $request->execute([$password, $pseudo]);

        return $request->fetch();
    }
}
?>