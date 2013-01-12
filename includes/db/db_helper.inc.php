<?php

function create_database($db_link, $database){

	$db = mysql_select_db($database, $db_link);
	if($db){
		error_log("DB INSTALL: Database '" . $database . "' already exists.");
	}
	else {
		//Create the DB
		$create = mysql_query("CREATE DATABASE IF NOT EXISTS " . $database, $db_link) or die(mysql_error());
		
		error_log("DB INSTALL: Database '" . $database . "' created.");
	}
}

function check_table($db_link, $database, $table_name){

	//Select db
	$db = mysql_select_db($database, $db_link) or die(mysql_error());
	
	//Check if table already exists
	$check = mysql_query("SELECT * FROM " . $table_name . " LIMIT 1", $db_link);
	
	return $check;
}

function create_table($db_link, $database, $table_name, $table_sql){
	
	//Select db
	$db = mysql_select_db($database, $db_link) or die(mysql_error());
	
	//Check if table already exists
	$check = mysql_query("SELECT * FROM " . $table_name . " LIMIT 1", $db_link);
	if( !$check ) {
	
		$create_table = mysql_query($table_sql, $db_link) or die(mysql_error());
		if($create_table){
			error_log("DB INSTALL: Table '" . $table_name . "' created.");
		}
		else {
			error_log("DB INSTALL: Creation of table '" . $table_name . "' failed.");
		}
	}
	else {
		error_log("DB INSTALL: Table '" . $table_name . "' already exists.");
	}
}

function query_row_count($table_name){

	$result = mysql_query("SELECT count(id) count FROM " . $table_name);
	$row = mysql_fetch_assoc($result);
	
	return $row['count'];
}

function db_string_filter($value){

	$value = trim(htmlentities(strip_tags($value)));
	
	if (get_magic_quotes_gpc()){
		$value = stripslashes($value);
	}
	
	return mysql_real_escape_string($value);
}

?>