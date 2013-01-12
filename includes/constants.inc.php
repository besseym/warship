<?php

//configuration variables that will be modified with environment configs
$server = "_local";

//include "config.local.php";
//include "config.husseini.php";
//include "config.mbessey.php";
include "config.live.php";

define ("REAL_BASE", $_SERVER['DOCUMENT_ROOT'] . $local_path);

//determine if there is a custom port
$port = "";
if($_SERVER['SERVER_PORT'] != "" and $_SERVER['SERVER_PORT'] != "80"){
	$port = ":" . $_SERVER['SERVER_PORT'];
}

//define base of site
define ("SITE_BASE", "http://" . $_SERVER['SERVER_NAME'] . $port . $local_path);

//define page locations
define ("PAGE_HOME", SITE_BASE . "?p=home");
define ("PAGE_REGISTER", SITE_BASE . "?p=register");
define ("PAGE_PROFILE", SITE_BASE . "?p=profile");
define ("PAGE_BATTLE", SITE_BASE . "?p=battle");
define ("PAGE_BEGINNER_LEADERBOARD", SITE_BASE . "?p=beginner_leaderboard");
define ("PAGE_ADVANCED_LEADERBOARD", SITE_BASE . "?p=advanced_leaderboard");
define ("PAGE_SIGN_OUT", SITE_BASE . "?p=sign_out");
define ("PAGE_ACTIVATION", SITE_BASE . "?p=activation");

define ("PAGE_RESOLUTION", SITE_BASE . "pages/resolution.php");

//define session attributes
define ("PLAYER", "player");
define ("BATTLE", "battle");

//define game constants
define ("SHIP_ORIENTATION_HORIZONTAL", 0);
define ("SHIP_ORIENTATION_VERTICAL", 1);

define ("STATE_BATTLE_SETUP", 0);
define ("STATE_BATTLE_CONFLICT", 1);
define ("STATE_BATTLE_RESOLUTION", 2);

define ("TILE_BLANK", 0);
define ("TILE_HIT", 1);
define ("TILE_MISS", 2);

define ("GLOBAL_EMAIL", "admin@warship.pro");

?>