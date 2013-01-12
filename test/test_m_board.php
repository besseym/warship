<?php

require "../includes/constants.inc.php";

require REAL_BASE . "includes/model/m_position.inc.php";
require REAL_BASE . "includes/model/m_dimension.inc.php";

require REAL_BASE . "includes/model/m_board.inc.php";


function test_board_hit(){
	
	$player_id = 0;
	$dimension = new Dimension(8, 8);
	
	$board = new Board($player_id, $dimension);
	$board->random_init();
	
	/*
	$position = new Position(1, 1);
	if($board->check_ship_hit($position, true)){
		echo "ship was hit";
	}
	else {
		echo "NO ship was hit";
	}
	*/
	
	return $board;
}

$board = test_board_hit();
?>

<ul>
<?php 
$ship = null;
$ship_array_size = sizeof($board->ship_array);
for($i = 0; $i < $ship_array_size; $i++){ 
	$ship = $board->ship_array[$i];
?>
	<li>
	<?php echo "ship[" . $i . "] : {" . $ship . "} "; ?><br/>
	<?php var_dump($ship->hit_array); ?>
	</li>
<?php 
} 
?>
</ul>