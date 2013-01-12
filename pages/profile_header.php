<?php
/*Secured user only page*/
secure_page();
$player = get_current_player();

$submitted = isset($_POST['submit']) && $_POST['submit'] == 'Start Battle';
if($submitted){
	
	$board_size = trim($_POST['board-size']);
	$difficulty = trim($_POST['difficulty']);
	
	$dimension = NULL;
	switch($board_size){
		case '8x8':
			$dimension = new Dimension(8,8);
			break;
		case '10x10':
			$dimension = new Dimension(10,10);
			break;
		case '12x12':
			$dimension = new Dimension(12,12);
			break;
		default:
			$dimension = new Dimension(8,8);
			break;
	}
	
	$battle = null;
	if('advanced' == $difficulty){
		$battle = new BattleAiAdvanced($player->id, $dimension);
	}
	else {
		$battle = new BattleAiBasic($player->id, $dimension);
	}
	
	start_match($db_link, $battle);
	$battle->id = mysql_insert_id($db_link);
	
	start_battle($battle);
	
	header("Location: " . PAGE_BATTLE);
}

?>