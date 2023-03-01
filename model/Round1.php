<?php

class Round1
{
	private $id;
    private $triesNb;
    private $timeSpent;
    private $roundId;

    public function __construct($triesNb, $timeSpent, $roundId)
    {
		$this->id;
        $this->triesNb = $triesNb;
        $this->timeSpent = $timeSpent;
        $this->roundId = $roundId;
    }

	public function getId() {
		return $this->id;
	}

	public function getTriesNb() {
		return $this->triesNb;
	}

	public function setTriesNb($newTriesNb) {
		$this->triesNb = $newTriesNb;
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