<?php

class Player 
{
	private $id;
    private $pseudo;
    private $password;

    public function __construct($pseudo, $password)
    {
		$this->id;
        $this->pseudo = $pseudo;
        $this->password = $password;
    }

	public function getId() {
		return $this->id;
	}

	public function getPseudo() {
		return $this->pseudo;
	}

	public function setPseudo($pseudo) {
		$this->pseudo = $pseudo;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

}
?>