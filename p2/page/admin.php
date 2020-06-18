<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';



$uebersicht = getContentFromTemplate("uebersicht");

if(isset($_GET['sb'])){
	if($_GET['sb'] == "uebersicht"){
		$content = $uebersicht;
	}elseif ($_GET['sb'] == "nutzer") {
		$content = "
		<div class='outer-form'>
			<form method='POST'>
				<h3>Berechtigungs Level &Auml;ndern</h3>

			</form>
		</div>";
	}
}else{
	$content = $uebersicht;
}








?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
	<title></title>
</head>
<body>
<?php
if(isset($_SESSION['uid']))
{
	echo getNavigationbar($db, $_SESSION['uid']);
}else{
 	echo getNavigationbar($db);
}
?>
<div class='container-admin'>
	<div class="sidebar">
		<ul>
			<li><a href="?sb=uebersicht">&Uuml;bersicht</a></li>
			<li><a href="?sb=nutzer">Nutzer Verwaltung</a></li>
			<li><a href="?sb=changelog">Changelog Verwaltung</a></li>
			<li><a href="?sb=devlog">Devlog Verwaltung</a></li>
			<li><a href="?sb=antraege">Antrags Verwaltung</a></li>
		</ul>
	</div>
	<div class="content-admin">
		<?php echo $content; ?>
	</div>
</div>
<?php
	echo getFooter();
?>
</body>
</html>