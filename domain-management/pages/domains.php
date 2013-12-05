<div class="col-md-12">
<h3>Hallo <?php echo $_COOKIE["name"]; ?>!</h3>
<table class="table table-striped">
	<tr>
		<th style="text-align: center;"><a href="?order=id">ID</a></th>
		<th><a href="?order=domain">Domain</a></th>
		<th>Verzeichnis</th>
		<th style="text-align: center;">Optionen</th>
	</tr>
	<?php
		$o = "";
		if(isset($_GET["order"])) $o = strtolower($_GET["order"]);
		
		switch ($o) {
			case "id": $q = mysql_query("SELECT * FROM domains ORDER BY id"); break;
			default: $q = mysql_query("SELECT * FROM domains ORDER BY domain");
		}
	
		while ($r = mysql_fetch_array($q)) {
			echo "<tr>";
			echo "<td style='text-align: center;'>".$r["id"]."</td>";
			echo "<td>".$r["domain"]." (www.".$r["domain"].")</td>";
			echo "<td>".readlink($dir.$r["domain"])."</td>";
			echo '<td style="text-align: center;">
						<a href="?p=del-domain-func&id='.$r["id"].'"><i class="glyphicon glyphicon-trash"></i></a>
				  </td>';
			echo "</tr>";
		}
	?>
</table>
</div>