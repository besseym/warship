<div class="panel center-panel">
	<form id="registration-form" action="<?php echo PAGE_REGISTER ?>" method="post">
		<fieldset>
		
		<ol>
			<li>
				<label for="email">Email</label>
				<input id="email" name="email" class="required email" type="text" value="<?php echo stripslashes($email) ?>" />
			</li>
			<li>
				<label for="name">Name</label>
				<input id="name" name="name" class="required" type="text" value="<?php echo stripslashes($name) ?>" />
			</li>
			<li>
				<label for="password">Password</label>
				<input id="password" name="password" class="required" type="password" value="">
			</li>
			<li>
				<label for="password-confirm">Confirm Password</label>
				<input id="password-confirm" name="password-confirm" class="required" type="password" value="">
			</li>
			<li>
				<input id="submit" name="submit" type="submit" value="Submit Registration">
			</li>
		</ol>
		
		</fieldset>
	</form>
</div>