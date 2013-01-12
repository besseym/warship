
<table id="<?php echo $board->player_id ?>" class="board">
	<?php for ($y = 0; $y < $board->get_height(); $y++) {  ?>
	<tr>
		<?php for ($x = 0; $x < $board->get_width(); $x++) {  ?>
			<td id="<?php echo $board->player_id . '_' . $x . '_' . $y; ?>">&nbsp;</td>
		<?php } ?>
	</tr>
	<?php } ?>
</table>