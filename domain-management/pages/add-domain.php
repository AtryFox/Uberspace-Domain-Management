<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

if (!getLoggedin()) {
	header("Location: ../");
	exit;
}

?>

<form method="post" action="?p=add-domain-func">
	<h3>Domain hinzufügen<input style="margin-left: 20px;" type="submit" class="btn btn-success" value="Senden">
	</h3>


	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon">www.</span>
			<input type="text" class="form-control" name="domain" required placeholder="domain.tld (ohne www)">
		</div>
		<br>

		<div class="input-group">
			<span class="input-group-addon"><?php echo $dir; ?></span>
			<input type="text" class="form-control" name="path" required
				   placeholder="path/to/folder (Groß- und Kleinschreibung beachten!)">
			<span class="input-group-addon">/</span>
		</div>
	</div>
</form>