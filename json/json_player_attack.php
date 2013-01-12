<?php

require "../includes/constants.inc.php";
require REAL_BASE . "json/includes.inc.php";

session_start();

$player = get_current_player();
$battle = get_current_battle();

$result = new AttackResult;
if(!empty($_POST['data']) && isset($_POST['data'])){

	$is_game_over = false;
	$winning_player_id = null;
	$successful_attack = false;
	$opponent_attack_position = null;

	$player_id = $player->id;
	$opponent_id = $battle->opponent->id;

	$data = parse_json($_POST['data']);
	$player_attack_position = new Position($data->position->x, $data->position->y);
	
	$opponent_board = $battle->get_board($opponent_id);
	
	$successful_attack = $opponent_board->check_ship_hit($player_attack_position, true);
	if($successful_attack){
	
		$opponent_board->mark_tile($player_attack_position, TILE_HIT);
	
		//check if the player won with his attack
		$is_game_over = !($opponent_board->has_floating_ship());
	}
	else {
		$opponent_board->mark_tile($player_attack_position, TILE_MISS);
	}
	
	if(!$is_game_over){
		
		$player_board = $battle->get_board($player_id);
		
		$opponent_attack_position = $battle->make_move();
		$is_player_hit = $player_board->check_ship_hit($opponent_attack_position, true);
		if($is_player_hit){
		
			$player_board->mark_tile($opponent_attack_position, TILE_HIT);
			
			$is_game_over = !($player_board->has_floating_ship());
			if($is_game_over){
				//opponent won
				$winning_player_id = $opponent_id;
			}
		}
		else {
			$player_board->mark_tile($opponent_attack_position, TILE_MISS);
		}
	}
	//player won
	else{
		$winning_player_id = $player_id;
	}
	
	if($is_game_over){
		$battle->resolve_battle($winning_player_id); 
	}
	
	//update battle in the session after changes
	update_battle($battle);

	$result->is_game_over = $is_game_over;
	$result->winning_player_id = $winning_player_id;
	
	$result->successful_attack = $successful_attack;
	$result->opponent_attack_position = $opponent_attack_position;
	
	$result->success = true;
}

echo json_encode($result);

?>