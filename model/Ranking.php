<?php

class Ranking 
{
	private $id;
    private $pseudo;
    private $totalTimes, $totalPoints;
    private $r1_time, $r1_tries, $r1_found;
    private $r2_time, $r2_wordsFound;
    private $r3_time, $r3_rightAnswers;
    private $roundId;

    public function __construct($pseudo, $totalTimes, $totalPoints, $r1_time, $r1_tries, $r1_found, $r2_time, $r2_wordsFound, $r3_time, $r3_rightAnswers, $roundId)
    {
		$this->id;
        $this->pseudo = $pseudo;
        $this->totalTimes = $totalTimes;
        $this->totalPoints = $totalPoints;
        $this->r1_time = $r1_time;
        $this->r1_tries = $r1_tries;
        $this->r1_found = $r1_found;
        $this->r2_time = $r2_time;
        $this->r2_wordsFound = $r2_wordsFound;
        $this->r3_time = $r3_time;
        $this->r3_rightAnswers = $r3_rightAnswers;
        $this->roundId = $roundId;
    }

	public function getId() {
		return $this->id;
	}

	public function getPseudo() {
		return $this->pseudo;
	}

	public function setPseudo($newPseudo) {
		$this->pseudo = $newPseudo;
	}

	public function getTotalTimes() {
		return $this->totalTimes;
	}

	public function setTotalTimes($newTotalTimes) {
		$this->totalTimes = $newTotalTimes;
	}
    
	public function getTotalPoints() {
		return $this->totalPoints;
	}

	public function setTotalPoints($newTotalPoints) {
		$this->totalPoints = $newTotalPoints;
	}

	public function getR1Time() {
		return $this->r1_time;
	}

	public function setR1Time($newR1Time) {
		$this->r1_time = $newR1Time;
	}

	public function getR1Tries() {
		return $this->r1_tries;
	}

	public function setR1Tries($newR1Tries) {
		$this->r1_tries = $newR1Tries;
	}

	public function getR1Found() {
		return $this->r1_found;
	}

	public function setR1Found($newR1Found) {
		$this->r1_found = $newR1Found;
	}

	public function getR2Time() {
		return $this->r2_time;
	}

	public function setR2Time($newR2Time) {
		$this->r2_time = $newR2Time;
	}

	public function getR2WordsFound() {
		return $this->r2_wordsFound;
	}

	public function setR2WordsFound($newR2WordsFound) {
		$this->r2_wordsFound = $newR2WordsFound;
	}

	public function getR3Time() {
		return $this->r3_time;
	}

	public function setR3Time($newR3Time) {
		$this->r3_time = $newR3Time;
	}

	public function getR3RightAnswers() {
		return $this->r3_rightAnswers;
	}

	public function setR3RightAnswers($newR3RightAnswers) {
		$this->r3_rightAnswers = $newR3RightAnswers;
	}

	public function getRoundId() {
		return $this->roundId;
	}

	public function setRoundId($newRoundId) {
		$this->roundId = $newRoundId;
	}


}
?>