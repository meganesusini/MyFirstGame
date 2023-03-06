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

    // Select the max scores of a player
    public function getMaxScoreFromPlayer($playerId)
    {
        $request = $this->getDb()->prepare("SELECT Player.pseudo, (15 - Round1.triesNb + Round2.wordsNb + Round3.rightAnswersNb) AS totalPoints, (Round1.timeSpent + Round2.timeSpent + Round3.timeSpent) AS totalTimes FROM Round INNER JOIN Round1 ON Round.id = Round1.idR INNER JOIN Round2 ON Round.id = Round2.idR INNER JOIN Round3 ON Round.id = Round3.idR INNER JOIN Game ON Round.idG = Game.id INNER JOIN Player ON Game.idP = Player.id WHERE Round.idG IN (SELECT id FROM Game WHERE idP = ?) ORDER BY totalPoints DESC, totalTimes ASC;");
        $request->execute([$playerId]);

        return $request->fetchAll();
    }
}
?>