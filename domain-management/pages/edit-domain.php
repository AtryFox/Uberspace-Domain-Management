<?php
	if(!getLoggedin()) {
		exit;
	}
	
	if($_GET["id"] == "") {
		$msg = "E02";
		include("message.php");
		exit;
	}
	
	$id = $_GET["id"];
	
	$q = mysql_query("SELECT * FROM domains WHERE id =".$id.";");
	
	while ($r = mysql_fetch_array($q)) {
		$domain = $r["domain"];
		$path = "";
		if(is_link($dir.$domain)) $path = substr(str_replace($dir, "", readlink($dir.$domain)), 0, -1);
	}
	
	if($domain == "") {
		$msg = "E02";
		include("message.php");
		exit;
	}
?>
<div class="col-md-7">
	<form method="post" action="?p=add-domain-func">
		<h3>Domain bearbeiten<input style="margin-left: 20px;" type="submit" class="btn btn-success" value="Senden"></h3>


		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">www.</span>
				<input type="text" class="form-control" name="domain" required value="<?php echo $domain; ?>" disabled="true">
			</div>
			<br>
			<div class="input-group">
				<span class="input-group-addon"><?php echo $dir; ?></span>
				<input type="text" class="form-control" name="path" required placeholder="path/to/folder (Groß- und Kleinschreibung beachten!)" value="<?php echo $path; ?>">
				<span class="input-group-addon">/</span>
			</div>
		</div>
	</form>
</div>