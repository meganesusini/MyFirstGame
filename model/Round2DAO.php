<?php
include_once "Round2.php";

class Round2DAO
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

    // Add a round2
    public function addRound2($newRound2)
    {
        $wordsNb = $newRound2->getWordsNb();
        $timeSpent = $newRound2->getTimeSpent();
        $roundId = $newRound2->getRoundId();

        $request = $this->getDb()->prepare("INSERT INTO Round2 (wordsNb, timeSpent, idR) VALUES (?, ?, ?)");
        $request->execute([$wordsNb, $timeSpent, $roundId]);
    }

    // Select a round2
    public function selectRound2($roundId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Round2 WHERE idR = ?");
        $request->execute([$roundId]);

        return $request->fetchAll();
    }

    // Select the last round2 id
    public function getLastRound2()
    {
        $request = $this->getDb()->prepare("SELECT MAX(id) FROM Round2");
        $request->execute();

        return $request->fetch();
    }

    // Delete a round2
    public function deleteRound2($roundId)
    {
        $request = $this->getDb()->prepare("DELETE FROM Round2 WHERE idR = ?");
        $request->execute([$roundId]);
    }
}
?>