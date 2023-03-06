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

    // Check if a round3 exists
    // in progress
    public function exists($roundId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Round3 WHERE idR = ?");
        $request->execute([$roundId]);

        return $request->fetch();
    }

    // Select the best round3
    public function rankingRound3()
    {
        $request = $this->getDb()->prepare("SELECT DISTINCT(Player.pseudo), Round3.rightAnswersNb, Round3.timeSpent FROM Player JOIN Game ON Player.id = Game.idP JOIN Round ON Game.id = Round.idG JOIN Round3 ON Round.id = Round3.idR ORDER BY Round3.rightAnswersNb DESC, Round3.timeSpent ASC; ");
        $request->execute();

        return $request->fetchAll();
    }
}
?>