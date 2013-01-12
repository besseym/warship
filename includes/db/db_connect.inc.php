<?php

//connect to database based on predefined constants
$db_link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$db = mysql_select_db(DB_DATABASE, $db_link) or die(mysql_error());

?>