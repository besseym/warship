<?php

require "../includes/constants.inc.php";

require REAL_BASE . "includes/model/m_position.inc.php";
require REAL_BASE . "includes/model/m_dimension.inc.php";

require REAL_BASE . "includes/model/ships/m_battleship.inc.php";
require REAL_BASE . "includes/model/ships/m_crusier.inc.php";
require REAL_BASE . "includes/model/ships/m_frigate.inc.php";
require REAL_BASE . "includes/model/ships/m_minesweeper.inc.php";

require REAL_BASE . "includes/model/m_board.inc.php";

function get_ship () {
	
	$orientation = SHIP_ORIENTATION_VERTICAL;
	$position = new Position(0, 0);
	
	$ship = new Frigate;
	$ship->set_position($position, $orientation);
	
	return $ship;
}

function test_ship_hit(){

	$ship = get_ship();
	
	//echo "Ship: " . $ship . " ";
	
	/*
	if($ship->check_hit(new Position(0, 2), true)){
		echo "ship was hit";
	}
	else {
		echo "ship was missed";
	}
	*/
	
	echo "Hit Array: ";
	var_dump($ship->hit_array);
}

test_ship_hit();
?>