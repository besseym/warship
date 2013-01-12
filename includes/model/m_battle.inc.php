<?php

require_once REAL_BASE . "includes/model/m_match.inc.php";
require_once REAL_BASE . "includes/model/m_dimension.inc.php";
require_once REAL_BASE . "includes/model/m_board.inc.php";

class Battle extends Match {
	
	public $state;
	public $opponent;
	public $dimension;
	protected $board_array;
	
	public function __construct($player_id, $opponent, $dimension, $difficulty){
	
		parent::__construct($difficulty);
	
		$this->state = STATE_BATTLE_SETUP;
	
		$this->player1_id = $player_id;
		$this->player2_id = $opponent->id;
		$this->opponent = $opponent;
		
		if($dimension === NULL){
			$dimension = new Dimension(8,8);
		}
		
		$this->board_array = array();
		$this->board_array[$player_id] = new Board($player_id, $dimension);
		$this->board_array[$opponent->id] = new Board($opponent->id, $dimension);
		
		$this->dimension = $dimension;
	}
	
	public function resolve_battle($winning_player_id){
	
		$this->winning_player_id = $winning_player_id;
		$this->player1_score = $this->board_array[$this->player1_id]->get_score();
		$this->player2_score = $this->board_array[$this->player2_id]->get_score();
	}
	
	public function set_state($new_state){
		$this->state = $new_state;
	}
	
	public function get_board($player_id){
		return $this->board_array[$player_id];
	}
	
	public function get_floating_ship_count($player_id, $ship_type){
		return $this->board_array[$player_id]->get_floating_ship_count($ship_type);
	}
	
	public function position_ship($player_id, $ship_id, $position, $orientation){
		$this->board_array[$player1_id]->set_position($ship_id, $position, $orientation);
	}
}

?>