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

    // Select a game
    public function selectGame($playerId)
    {
        $request = $this->getDb()->prepare("SELECT MAX(id), idP FROM Game WHERE idP = ?");
        $request->execute([$playerId]);

        return $request->fetchAll();
    }

    // Select a game 2
    public function selectGame2($gameId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Game WHERE id = ?");
        $request->execute([$gameId]);

        return $request->fetchAll();
    }

    // Select the last game id
    public function getLastGame()
    {
        $request = $this->getDb()->prepare("SELECT MAX(id) FROM Game");
        $request->execute();

        return $request->fetch();
    }

    // Delete a game
    public function deleteGame($gameId)
    {
        $request = $this->getDb()->prepare("DELETE FROM Game WHERE id = ?");
        $request->execute([$gameId]);
    }

    // Select all the games of a player
    public function getAllGamesFromPlayer($playerId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Game WHERE idP = ?");
        $request->execute([$playerId]);

        return $request->fetchAll();
    }
}
?>