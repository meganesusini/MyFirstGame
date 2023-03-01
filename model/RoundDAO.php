<?php
include_once "Round.php";

class RoundDAO
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
    public function addRound($newRound)
    {
        $gameId = $newRound->getGameId();

        $request = $this->getDb()->prepare("INSERT INTO Round (idG) VALUES (?)");
        $request->execute([$gameId]);
    }

    // Select a round
    public function selectRound($gameId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Round WHERE idG = ?");
        $request->execute([$gameId]);

        return $request->fetchAll();
    }
}
?>