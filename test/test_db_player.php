<?php

require "../includes/constants.inc.php";
require REAL_BASE . "includes/db/db_constants_local.inc.php";
//require REAL_BASE . "includes/db/db_install.inc.php";
require REAL_BASE . "includes/db/db_connect.inc.php";
require REAL_BASE . "includes/db/db_player.inc.php";

function insert_test($db_link){

	$player = new Player;
	$player->name = 'name';
	$player->email = 'me@email.com';
	$player->password = 'password';
	
	if(insert_player($db_link, $player)){
		echo "player successfully inserted";
	}
}

function select_test($db_link, $id){

	$player = select_player($db_link, $id);
	var_dump($player);
}

function select_record_test($db_link, $id){
	$player = select_player_with_match_record($db_link, $id);
	var_dump($player);
}

function does_exist_test($db_link, $email){

	if(does_player_exist($db_link, $email)){
		echo "player exists";
	}
	else {
		echo "player does NOT exists";
	}
}

function authenticate_test($db_link, $email, $password){

	$player = authenticate_player($db_link, $email, $password);
	var_dump($player);
}

function update_test($db_link, $id){
	
	$player = select_player($db_link, $id);
	
	$player->name = "new new name";
	if(update_player($db_link, $player)){
		echo "player successfully updated";
	}
}

function delete_test($db_link, $id){

	$player = select_player($db_link, $id);
	if(delete_player($db_link, $player)){
		echo "player successfully deleted";
	}
}


//insert_test($db_link);
//select_test($db_link, 1);
select_record_test($db_link, 1);
//does_exist_test($db_link, 'me@email.com');
//authenticate_test($db_link, 'me@email.com', 'password1');
//update_test($db_link, 1);
//delete_test($db_link, 1);

mysql_close($db_link);

?>