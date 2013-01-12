<div class="panel clearfix">
	<div class="left half-panel">
		<h2 class="commander">Commander <?php echo $player->name; ?></h2>
		
		<div id="record-details">
			<ul>
				<li>
					<label for="victories">Victories: </label>
					<input disabled value="<?php echo $player->victories ?>" />
				</li>
				<li>
					<label for="defeats">Defeats: </label>
					<input disabled value="<?php echo $player->defeats ?>" />
				</li>
			</ul>
		</div>
	</div>
	<div class="left half-panel">
	
		<form action="<?php echo PAGE_PROFILE ?>" method="post">
	
			<fieldset id="new-battle">
				<legend>New Battle</legend>
				
				<div class="left half-panel clearfix">
					<h3>Board Size</h3>
					<ul>
						<li>
							<input type="radio" id="board-size-8" name="board-size" value="8x8" checked />
							<label for="board-size-8">8 x 8</label>
						</li>
						<li>
							<input type="radio" id="board-size-10" name="board-size" value="10x10" />
							<label for="board-size-10">10 x 10</label>
						</li>
						<li>
							<input type="radio" id="board-size-12" name="board-size" value="12x12" />
							<label for="board-size-12">12 x 12</label>
						</li>
					</ul>
				</div>
				
				<div class="left half-panel clearfix">
					<h3>Opponent</h3>
					<input type="hidden" id="opponent-id" name="opponent-id" value="0" />
					<input type="text" id="opponent" name="opponent" value="Computer" />
					
					<h4>Difficulty</h4>
					<ul>
						<li>
							<input type="radio" id="difficulty-basic" name="difficulty" value="basic" checked />
							<label for="difficulty-basic">Beginner</label>
						</li>
						<li>
							<input type="radio" id="difficulty-advanced" name="difficulty" value="advanced" />
							<label for="difficulty-advanced">Advanced</label>
						</li>
					</ul>
				</div>
				
				<input id="submit" name="submit" type="submit" value="Start Battle">
				
			</fieldset>
		
		</form>
	</div>
</div>