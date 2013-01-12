<?php

class LeaderboardRecord {

	public $id;
	public $name;
	public $total_victories;
	public $total_defeats;
	public $score;
	
	public function populate($db_result){
	
		$this->id = $db_result['id'];
		$this->name = $db_result['name'];
		$this->total_victories = $db_result['total_victories'];
		$this->total_defeats = $db_result['total_defeats'];
		$this->score = $db_result['score'];
	}
	
	public function __toString(){
		return $this->id . ' ' . $this->name . ' ' . ' [' . $this->total_victories . '] [' . $this->total_defeats . ']';
	}
	
}

?>