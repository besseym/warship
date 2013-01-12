<?php

require_once REAL_BASE . "includes/model/ships/m_ship.inc.php";

class Frigate extends Ship {

	public function __construct(){
		parent::__construct('frigate', 3);
	}
}

?>