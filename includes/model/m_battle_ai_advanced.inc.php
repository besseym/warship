<?php

require_once REAL_BASE . "includes/model/m_battle_ai.inc.php";

class BattleAiAdvanced extends BattleAi {

	public function __construct($player_id, $dimension){
		parent::__construct($player_id, $dimension, 5);
	}

	public function make_move(){
		return $this->make_calculated_move();
	}
}

?>