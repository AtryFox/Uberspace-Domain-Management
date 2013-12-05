<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Navigation umschalten</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<a class="navbar-brand hidden-xs" href="index.php">Uberspace Domain Management</a>
			<a class="navbar-brand visible-xs" style="font-size: 15px;" href="index.php">Uberspace Domain Management</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php
					
					if(getLoggedin()) {
						echo '<li><a href="?p=add-domain">Domain hinzufügen</a></li>';
						echo '<li><a href="?p=logout">Logout</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
</div>

<div class="container">
	<?php
		include("message.php");
		
		if(!getLoggedin()) {
			include("pages/login.php");
		} else {
			switch ($site){
				case "home": include("pages/domains.php"); break;
				case "logout": include("functions/logout.php"); break;
				case "add-domain": include("pages/add-domain.php"); break;
				case "add-domain-func": include("functions/add-domain.php"); break;
				case "del-domain-func": include("functions/del-domain.php"); break;
			}
		}
	?>
</div>
<div class="container">
	<?php include("footer.php"); ?>
</div>