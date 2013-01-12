<?php if(!$is_active){ ?>
<div id="activation-panel" class="panel">
<form action="<?php echo PAGE_ACTIVATION ?>" method="post">
<fieldset>

	<ol>
		<li>
			<label for="email">Email</label>
			<input id="email" name="email" type="text" value="<?php echo stripslashes($email) ?>" />
		</li>
		<li>
			<label for="activation_code">Activation Code:</label>
			<input id="activation_code" name="activation_code" type="text" value="<?php echo stripslashes($activation_code) ?>">
		</li>
		<li>
			<div class="submit">
			<input type="submit" name="activate" value="Activate Account" />
			</div>
		</li>
	</ol>
</fieldset>
</form>
</div>
<?php } ?>