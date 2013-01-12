<?php

require_once REAL_BASE . "includes/db/db_helper.inc.php";

//connect to database
$db_install_link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());

//table sql to create
$table_players = "players";
$table_players_sql = "CREATE TABLE `" . $table_players . "`
(
`id` INT(11) UNSIGNED AUTO_INCREMENT,
`md5_id` varchar(200) NOT NULL DEFAULT '',
`email` LONGBLOB,
`name` VARCHAR(255) NOT NULL,
`password` VARCHAR(255) NOT NULL,
`created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`updated_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
`num_logins` INT(11) NOT NULL DEFAULT '0',
`last_login` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
`users_ip` VARCHAR(255) NOT NULL DEFAULT '',
`approved` INT(1) NOT NULL DEFAULT '0',
`activation_code` INT(10) NOT NULL DEFAULT '0',
`ckey` VARCHAR(220) NOT NULL DEFAULT '',
`ctime` VARCHAR(220) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

//table matches sql to create
$table_matches = "matches";
$table_matches_sql = "CREATE TABLE `" . $table_matches . "`
(
`id` INT(11) UNSIGNED AUTO_INCREMENT,
`player1_id` INT(11) UNSIGNED NOT NULL,
`player2_id` INT(11) UNSIGNED NOT NULL,
`player1_score` FLOAT(3,2) UNSIGNED DEFAULT 0.00,
`player2_score` FLOAT(3,2) UNSIGNED DEFAULT 0.00,
`difficulty` INT(5) UNSIGNED NOT NULL,
`winning_player_id` INT(11) UNSIGNED,
`started_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
`completed_at` TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

//create the database if it doesn't already exist
create_database ($db_install_link, DB_DATABASE);

//create the table if it doesn't already exist
create_table($db_install_link, DB_DATABASE, $table_players, $table_players_sql);

//create the table if it doesn't already exist
create_table($db_install_link, DB_DATABASE, $table_matches, $table_matches_sql);

mysql_close($db_install_link);

?>