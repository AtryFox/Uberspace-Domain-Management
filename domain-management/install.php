<?php
	//exit;
	error_reporting(0);
	
	if(file_exists("config.php")) {
		unlink("install.php");
		header("Location: index.php");
	}	

	if(isset($_COOKIE["msg"])) {
		$msg = $_COOKIE["msg"];
		setcookie("msg", "", 0, "/");
	}

	include("header.php");
	include("functions/main.php");
?>

<div class="container">
	<h1>Installation <small>Uberspace Domain Management</small></h1>
	<hr>
	
	<?php
		include("message.php");		

		if(isset($_POST["install"]) && isset($_POST["username"]) && isset($_POST["password1"]) && isset($_POST["password2"]) && isset($_POST["mysql_host"]) && isset($_POST["mysql_user"]) && isset($_POST["mysql_pass"]) && isset($_POST["mysql_data"]) && isset($_POST["uberspacen"]) ) {
			$username = strtolower($_POST["username"]);
			$password1 = makeHash($_POST["password1"]);
			$password2 = makeHash($_POST["password2"]);

			$mysql_host = $_POST["mysql_host"];
			$mysql_user = $_POST["mysql_user"];
			$mysql_pass = $_POST["mysql_pass"];
			$mysql_data = $_POST["mysql_data"];

			$ubr = $_POST["uberspacen"];

			if($password1 != $password2) {
				setcookie("msg", "I01", time()+60, "/");
				header("Location: install.php");
			}

			$verbindung = mysql_connect ($mysql_host, $mysql_user, $mysql_pass) or die ('<div class="text-center alert alert-danger">Keine Verbindung zum MySQL Server möglich! Starte die Installation neu und stelle sicher, dass die MySQL Logindaten korrekt sind.</div>');
			mysql_select_db($mysql_data) or die ('<div class="text-center alert alert-danger">Keine Verbindung zur Datenbank möglich! Starte die Installation neu und stelle sicher, dass die Datenbank existiert.</div>');
						
			mysql_query("CREATE TABLE users (id int(255) NOT NULL auto_increment,username varchar(256) NOT NULL,password varchar(128) NOT NULL, PRIMARY KEY (id) );");
			mysql_query("CREATE TABLE domains (id int(255) NOT NULL auto_increment,domain varchar(256) NOT NULL, PRIMARY KEY (id) );");						
		
			mysql_query("INSERT INTO users (username, password) VALUES ('".mysql_real_escape_string($username)."', '".mysql_real_escape_string($password1)."');");

			/* CONFIG CREATION */ {
$fp = fopen('config.php', 'w'); 
fputs($fp, '<?php
// main config section of uberspace domain management //

// general //
$uberspacename = "'.$ubr.'";

// mysql // 
$username = "'.$mysql_user.'";
$password = "'.$mysql_pass.'";
$hostname = "'.$mysql_host.'";
$database = "'.$mysql_data.'";
?>
'); 
fclose($fp); 
			}

			unlink("install.php");

			setcookie("msg", "I00", time()+60, "/");
			header("Location: index.php");
		}

		$ubr = split("/", str_replace("/var/www/virtual/", "", realpath("install.php")))[0];
	?>
	<div class="text-center alert alert-info">Die Installation ist einfach. Trage unten deinen Uberspace Nutzernamen, deine MySQL Logindaten sowie belibiege Logindaten, die du später zum einloggen in das Domain Management brauchst, ein und drücke auf <i>Installation starten</i>.</div>
	<hr>
	<div class="col-md-6">
		<form action="install.php" method="post" class="form-horizontal">
			<input type="hidden" name="install">
			<h3>Uberspace Informationen</h3>
			<div class="form-group">
				<label for="uberspacen" class="col-sm-3 control-label">Name</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="uberspacen" placeholder="Uberspace Nutzername" name="uberspacen" required value="<?php echo $ubr; ?>">
				</div>
			</div>
			<hr>
			<h3>MySQL Logindaten</h3>
			<div class="form-group">
				<label for="mysql_host" class="col-sm-3 control-label">Hostname</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mysql_host" placeholder="localhost" name="mysql_host" required value="localhost">
				</div>
			</div>
			<div class="form-group">
				<label for="mysql_user" class="col-sm-3 control-label">Nutzername</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mysql_user" placeholder="MySQL Nutzername" name="mysql_user" required  value="<?php echo $ubr; ?>">
				</div>
			</div>
			<div class="form-group">
				<label for="mysql_pass" class="col-sm-3 control-label">Passwort</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="mysql_pass" placeholder="MySQL Passwort" name="mysql_pass" required>
				</div>
			</div>
			<div class="form-group">
				<label for="mysql_data" class="col-sm-3 control-label">Datenbank</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="mysql_data" placeholder="MySQL Datenbank" name="mysql_data" required  value="<?php echo $ubr; ?>_">
				</div>
			</div>
			<hr>
			<h3>Logindaten</h3>
			<div class="form-group">
				<label for="username" class="col-sm-3 control-label">Nutzername</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="username" placeholder="Gewünschter Nutzername" name="username" required>
				</div>
			</div>
			<div class="form-group">
				<label for="password1" class="col-sm-3 control-label">Passwort</label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password1" placeholder="Gewünschtes Passwort" name="password1" required>
				</div>
			</div>
			<div class="form-group">
				<label for="password2" class="col-sm-3 control-label"></label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password2" placeholder="Gewünschtes Passwort wiederholen" name="password2" required>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-lg btn-primary">Installation starten</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="container">
	<?php include("footer.php"); ?>
</div>