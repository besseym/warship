<?php

require_once REAL_BASE . "includes/model/ships/m_ship.inc.php";

class Minesweeper extends Ship {

	public function __construct(){
		parent::__construct('minesweeper', 2);
	}

}

?>