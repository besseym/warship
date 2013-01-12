
<?php 

$player_board = $battle->get_board($player->id);
$opponent_board = $battle->get_board($battle->opponent->id);

?>

<script type="text/javascript">

$(document).ready(function() {

	var board_json = {
		'position_ship_url' : "<?php echo SITE_BASE; ?>json/json_position_ship.php",
		'remove_ship_url' : "<?php echo SITE_BASE ?>json/json_remove_ship.php",
		'attack_url' : "<?php echo SITE_BASE; ?>json/json_player_attack.php"
	};
	
	var player_board = <?php echo json_encode($player_board); ?>;
	player_board.json = board_json;
	player_board.doSinkAlerts = true;
	
	var opponent_board = <?php echo json_encode($opponent_board); ?>;
	opponent_board.json = board_json;
	opponent_board.doSinkAlerts = false;
	
	var config = {
		'state' : <?php echo $battle->state; ?>,
		'resolution_url' : "<?php echo PAGE_RESOLUTION; ?>",
		'player' : player_board,
		'opponent' : opponent_board,
		'json' : {
			'change_state_url' : "<?php echo SITE_BASE; ?>json/json_change_state.php"
		}
	};
	
	var battle = pro.warship.Battle(config);
	var tileImageLoader = pro.warship.TileImageLoader();
	tileImageLoader.loadImages();
});

</script>