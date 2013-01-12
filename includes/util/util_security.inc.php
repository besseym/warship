<?php

require_once REAL_BASE . "includes/db/db_player.inc.php";

/*Function to generate key for login*/
function generate_key($length = 7)
{
	$password = "";
	$possible = "0123456789abcdefghijkmnopqrstuvwxyz";

	$i = 0;
	while ($i < $length)
	{
		$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		if (!strstr($password, $char))
		{
			$password .= $char;
			$i++;
		}
	}
	return $password;
}

function sign_in($player){
	$_SESSION[PLAYER] = serialize($player);
	
	$stamp = time();
	$ckey = generate_key();
	mysql_query("UPDATE players SET `ctime`='$stamp', `ckey` = '$ckey', `num_logins` = num_logins+1, `last_login` = now() WHERE id='$player->id'") or die(mysql_error());

	//Assign session variables to information specific to user
	$_SESSION['id'] = $player->id;
	$_SESSION['name'] = $player->name;
	$_SESSION['stamp'] = $stamp;
	$_SESSION['key'] = $ckey;
	$_SESSION['logged'] = true;
	//And some added encryption for session security
	$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
}

function update_sign_in($player){
	$_SESSION[PLAYER] = serialize($player);
}

function get_current_player(){
	return unserialize($_SESSION[PLAYER]);
}

function is_signed_in(){
	return !empty($_SESSION[PLAYER]);
}

function sign_out(){
	
	unset($_SESSION[PLAYER]);

	//If the user is 'partially' set for some reason, we'll want to unset the db session vars
	if(isset($_SESSION['id']))
	{
		global $db;
		mysql_query("UPDATE players SET `ckey`= '', `ctime`= '' WHERE `id`='" . $_SESSION['id'] . "'") or die(mysql_error());
		unset($_SESSION['id']);
		unset($_SESSION['name']);
		unset($_SESSION['HTTP_USER_AGENT']);
		unset($_SESSION['stamp']);
		unset($_SESSION['key']);
		unset($_SESSION['logged']);
	}
	
	session_unset();
	session_destroy();
}

function secure_page()
{
	if(!isset($_SESSION))
	{
		session_start();
	}
	
	global $db;

	//Secure against Session Hijacking by checking user agent
	if(isset($_SESSION['HTTP_USER_AGENT']))
	{
		//Make sure values match!
		if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']) || $_SESSION['logged'] != true)
		{
			sign_out();
			exit;
		}

		//We can only check the DB IF the session has specified a user id
		if(isset($_SESSION['user_id']))
		{
			$details = mysql_query("SELECT ckey, ctime FROM players WHERE id ='" . $_SESSION['id'] . "'") or die(mysql_error());
			list($ckey, $ctime) = mysql_fetch_row($details);

			//We know that we've declared the variables below, so if they aren't set, or don't match the DB values, force exit
			if(!isset($_SESSION['stamp']) && $_SESSION['stamp'] != $ctime || !isset($_SESSION['key']) && $_SESSION['key'] != $ckey)
			{
				sign_out();
				exit;
			}
		}
	}
	//if we get to this, then the $_SESSION['HTTP_USER_AGENT'] was not set and the user cannot be validated
	else
	{
		sign_out();
		exit;
	}
}

?>