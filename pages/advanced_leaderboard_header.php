<?php

/*Secured user only page*/
secure_page();

$leaderboard_title = "Leaderboard of Advanced Players";
$leaderboard_record_array = select_advanced_leaderboard($db_link);

?>