<?php
include_once "Round3.php";

class Round3DAO
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

    // Add a round3
    public function addRound3($newRound3)
    {
        $rightAnswers = $newRound3->getRightAnswers();
        $timeSpent = $newRound3->getTimeSpent();
        $roundId = $newRound3->getRoundId();

        $request = $this->getDb()->prepare("INSERT INTO Round3 (rightAnswersNb, timeSpent, idR) VALUES (?, ?, ?)");
        $request->execute([$rightAnswers, $timeSpent, $roundId]);
    }

    // Select a round3
    public function selectRound3($roundId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Round3 WHERE idR = ?");
        $request->execute([$roundId]);

        return $request->fetchAll();
    }

    // Select the last round3 id
    public function getLastRound3()
    {
        $request = $this->getDb()->prepare("SELECT MAX(id) FROM Round3");
        $request->execute();

        return $request->fetch();
    }
}
?>