<?php

class Match {
	
	public $id;
	public $player1_id;
	public $player2_id;
	public $player1_score;
	public $player2_score;
	public $difficulty;
	public $winning_player_id;
	
	public function __construct($difficulty = 0){
	
		$this->id = null;
		$this->player1_id = 0;
		$this->player2_id = 0;
		$this->player1_score = 0;
		$this->player2_score = 0;
		$this->difficulty = $difficulty;
		$this->winning_player_id = null;
	}
	
	public function populate($db_result){
	
		$this->id = $db_result['id'];
		$this->player1_id = $db_result['player1_id'];
		$this->player2_id = $db_result['player2_id'];
		$this->player1_score = $db_result['player1_score'];
		$this->player2_score = $db_result['player2_score'];
		$this->difficulty = $db_result['difficulty'];
		$this->winning_player_id = $db_result['winning_player_id'];
	}
	
	public function __toString(){
		return '(' . $this->id . ') : (player #1 = ' . $this->player1_id . ', score : ' . $this->player1_score . ') ; (player #2 = ' . $this->player2_id  . ', score : ' . $this->player2_score . ') = ' . $this->winning_player_id;
	}
}

?>