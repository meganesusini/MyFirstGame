<?php
include_once "Round1.php";

class Round1DAO
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

    // Add a round1
    public function addRound1($newRound1)
    {
        $triesNb = $newRound1->getTriesNb();
        $timeSpent = $newRound1->getTimeSpent();
        $roundId = $newRound1->getRoundId();

        $request = $this->getDb()->prepare("INSERT INTO Round1 (triesNb, timeSpent, idR) VALUES (?, ?, ?)");
        $request->execute([$triesNb, $timeSpent, $roundId]);
    }

    // Select a round1
    public function selectRound1($roundId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Round1 WHERE idR = ?");
        $request->execute([$roundId]);

        return $request->fetchAll();
    }

    // Select the last round1 id
    public function getLastRound1()
    {
        $request = $this->getDb()->prepare("SELECT MAX(id) FROM Round1");
        $request->execute();

        return $request->fetch();
    }

    // Delete a round1
    public function deleteRound1($roundId)
    {
        $request = $this->getDb()->prepare("DELETE FROM Round1 WHERE idR = ?");
        $request->execute([$roundId]);
    }
}
?>