<?php
require_once(dirname(__FILE__) . "/../functions/main.php");

loginCheck();

$order = "";
if (isset($_GET["order"])) $order = strtolower($_GET["order"]);

switch ($o) {
	case "id":
		$order = "id";
		break;
	default:
		$order = "domain";
		break;
}

$s = $pdo->prepare("SELECT * FROM $t_domains ORDER BY $order");
$s->execute();

echo "<h3>Hallo " . $_COOKIE["name"] . "!</h3>";

if ($s->rowCount() == 0) {
	echo "<p>Keine Domains vorhanden. Beginne mit dem <a href='?p=add-domain'>hinzufügen</a> einer Domain!</p>";
} else {
	echo "<table class='table table-striped'>";
	echo "<tr>";
	echo "<th style='text-align: center;'><a href='?order=id'>ID</a></th>";
	echo "<th><a href='?order=domain'>Domain</a></th>";
	echo "<th>Verzeichnis</th>";
	echo "<th style='text-align: center;'>Optionen</th>";
	echo "</tr>";

	while ($r = $s->fetch()) {
		$path1 = $dir . $r["domain"];
		$path2 = $dir . "www." . $r["domain"];
		$id = $r["id"];

		echo "<tr>";
		echo "<td style='text-align: center; vertical-align: middle;'  valign='middle'>" . $id . "</td>";
		echo "<td style='vertical-align: middle;' valign='middle'>" . $r["domain"] . " (www." . $r["domain"] . ")
					<br><span style='font-size:9px;'>" . $path1 . ": " . checkLink($path1, $id) . "</span>
					<br><span style='font-size:9px;'>" . $path2 . ": " . checkLink($path2, $id) . "</span></td>";
		echo "<td style='vertical-align: middle;' valign='middle'>" . getLink($path1, $path2) . checkFolder(readlink($path1), readlink($path2)) . "</td>";
		echo "<td style='text-align: center; vertical-align: middle;'><div class='btn-group'>
						<a href='?p=edit-domain&id=" . $id . "' class='btn btn-default'><i class='glyphicon glyphicon-pencil'></i></a>
						<a href='?p=del-domain-func&id=" . $id . "' class='btn btn-default'><i class='glyphicon glyphicon-trash'></i></a>
				  </div></td>";
		echo "</tr>";

	}
}
?>
</table>