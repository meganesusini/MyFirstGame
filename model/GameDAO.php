<?php
include_once "Game.php";

class GameDAO
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

    // Add a game
    public function addGame($newGame)
    {
        $playerId = $newGame->getPlayerId();

        $request = $this->getDb()->prepare("INSERT INTO Game (idP) VALUES (?)");
        $request->execute([$playerId]);
    }
}
?>