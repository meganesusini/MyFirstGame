<?php

class Round3
{
	private $id;
    private $rightAnswers;
    private $timeSpent;
    private $roundId;

    public function __construct($rightAnswers, $timeSpent, $roundId)
    {
		$this->id;
        $this->rightAnswers = $rightAnswers;
        $this->timeSpent = $timeSpent;
        $this->roundId = $roundId;
    }

	public function getId() {
		return $this->id;
	}

	public function getRightAnswers() {
		return $this->rightAnswers;
	}

	public function setRightAnswers($newRightAnswers) {
		$this->rightAnswers = $newRightAnswers;
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