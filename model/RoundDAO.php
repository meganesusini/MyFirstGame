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

    // Add a round
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

    // Select the last round id
    public function getLastRound()
    {
        $request = $this->getDb()->prepare("SELECT MAX(id) FROM Round");
        $request->execute();

        return $request->fetch();
    }

    // Delete a round
    public function deleteRound($roundId)
    {
        $request = $this->getDb()->prepare("DELETE FROM Round WHERE id = ?");
        $request->execute([$roundId]);
    }
}
?>