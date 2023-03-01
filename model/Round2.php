<?php

class Round2
{
	private $id;
    private $wordsNb;
    private $timeSpent;
    private $roundId;

    public function __construct($wordsNb, $timeSpent, $roundId)
    {
		$this->id;
        $this->wordsNb = $wordsNb;
        $this->timeSpent = $timeSpent;
        $this->roundId = $roundId;
    }

	public function getId() {
		return $this->id;
	}

	public function getWordsNb() {
		return $this->wordsNb;
	}

	public function setWordsNb($newWordsNb) {
		$this->wordsNb = $newWordsNb;
	}

    public function getTimeSpent() {
		return $this->timeSpent;
	}

	public function setTimeSpent($newTimeSpent) {
		$this->timeSpent = $newTimeSpent;
	}
    public function getRoundId() {
		return $this->roundId;
	}

	public function setRoundId($newRoundId) {
		$this->roundId = $newRoundId;
	}

}
?>