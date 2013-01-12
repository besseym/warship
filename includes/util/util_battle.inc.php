<?php

function start_battle($battle){
	$_SESSION[BATTLE] = serialize($battle);
}

function update_battle($battle){
	$_SESSION[BATTLE] = serialize($battle);
}

function get_current_battle(){
	return unserialize($_SESSION[BATTLE]);
}

function is_at_battle(){
	return !empty($_SESSION[BATTLE]);
}

function end_battle(){
	unset($_SESSION[BATTLE]);
}

?>