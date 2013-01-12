<?php $has_messages = !empty($messageArray); ?>
<div id="flash" class="<?php if(!$has_messages){ ?>hidden<?php } ?>">
	<?php if($has_messages) { ?>
	<ul>
		<?php foreach($messageArray as $m){ ?>
			<li><?php echo $m ?></li>
		<?php } ?>
	</ul>
	<?php } ?>
</div>