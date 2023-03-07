<?php
include_once "Ranking.php";

class RankingDAO
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

    // Add a ranking
    public function addRanking($newRanking)
    {
        $pseudo = $newRanking->getPseudo();
        $totalTimes = $newRanking->getTotalTimes();
        $totalPoints = $newRanking->getTotalPoints();
        $r1_time = $newRanking->getR1Time();
        $r1_tries = $newRanking->getR1Tries();
        $r1_found = $newRanking->getR1Found();
        $r2_time = $newRanking->getR2Time();
        $r2_wordsFound = $newRanking->getR2WordsFound();
        $r3_time = $newRanking->getR3Time();
        $r3_rightAnswers = $newRanking->getR3RightAnswers();
        $roundId = $newRanking->getRoundId();

        $request = $this->getDb()->prepare("INSERT INTO Ranking (pseudo, totalTimes, totalPoints, r1_time, r1_tries, r1_found, r2_time, r2_wordsFound, r3_time, r3_rightAnswers, idR) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $request->execute([$pseudo, $totalTimes, $totalPoints, $r1_time, $r1_tries, $r1_found, $r2_time, $r2_wordsFound, $r3_time, $r3_rightAnswers, $roundId]);
    }

    // Select a ranking
    public function selectRanking($roundId)
    {
        $request = $this->getDb()->prepare("SELECT * FROM Ranking WHERE idR = ?");
        $request->execute([$roundId]);

        return $request->fetchAll();
    }

    // // Get all the rankings
    // public function getAllRankings()
    // {
    //     $request = $this->getDb()->prepare("SELECT * FROM `Ranking` GROUP BY pseudo ORDER BY totalPoints DESC, totalTimes ASC; ");
    //     $request->execute();

    //     return $request->fetchAll();
    // }

    // Get the best player ranking
    public function getBestPlayerRanking()
    {
        $request = $this->getDb()->prepare("SELECT pseudo, totalTimes, totalPoints FROM `Ranking` GROUP BY pseudo ORDER BY totalPoints DESC, totalTimes ASC;");
        $request->execute();

        return $request->fetchAll();
    }

    // Get the round1 ranking
    public function getRound1Ranking()
    {
        $request = $this->getDb()->prepare("SELECT pseudo, r1_time, r1_tries, r1_found FROM `Ranking` GROUP BY pseudo ORDER BY r1_found DESC, r1_time ASC, r1_tries ASC;");
        $request->execute();

        return $request->fetchAll();
    }

    // Get the round2 ranking
    public function getRound2Ranking()
    {
        $request = $this->getDb()->prepare("SELECT pseudo, r2_time, r2_wordsFound FROM `Ranking` GROUP BY pseudo ORDER BY r2_wordsFound DESC, r2_time ASC;");
        $request->execute();

        return $request->fetchAll();
    }

    // Get the round3 ranking
    public function getRound3Ranking()
    {
        $request = $this->getDb()->prepare("SELECT pseudo, r3_time, r3_rightAnswers FROM `Ranking` GROUP BY pseudo ORDER BY r3_rightAnswers DESC, r3_time ASC;");
        $request->execute();

        return $request->fetchAll();
    }

    // // Select the last round id
    // public function getLastRound()
    // {
    //     $request = $this->getDb()->prepare("SELECT MAX(id) FROM Round");
    //     $request->execute();

    //     return $request->fetch();
    // }

    // // Delete a round
    // public function deleteRound($roundId)
    // {
    //     $request = $this->getDb()->prepare("DELETE FROM Round WHERE id = ?");
    //     $request->execute([$roundId]);
    // }

    // // Select the max score of all the players
    // public function getAllMaxScores()
    // {
    //     $request = $this->getDb()->prepare("SELECT Player.pseudo, Round1.triesNb, (Round2.wordsNb + Round3.rightAnswersNb) AS totalPoints, (Round1.timeSpent + Round2.timeSpent + Round3.timeSpent) AS totalTimes FROM Round INNER JOIN Round1 ON Round.id = Round1.idR INNER JOIN Round2 ON Round.id = Round2.idR INNER JOIN Round3 ON Round.id = Round3.idR INNER JOIN Game ON Round.idG = Game.id INNER JOIN Player ON Game.idP = Player.id ORDER BY totalPoints DESC, totalTimes ASC;");
    //     $request->execute();

    //     return $request->fetchAll();
    // }

    // // Select the max score of all the players
    // public function getAllMaxScores2()
    // {
    //     $request = $this->getDb()->prepare("SELECT Player.pseudo, Round1.triesNb, (15 - Round1.triesNb + Round2.wordsNb + Round3.rightAnswersNb) AS totalPoints, (Round1.timeSpent + Round2.timeSpent + Round3.timeSpent) AS totalTimes FROM Round INNER JOIN Round1 ON Round.id = Round1.idR INNER JOIN Round2 ON Round.id = Round2.idR INNER JOIN Round3 ON Round.id = Round3.idR INNER JOIN Game ON Round.idG = Game.id INNER JOIN Player ON Game.idP = Player.id ORDER BY totalPoints DESC, totalTimes ASC;");
    //     $request->execute();

    //     return $request->fetchAll();
    // }

}
?>