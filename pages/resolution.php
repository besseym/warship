<?php

require "../includes/constants.inc.php";

//ship models
require REAL_BASE . "includes/model/ships/m_battleship.inc.php";
require REAL_BASE . "includes/model/ships/m_crusier.inc.php";
require REAL_BASE . "includes/model/ships/m_frigate.inc.php";
require REAL_BASE . "includes/model/ships/m_minesweeper.inc.php";

//include models
require REAL_BASE . "includes/model/m_position.inc.php";
require REAL_BASE . "includes/model/m_dimension.inc.php";
require REAL_BASE . "includes/model/m_player.inc.php";
require REAL_BASE . "includes/model/m_board.inc.php";

require REAL_BASE . "includes/model/m_battle_ai_basic.inc.php";
require REAL_BASE . "includes/model/m_battle_ai_advanced.inc.php";


//include db interactions
require REAL_BASE . "includes/db/db_constants" . $server . ".inc.php";
require REAL_BASE . "includes/db/db_connect.inc.php";
require REAL_BASE . "includes/db/db_match.inc.php";

//include utils
require REAL_BASE . "includes/util/util_security.inc.php";
require REAL_BASE . "includes/util/util_battle.inc.php";

session_start();

$player = get_current_player();
$battle = get_current_battle();

complete_match($db_link, $battle);

$is_victory = ($player->id == $battle->winning_player_id);

$battle_result = 'Victory!';
if(!$is_victory) {
	$battle_result = 'Defeat!';
	$player->defeats++;
}
else {
	$player->victories++;
}

update_sign_in($player);

$player_name = $player->name;
$opponent_name = $battle->opponent->name;

end_battle();

?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Warship Resolution</title>
		<link href='http://fonts.googleapis.com/css?family=Unlock' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Allerta+Stencil' rel='stylesheet' type='text/css'>
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo SITE_BASE; ?>styles/common.css" />
		<link type="text/css" rel="stylesheet" media="all" href="<?php echo SITE_BASE; ?>styles/resolution.css" />
	</head>
	<body>
		<div id="main-content">
			<h1><?php echo $battle_result ?></h1>
			<div id="result-container">
			<?php if($is_victory){ ?>
				<p id="victory">You have destroyed the entire fleet of </p>
			<?php } ?>
				<p id="commander">Commander <?php echo $opponent_name ?></p> 
			<?php if(!$is_victory){ ?>
				<p id="defeat">has destroyed your entire fleet.</p>
			<?php } ?>
			</div>
		</div>
	</body>
</html>

<?php mysql_close($db_link); ?>