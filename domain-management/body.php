<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">

			<?php if (getLoggedin()) echo '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Navigation umschalten</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>'; ?>
			<a class="navbar-brand hidden-xs" href="index.php">Uberspace Domain Management</a>
			<a class="navbar-brand visible-xs" style="font-size: 15px;" href="index.php">Uberspace Domain Management</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php

				if (getLoggedin()) {
					echo '<li><a href="?p=add-domain">Domain hinzufügen</a></li>';
					echo '<li><a href="https://deratrox.de/dev/Uberspace_Domain_Management/index.php?v=' . $version . '" target="_blank">Updates suchen</a></li>';
					echo '<li><a href="?p=logout">Logout</a></li>';
				}
				?>
			</ul>
		</div>
	</div>
</div>


<div class="container">
	<div class="error"></div>
	<?php
	include("message.php");

	if (!$tablepreValid) {
		echo '<div class="alert alert-danger"><i class="fa fa-ban"></i> <b>Datenbankfehler!</b> Tabellenpräfix ungültig. Bitte überprüfe deine Konfigurationsdatei und passe diese ggf. an. (Erlaubte Zeichen: <b>a-z</b>, <b>A-Z</b>, <b>0-9</b>, <b>_</b>)</div>';
		$tablepre = "!";
	} else {

		if (!getLoggedin()) {
			include("pages/login.php");
		} else {

			if ($updateStatus != -1) {
				echo '
					<div class="panel panel-info">
					<div class="panel-heading">Version <b>' . $updateStatus . '</b> verfügbar!</div>
					<div class="panel-body">
					Es ist eine neue Version des Uberspace Domain Managements verfügbar. Logge dich via SSH auf deinem Uberspace ein und führe folgende Befehle aus:
					<br><br>
					<pre>cd ' . __DIR__ . '
wget https://deratrox.de/dev/Uberspace_Domain_Management/UberspaceDomainManagement.zip
unzip -u UberspaceDomainManagement.zip -d ./update
rsync -a --delete --exclude=update --exclude=backup.zip --exclude=config.php update/ ./
rm -r update</pre>
					
					Achtung, es werden alle Dateien im Installationsverzeichnis ersetzt bzw. gelöscht. Lege vorher ein Backup mit <code>zip -r backup.zip *</code> an.
					<br><br>
					Das Update kann alternativ per Hand heruntergelanden und auf dem Uberspace hochgeladen werden. <a class="btn btn-primary btn-sm pull-right" href="https://deratrox.de/dev/Uberspace_Domain_Management/UberspaceDomainManagement.zip"><i class="fa fa-download"></i> Download</a>
					</div>
					</div>';
			}
			

			switch ($site) {
				case "home":
					include("pages/domains.php");
					break;
				case "logout":
					include("functions/logout.php");
					break;
				case "add-domain":
					include("pages/add-domain.php");
					break;
				case "edit-domain":
					include("pages/edit-domain.php");
					break;
				case "add-domain-func":
					include("functions/add-domain.php");
					break;
				case "del-domain-func":
					include("functions/del-domain.php");
					break;
				case "edit-domain-func":
					include("functions/edit-domain.php");
					break;
			}
		}
	}
	?>


</div>
<div class="container">
	<?php include("footer.php"); ?>
</div>