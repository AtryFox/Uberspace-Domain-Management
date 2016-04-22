<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();

if (!isset($_GET["id"])) {
	$msg = "E02";
	include("message.php");
	exit;
}

$id = $_GET["id"];

$s = $pdo->prepare("SELECT * FROM $t_domains WHERE id = :id LIMIT 1");
$s->execute(array('id' => $id));

while ($r = $s->fetch()) {
	$domain = $r["domain"];
	$path = "";
	if (is_link($dir . $domain)) $path = substr(str_replace($dir, "", readlink($dir . $domain)), 0, -1);
	else if (is_link($dir . "www." .$domain)) $path = substr(str_replace($dir, "", readlink($dir . "www." .$domain)), 0, -1);
}

if ($domain == "") {
	$msg = "E02";
	include("message.php");
	exit;
}
?>
<form method="post" action="?p=edit-domain-func">
	<h3>Domain bearbeiten<input style="margin-left: 20px;" type="submit" class="btn btn-success" value="Senden"></h3>
	<input type="hidden" name="id" value="<?php echo $id; ?>">

	<div class="form-group">
		<div class="input-group">
			<span class="input-group-addon">www.</span>
			<input type="text" class="form-control" required value="<?php echo $domain; ?>" disabled="true">
		</div>
		<br>

		<div class="input-group">
			<span class="input-group-addon"><?php echo $dir; ?></span>
			<input type="text" class="form-control" name="path" required
				   placeholder="path/to/folder (Groß- und Kleinschreibung beachten!)" value="<?php echo $path; ?>">
			<span class="input-group-addon">/</span>
		</div>
	</div>
</form>