<?php while ($err = array_shift($_SESSION['errors'])) { ?>
	<div class="error"><span><?php echo $err; ?></span></div>
<?php } while ($msg = array_shift($_SESSION['messages'])) { ?>
	<div class="message"><span><?php echo $msg; ?></span></div>
<?php } ?>
