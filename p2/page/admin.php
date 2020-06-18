<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';
	
	$noPermission = "<div class='noPermission'><div>Keine Berechtigung!</div></div>";

	if(isset($_POST['usid']) && isset($_POST['level']) && getPermission($db, $_SESSION['uid']) >=2){
		$smt = $db->prepare("UPDATE permissions SET permission = :berechtigung WHERE uid = :uid");
		$smt->bindValue(':berechtigung', $_POST['level']);
		$smt->bindValue('uid', $_POST['usid']);
		$smt->execute();
		$info = "Berechtigung gesetzt!";
	}



$uebersicht = getContentFromTemplate("uebersicht", "php");
$userinfo = getUserinformation($db);
if(isset($_GET['sb'])){
	if($_GET['sb'] == "uebersicht"){
		$content = $uebersicht;
	}elseif (($_GET['sb'] == "nutzer") && getPermission($db, $_SESSION['uid']) >= 4) {
		$content = "
		<div class='outer-form'>
			<form method='POST'>
				<h2>Berechtigungs Level &Auml;ndern</h2>
				<div id='space'><label>Nutzer: ";
      		$content .= "<select name='usid'>";
      					while($dbsatz = $userinfo->fetchArray()){
      						$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].",  ".$dbsatz['username']." lv.".getPermission($db, $dbsatz['id'])."
      									</option>";
      					}
      		$content .= "</select>
				</label></div>
  				<div id='space'><label>Neues Level: <input type='number' name='level' min='0' max='4' required></label></div>
      			<p class='information'>".$info."</p>
				<input type='submit' value='&Auml;ndern'/>
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
	if(isset($_SESSION['uid'])){
		if(getPermission($db, $_SESSION['uid']) >= 3){
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
		}else{
			echo $noPermission;
		}
	}else{
		echo $noPermission;
	}

	echo getFooter();
?>
</body>
</html>