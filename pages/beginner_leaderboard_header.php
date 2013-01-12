<?php

/*Secured user only page*/
secure_page();

$leaderboard_title = "Leaderboard of Beginners";
$leaderboard_record_array = select_beginner_leaderboard($db_link);

?>