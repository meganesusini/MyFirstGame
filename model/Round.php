<?php

class Round 
{
	private $id;
    private $gameId;

    public function __construct($gameId)
    {
		$this->id;
        $this->gameId = $gameId;
    }

	public function getId() {
		return $this->id;
	}

	public function getGameId() {
		return $this->gameId;
	}

	public function setGameId($newGameId) {
		$this->gameId = $newGameId;
	}

}
?>