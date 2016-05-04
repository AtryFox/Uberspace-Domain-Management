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
					echo '<li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Optionen <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					echo '<li><a href="?p=add-domain"><i class="fa fa-plus fa-fw"></i> Domain hinzufügen</a></li>';
					echo '<li><a href="?p=uberspace"><i class="fa fa-eye fa-fw"></i> Aufgeschaltete Doamins / Zertifikate anzeigen</a></li>';
					echo '</ul>';
					echo '</li>';
					echo '<li class="dropdown">';
					echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $_COOKIE["name"] . ' <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					echo '<li><a href="#"><i class="fa fa-lock fa-fw"></i> Password ändern</a></li>';
					echo '<li><a href="?p=logout"><i class="fa fa-sign-out fa-fw"></i> Abmelden</a></li>';
					echo '</ul>';
					echo '</li>';
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
			echo $m->render('login');
		} else {

			if ($updateStatus != -1) {
				echo '
					<div class="panel panel-info" id="updatePanel">
					<div class="panel-heading">Version <b>' . $updateStatus . '</b> verfügbar!<button type="button" class="close" data-toggle="modal" data-target="#closeUpdatePanelModal"><span aria-hidden="true">&times;</span></button></div>
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
					echo $m->render('domains', $data);
					break;
				case "logout":
					include("functions/logout.php");
					break;
				case "add-domain":
					echo $m->render('add-domain', $data);
					break;
				case "edit-domain":
					echo $m->render('edit-domain', $data);
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
				case "uberspace":
					echo $m->render('uberspace', $data);
					break;
			}
		}
	}
	?>

	<div class="modal fade" tabindex="-1" role="dialog" id="closeUpdatePanelModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Benachrichtigung ausblenden</h4>
				</div>
				<div class="modal-body">
					<p>Soll die Updatebenachrichtigung wirklich deaktiviert werden?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
					<button type="button" class="btn btn-primary" onclick="disableModal(1)">1 Tag</button>
					<button type="button" class="btn btn-primary" onclick="disableModal(7)">1 Woche</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<?php include("footer.php"); ?>
</div>

<!-- ALL THE JAVASCRIPT FILES -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>