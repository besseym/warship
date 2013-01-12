<div class="panel clearfix">

	<h2 id="battle-status">Strategically Place Your Ships</h2>
	<div id="instructions" class="clearfix">
		
		<div id="setup-instructions" <?php if ($battle->state != STATE_BATTLE_SETUP) { ?>class="hidden"<?php } ?>>
			<div class="left half-panel">
				<h3>Instructions</h3>
				<ul>
					<li>To place a ship select a ship type from the options on the right and then <strong>move your mouse</strong> over your board. </li>
					<li>You can select the orientation of the ship you are placing using the placement controls or you can toggle between the horizontal and vertical orientation using the <strong>TAB</strong> key.
					<li>Once you have decided where to place the ship, <strong>click on the board</strong> to place the ship.</li>
					<li>The number of ships of a given type to be placed is located <strong>next to</strong> the ship type label.</li>
					<li>You can remove a ship you have previously placed by <strong>double clicking</strong> on that ship.</li>
				</ul>
			</div>
			
			<div id="placement-controls" class="left half-panel">
				<h3>Placement Controls</h3>
				<ul id="orientation-select-list">
					<li>
						<input type="radio" id="horizontal-select" name="orientation-select" value="horizontal-select" class="orientation-select" checked /> 
						<label for="horizontal-select">Horizontal</label>
					</li>
					<li>
						<input type="radio" id="vertical-select" name="orientation-select" value="vertical-select" class="orientation-select" /> 
						<label for="vertical-select">Vertical</label>
					</li>
				</ul>
			
				<ul>
				
					<table id="ship-select-table">
						<tr id="battleship-select-label">
							<td >
								<input type="radio" id="battleship-select" name="ship-select" value="battleship-select" class="ship-select" /> 
								<label  class="select-label" for="battleship-select" >Battleship</label>
							</td>
							<td>
								<span id="battleship-select-count" class="ship-select-count">1</span>
							</td>
						</tr>
						<tr id="crusier-select-label">
							<td >
								<input type="radio" id="crusier-select" name="ship-select" value="crusier-select" class="ship-select" /> 
								<label  class="select-label" for="crusier-select">Crusier</label>
							</td>
							<td>
								<span id="crusier-select-count" class="ship-select-count">2</span>
							</td>
						</tr>
						<tr id="frigate-select-label">
							<td >
								<input type="radio" id="frigate-select" name="ship-select" value="frigate-select" class="ship-select" /> 
								<label  class="select-label" for="frigate-select">Frigate </label>
							</td>
							<td>
								<span id="frigate-select-count" class="ship-select-count">3</span>
							</td>
						</tr>
						<tr id="minesweeper-select-label">
							<td >
								<input type="radio" id="minesweeper-select" name="ship-select" value="minesweeper-select" class="ship-select" /> 
								<label  class="select-label" for="minesweeper-select">Minesweeper</label>
							</td>
							<td>
								<span id="minesweeper-select-count" class="ship-select-count">4</span>
							</td>
						</tr>
					</table>
				</ul>
				
				<p>
					Once you have finished placing your ships on the board click here to begin the battle:
					
				</p>
				<div id="begin-battle">
					<button id="begin-battle-button" type="button" disabled>Let the Battle Begin!</button>
				</div>
			</div>
		</div>
		
		<div id="state-of-conflict" <?php if ($battle->state != STATE_BATTLE_CONFLICT) { ?>class="hidden"<?php } ?>>
			<div class="left half-panel">
				<h3>State of you Fleet - Ships still in the Battle</h3>
				<table id="fleet-state">
					<tr>
						<td id="battleship-remaining-label">Battleship:</td>
						<td id="battleship-remaining" class="ships-remaining">
							<?php echo $battle->get_floating_ship_count($player->id, 'battleship'); ?>
						</td>
					</tr>
					<tr>
						<td id="crusier-remaining-label">Crusiers:</td>
						<td id="crusier-remaining" class="ships-remaining">
							<?php echo $battle->get_floating_ship_count($player->id, 'crusier'); ?>
						</td>
					</tr>
					<tr>
						<td id="frigate-remaining-label">Frigates:</td>
						<td id="frigate-remaining" class="ships-remaining">
							<?php echo $battle->get_floating_ship_count($player->id, 'frigate'); ?>
						</td>
					</tr>
					<tr>
						<td id="minesweeper-remaining-label">Minesweeper:</td>
						<td id="minesweeper-remaining" class="ships-remaining">
							<?php echo $battle->get_floating_ship_count($player->id, 'minesweeper'); ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
	</div>

	<div class="clearfix">
		<div class="left half-panel">
			<h2>Commander <?php echo $player->name ?></h2>
		
			<?php $board = $battle->get_board($player->id); ?>
			<?php require REAL_BASE . "/includes/segments/seg_board.inc.php"; ?>
			
		</div>
		
		
		<div class="left half-panel">
			<h2>Commander <?php echo $battle->opponent->name ?></h2>
			
			<?php $board = $battle->get_board($battle->opponent->id); ?>
			<?php require REAL_BASE . "/includes/segments/seg_board.inc.php"; ?>
			
		</div>
	</div>
	
	
	<div id="resolution-overlay" class="overlay" style="display: none;"></div>
	<div id="resolution-overlay-content" class="overlay-content-container" style="display: none;">
		<div class="overlay-content">
			<iframe id="resolution-frame" src=""></iframe>
			<div id="resolution-action">
				<a href="<?php echo PAGE_PROFILE ?>">Return to Profile</a>
			</div>
		</div>
	</div>

</div>