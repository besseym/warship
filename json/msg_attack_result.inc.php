<?php

require_once REAL_BASE . "json/msg_result.inc.php";

class AttackResult extends Result {
	
	public $is_game_over;
	public $winning_player_id;
	
	public $successful_attack;
	public $opponent_attack_position;
	
	public function __construct(){
		$this->is_game_over = false;
		$this->winning_player_id = null;
		
		$this->successful_attack = false;
		$this->opponent_attack_position = null;
	}
}

?>