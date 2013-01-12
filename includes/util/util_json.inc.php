<?php

function parse_json($json, $assoc = false){
	
	if(get_magic_quotes_gpc()){
	  $json = stripslashes($json);
	}
	
	return json_decode($json, false);
}

?>