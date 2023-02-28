<?php

class Game 
{
	private $id;
    private $playerId;

    public function __construct($playerId)
    {
		$this->id;
        $this->playerId = $playerId;
    }

	public function getId() {
		return $this->id;
	}

	public function getPlayerId() {
		return $this->playerId;
	}

	public function setPlayerId($newPlayerId) {
		$this->playerId = $newPlayerId;
	}

}
?>