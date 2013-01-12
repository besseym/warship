
<div class="panel clearfix">
	<h2><?php echo $leaderboard_title; ?></h2>
	<table class="leaderboard">
		<thead>
			<tr>
				<th>Rank</th>
				<th>Name</th>
				<th>Victories</th>
				<th>Defeats</th>
				<th>Win/Loss Ratio</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				if(count($leaderboard_record_array) > 0){ 
			?>
				<?php 
					$rank = 1;
					foreach($leaderboard_record_array as $record){ 
				?>
				<tr>
					<td><?php echo $rank; ?></td>
					<td><?php echo $record->name; ?></td>
					<td><?php echo $record->total_victories; ?></td>
					<td><?php echo $record->total_defeats; ?></td>
					<td><?php echo $record->score; ?></td>
				</tr>
				<?php
						$rank++; 
					} 
				?>
			<?php } else { ?>
				<tr>
					<td class="no-battles" colspan="6">Currently, no battles have been fought.</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>	