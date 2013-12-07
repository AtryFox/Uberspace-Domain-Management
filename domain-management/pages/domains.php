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
			$path1 = $dir.$r["domain"];
			$path2 = $dir."www.".$r["domain"];
			echo "<tr>";
			echo "<td style='text-align: center;  vertical-align:middle;'  valign='middle'>".$r["id"]."</td>";
			echo "<td style='vertical-align:middle;' valign='middle'>".$r["domain"]." (www.".$r["domain"].")
					<br><span style='font-size:9px;'>".$path1.": ".checkLink($path1)."</span>
					<br><span style='font-size:9px;'>".$path2.": ".checkLink($path2)."</span></td>";
			echo "<td style='vertical-align:middle;' valign='middle'>".readlink($path1)."</td>";
			echo "<td style='vertical-align:middle; text-align: center;'>
						<a href='?p=del-domain-func&id=".$r["id"]."'><i class='glyphicon glyphicon-trash'></i></a>
				  </td>";
			echo "</tr>";
		}
	?>
</table>
</div>