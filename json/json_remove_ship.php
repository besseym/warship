<?php

require "../includes/constants.inc.php";
require REAL_BASE . "json/includes.inc.php";

session_start();

$player = get_current_player();
$battle = get_current_battle();

$result = new Result;
if(!empty($_POST['data']) && isset($_POST['data'])){

	$data = parse_json($_POST['data']);
	
	$board = $battle->get_board($player->id);
	$ship = $board->ship_array[$data->id];
	if($ship->position != null){
	
		$ship->remove_position();
		update_battle($battle);
	}

	$result->success = true;
}

echo json_encode($result);


?>