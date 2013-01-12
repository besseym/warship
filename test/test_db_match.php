<?php

require "../includes/constants.inc.php";
require REAL_BASE . "includes/db/db_constants_local.inc.php";
//require REAL_BASE . "includes/db/db_install.inc.php";
require REAL_BASE . "includes/db/db_connect.inc.php";
require REAL_BASE . "includes/db/db_match.inc.php";

function player_victories_test($db_link, $player_id){
	echo select_player_victories($db_link, $player_id);
}

function player_defeats_test($db_link, $player_id){
	echo select_player_defeats($db_link, $player_id);
}

function start_test($db_link){

	$match = new Match;
	$match->player1_id = 1;
	$match->player2_id = 2;
	
	if(start_match($db_link, $match)){
		echo "match successfully started.";
	}
}

function select_test($db_link, $id){

	$match = select_match($db_link, $id);
	var_dump($match);
}

function complete_test($db_link, $id){

	$battle = new Battle;
	$battle->player1_score = 30;
	$battle->player2_score = 25;
	$battle->winning_player_id = 1;
	
	if(complete_match($db_link, $match)){
		echo "match successfully completed.";
	}
}

//start_test($db_link);
//select_test($db_link, 2);
//complete_test($db_link, 2);

//player_victories_test($db_link, 1);
//player_defeats_test($db_link, 1);

mysql_close($db_link);

?>