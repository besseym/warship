<?php

require_once REAL_BASE . "includes/db/db_helper.inc.php";
require_once REAL_BASE . "includes/model/m_player.inc.php";

static $salt = '$2a$07$secretwarshippasswardsalt$';

function insert_player($db_link, $player){

	global $salt;

	$name = db_string_filter($player->name);
	$email = db_string_filter($player->email);
	$password = db_string_filter($player->password);
	$users_ip = db_string_filter($player->users_ip);
	$activation_code = db_string_filter($player->activation_code);
	
	$encrypted_password = crypt($password, $salt);
	
	$insert_sql = "insert into players (name, email, password, created_at, users_ip, activation_code) values ('$name', AES_ENCRYPT('$email', '$salt'), '$encrypted_password', Now(), '$users_ip', '$activation_code')";
	mysql_query($insert_sql, $db_link) or die(mysql_error());
	
	$user_id = mysql_insert_id($db_link) or die(mysql_error());
	$md5_id = md5($user_id);
	
	$update_sql = "UPDATE players SET md5_id='$md5_id' WHERE id='$user_id'";
		
	return mysql_query($update_sql, $db_link) or die(mysql_error());
}

function get_md5_id($db_link, $player){
	$name = db_string_filter($player->name);

	$find_sql = "SELECT * FROM players WHERE name='$name'";
	
	$query = mysql_query($find_sql, $db_link) or die(mysql_error());
	
	$result = mysql_fetch_assoc($query);
	
	return $result['md5_id'];
}

function populate_player($result){

	$player = new Player;
	$player->id = $result['id'];
	$player->name = $result['name'];
	$player->email = $result['email'];
	$player->approved = $result['approved'];
	
	return $player;
}

function select_player($db_link, $id){

	$player = NULL;
	
	$select_sql = "select * from players where id = '$id'";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
		$result = mysql_fetch_assoc($result_set);
		$player = populate_player($result);
	}
	
	return $player;
}

function select_player_with_match_record($db_link, $id){

	$player = NULL;
	
	$select_sql = 
	"select pv.*, count(m.id) defeats from " .
	"(" .
	"select p.*, count(m.id) victories " .
	"from players p left join matches m on p.id = m.winning_player_id " . 
	"where p.id = '$id'" . 
	"group by p.id " .
	") pv " .
	"left join matches m " .
	"on " .
	"(pv.id = m.player1_id or pv.id = m.player2_id) " .
	"and pv.id != m.winning_player_id " . 
	"and m.winning_player_id is not null " . 
	"group by pv.id;";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
	
		$result = mysql_fetch_assoc($result_set);
		$player = populate_player($result);
		$player->victories = $result['victories'];
		$player->defeats = $result['defeats'];
	}
	
	return $player;
}

function does_player_email_exist($db_link, $email){
	
	global $salt;
	
	$select_sql = "select id from players where email = AES_ENCRYPT('$email', '$salt')";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	return (mysql_num_rows($result_set) > 0);
}

function does_player_name_exist($db_link, $name){
	
	$select_sql = "select id from players where name='$name'";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	return (mysql_num_rows($result_set) > 0);
}

function authenticate_player($db_link, $email, $password){

	global $salt;

	$player = NULL;
	
	$encrypted_password = crypt($password, $salt);
	
	$select_sql = "select * from players where email = AES_ENCRYPT('$email', '$salt') and password='$encrypted_password'";
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	
	if(mysql_num_rows($result_set) > 0){
		$result = mysql_fetch_assoc($result_set);
		$player = populate_player($result);
	}
	
	return $player;
}

function update_player($db_link, $player){
	
	global $salt;
	
	$id = $player->id;
	$name = db_string_filter($player->name);
	$email = db_string_filter($player->email);
	$password = db_string_filter($player->getEncryptedPassword());
	
	$update_sql = "update players set name='$name', email = AES_ENCRYPT('$email', '$salt'), password='$password', updated_at=now() where id='$id'";
	return mysql_query($update_sql, $db_link) or die(mysql_error());
}

function delete_player($db_link, $player){
	
	$id = $player->id;
	$delete_sql = "delete from players where id='$id'";
	return mysql_query($delete_sql, $db_link) or die(mysql_error());
}

function get_player_name($db_link, $id){

	$select_sql = "SELECT name FROM players WHERE id= '$id'"; 
	$result_set = mysql_query($select_sql, $db_link) or die(mysql_error());
	$result = mysql_fetch_assoc($result_set);
	return $result['name'];
}

?>