<?php

require_once REAL_BASE . "includes/model/ships/m_ship.inc.php";

class Battleship extends Ship {

	public function __construct(){
		parent::__construct('battleship', 5);
	}

}

?>