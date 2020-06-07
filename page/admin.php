<?php  
session_start();
$db = new SQLite3("../database/database.db");
include 'main.php';

if(isset($_SESSION['uid'])){
	if(isset($_POST['usid']) && isset($_POST['level']) && getPermissionLevel($db, $_SESSION['uid']) >=2){
		$smt = $db->prepare("UPDATE permissions SET permission = :berechtigung WHERE uid = :uid");
		$smt->bindValue(':berechtigung', $_POST['level']);
		$smt->bindValue('uid', $_POST['usid']);
		$smt->execute();
		$info = "Berechtigung gesetzt!";
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/nav.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
	<title></title>
</head>
<?php 
if(isset($_SESSION["uid"])){
	echo showNavigation($db, $_SESSION['uid']);
}else{
	echo showNavigation($db);
}
?>
<body>
	<?php
	if(isset($_SESSION["uid"])){
		if(getPermissionLevel($db, $_SESSION["uid"]) >= 2){
			$userinfo = getUserInformation($db);
			$userperm = 

			$content = "<div class='content-admin'>";
			$content .= "	<div class='item user' id='left'>";
			$content .= "		<div class='item-head'>";
			$content .= "			<h3>User Management</h3>";
			$content .= "		</div>";
			$content .= "		<div class='item-body'>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Zugriffs Level Setzen</h4>";
			$content .= "					<form method='POST'>";
      		$content .= "					<div id='space'><label>Nutzer: ";
      		$content .= "						<select name='usid'>";
      										while($dbsatz = $userinfo->fetchArray()){
      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].",  ".$dbsatz['username']." lv.".getPermissionLevel($db, $dbsatz['id'])."</option>";
      										}
      		$content .= "						</select>";
      		$content .= "					</label></div>";
      		$content .= "					<div id='space'><label>Neues Level: <input type='number' name='level' min='0' max='2' required></label></div>";
      		$content .= "					<p class='information'>".$info."</p>";
			$content .= "					<input type='submit' value='&Auml;ndern'/>";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Passwort Reset</h4>";
			$content .= "				<form method='POST'>";
			$content .= "							";
			$content .= "							";
			$content .= "							";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "		</div>";
			$content .= "	</div>";


			$content .= "	<div class='item changelog' id='right'>";
			$content .= "		<div class='item-head'>";
			$content .= "			<h3>Changelog Management</h3>";
			$content .= "		</div>";
			$content .= "		<div class='item-body'>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Changelog hinzufügen</h4>";
			$content .= "				<form method='POST'>";
			$content .= "							";
			$content .= "							";
			$content .= "							";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Changelog bearbeiten</h4>";
			$content .= "				<form method='POST'>";
			$content .= "							";
			$content .= "							";
			$content .= "							";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Changelog entfernen</h4>";
			$content .= "				<form method='POST'>";
			$content .= "							";
			$content .= "							";
			$content .= "							";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "		</div>";
			$content .= "	</div>";


			if(isUserDev($db, $_SESSION['uid'])){
				$content .= "	<div class='item devlog' id='left'>";
				$content .= "		<div class='item-head'>";
				$content .= "			<h3>Devlog Management</h3>";
				$content .= "		</div>";
				$content .= "		<div class='item-body'>";
				$content .= "			<div class='item-form'>";
				$content .= "				<h4>Devlog hinzufügen</h4>";
				$content .= "				<form method='POST'>";
				$content .= "							";
				$content .= "							";
				$content .= "							";
				$content .= "				</form>";
				$content .= "			</div>";
				$content .= "			<div class='item-form'>";
				$content .= "				<h4>Devlog bearbeiten</h4>";
				$content .= "				<form method='POST'>";
				$content .= "							";
				$content .= "							";
				$content .= "							";
				$content .= "				</form>";
				$content .= "			</div>";
				$content .= "			<div class='item-form'>";
				$content .= "				<h4>Devlog entfernen</h4>";
				$content .= "				<form method='POST'>";
				$content .= "							";
				$content .= "							";
				$content .= "							";
				$content .= "				</form>";
				$content .= "			</div>";
				$content .= "		</div>";
				$content .= "	</div>";
			}




			$content .= "</div>";
		}else{
			$content = "<div class='denied'><h1>Access denied!</h1></div>";
		}
	}else{
		$content = "<div class='denied'><h1>Access denied!</h1></div>";
	}


	echo $content;
	?>
</body>
</html>