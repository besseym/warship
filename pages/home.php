



<?php if(!$is_signed_in) { ?>
<div id="sign-in-panel" class="panel">
	<form id="sign-in-form" action="<?php echo PAGE_HOME ?>" method="post">
	<fieldset>
	
		<ol>
			<li>
				<label for="email">Email</label>
				<input id="email" name="email" class="required email" type="text" value="<?php echo stripslashes($email) ?>" />
			</li>
			<li>
				<label for="password">Password</label>
				<input id="password" name="password" class="required" type="password" value="">
			</li>
			<li>
				<div class="submit">
				<input id="submit" name="submit" type="submit" value="Sign In">
				</div>
			</li>
		</ol>
		<p>
			or <a href="<?php echo PAGE_REGISTER ?>">Register to Play</a>
		</p>
	</fieldset>
	</form>
</div>
<?php } else { ?>

<div class="panel">
	<h2>About Warship</h2>
	<p>Warship is a web based re-implementation of the classic game Battleship. The purpose of Warship is to create a fun interactive experience that brings back people's recollections of time spent with this classic board game as well as provide players with new experiences through a modern re-implementation of Battleship's game-play and aesthetics. This game should be enjoyed by all including casual gamers, sentimental board game enthusiasts, and retired navel officers.</p>
</div>

<?php } ?>

</div>
