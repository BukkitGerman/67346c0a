<?php  
session_start();
$db = new SQLite3("../database/database.db");
include 'main.php';

if(isset($_SESSION['uid'])){


	if(isUserDev($db, $_SESSION['uid'])){
		$debug_status = getDebugStatus($db, $_SESSION['uid']);
	}


	if(isset($_POST['usid']) && isset($_POST['level']) && getPermissionLevel($db, $_SESSION['uid']) >=2){
		$smt = $db->prepare("UPDATE permissions SET permission = :berechtigung WHERE uid = :uid");
		$smt->bindValue(':berechtigung', $_POST['level']);
		$smt->bindValue('uid', $_POST['usid']);
		$smt->execute();
		$info = "Berechtigung gesetzt!";
	}

	if(isset($_POST['dev-usid']) && isset($_POST['dev-level']) && isUserDev($db, $_SESSION['uid'])){
		$smt = $db->prepare("UPDATE permissions SET developer = :dev WHERE uid = :uid");
		$smt->bindValue(':dev', $_POST['dev-level']);
		$smt->bindValue('uid', $_POST['dev-usid']);
		$smt->execute();
		$info2 = "Berechtigung gesetzt!";
	}

	if(isset($_POST['reset_usid']) && getPermissionLevel($db, $_SESSION['uid']) >= 2){
		$reset_uniq_id = uniqid("rspw");
		$smt = $db->prepare("SELECT * FROM password_reset WHERE uid = :uid");
		$smt->bindValue(':uid', $_POST['reset_usid']);
		$smt = $smt->execute();
		$smt = $smt->fetchArray();
		if($smt == false){
			echo "Test";
			$rs = $db->prepare("INSERT INTO password_reset (uid, key) VALUES (:uid, :key)");
			$rs->bindValue(':uid', $_POST['reset_usid']);
			$rs->bindValue(':key', $reset_uniq_id);
			$rs->execute();
		}else{
			$rs = $db->prepare("UPDATE password_reset SET key = :key WHERE uid = :uid");
			$rs->bindValue(':uid', $_POST['reset_usid']);
			$rs->bindValue(':key', $reset_uniq_id);
			$rs->execute();
		}

		$user = getUserInformation($db, $_POST['reset_usid']);

		$link = "gamer4life.net/reset_passwort.php?key=".$reset_uniq_id;

		$message = "Hier ist dein Reset link: " . $link;

		mail($user['email'], "Passwort Reset", $message);
	} 

	if(isset($_POST['changelog_head']) && isset($_POST['changelog_body']) && getPermissionLevel($db, $_SESSION['uid']) >= 2){
		$smt = $db->prepare("INSERT INTO changelog (uid_creator, header, change) VALUES (:uid_creator, :header, :body)");
		$smt->bindValue(':uid_creator', $_SESSION['uid']);
		$smt->bindValue(':header', filter_var($_POST['changelog_head'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->bindValue(':body', filter_var($_POST['changelog_body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->execute();

		$changelog_message = "Changelog wurde erstellt!";
	}

	if(isset($_POST['changelog_id_bearbeiten']) && getPermissionLevel($db, $_SESSION['uid']) >= 2){
		if(isset($_POST['changelog_head_edit'])){
			$smt = $db->prepare("UPDATE changelog SET header = :header WHERE id = :id");
			$smt->bindValue(':header', $_POST['changelog_head_edit']);
			$smt->bindValue(':id', $_POST['changelog_id_bearbeiten']);
			$smt->execute();
		}
		if(isset($_POST['changelog_body_edit'])){
			$smt = $db->prepare("UPDATE changelog SET change = :body WHERE id = :id");
			$smt->bindValue(':body', $_POST['changelog_body_edit']);
			$smt->bindValue(':id', $_POST['changelog_id_bearbeiten']);
			$smt->execute();
		}
	}

	if(isset($_POST['changelog_id_loeschen']) && getPermissionLevel($db, $_SESSION['uid']) >= 2){
		$smt = $db->prepare("DELETE FROM changelog WHERE id = :id");
		$smt->bindValue(':id', $_POST['changelog_id_loeschen']);
		$smt->execute();
	}


	if(isset($_POST['debug_user']) && isset($_POST['debug'])&& isUserDev($db, $_SESSION['uid'])){


			$smt = $db->prepare("UPDATE dev_settings SET debug = :debug WHERE uid = :uid");
			$smt->bindValue(':debug', $_POST['debug']);
			$smt->bindValue(':uid', $_POST['debug_user']);
			$smt->execute();
	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/admin.css">
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
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
			$changelog_posts = getChangelogPosts($db);
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

			if(isUserDev($db, $_SESSION['uid'])){
				$content .= "			<div class='item-form'>";
				$content .= "				<h4>Developer Level Setzen</h4>";
				$content .= "					<form method='POST'>";
	      		$content .= "					<div id='space'><label>Nutzer: ";
	      		$content .= "						<select name='dev-usid'>";
	      										while($dbsatz = $userinfo->fetchArray()){
	      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].",  ".$dbsatz['username']." lv.".getPermissionLevel($db, $dbsatz['id'])." Dev: ".isUserDev($db, $dbsatz['id'])."</option>";
	      										}
	      		$content .= "						</select>";
	      		$content .= "					</label></div>";
	      		$content .= "					<div id='space'><label>Neues Level: <input type='number' name='dev-level' min='0' max='1' required></label></div>";
				$content .= "					<input type='submit' value='&Auml;ndern'/>";
				$content .= "				</form>";
				$content .= "					<p class='information'>".$info2."</p>";
				$content .= "			</div>";


				$content .= "			<div class='item-form'>";
				$content .= "				<h4>Debug Settings</h4>";
				$content .= "				<form method='POST'>";
				$content .= "					<div id='space'><label>Nutzer: ";
	      		$content .= "						<select name='debug_user'>";
	      										while($dbsatz = $userinfo->fetchArray()){
	      											if(isUserDev($db, $dbsatz['id'])){
	      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].",  ".$dbsatz['username']." lv.".getPermissionLevel($db, $dbsatz['id']).", Debug: ".getDebugStatus($db, $dbsatz['id'])."</option>";
	      											}
	      										}
	      		$content .= "						</select>";
	      		$content .= "					</label></div>";
	      		$content .= "					<div id='space'><label>Debug: <input type='number' name='debug' min='0' max='1' required></label></div>";
	      		$content .= "					<p class='information'>".$info3."</p>";
				$content .= "					<input type='submit' value='&Auml;ndern'/>";
				$content .= "				</form>";
				$content .= "			</div>";
			}

			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Passwort Reset</h4>";
			$content .= "				<form method='POST'>";
			$content .= "					<div id='space'><label>Nutzer: ";
      		$content .= "						<select name='reset_usid'>";
      										while($dbsatz = $userinfo->fetchArray()){
      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].",  ".$dbsatz['username']." lv.".getPermissionLevel($db, $dbsatz['id'])."</option>";
      										}
      		$content .= "						</select>";
      		$content .= "					</label></div>";
			$content .= "					<input type='submit' value='Zur&uuml;cksetzen'/>";
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
			$content .= "					<div><label>Überschrift:</label>";
			$content .= "							<input type='text' name='changelog_head' required></div>";
			$content .= "							<label>Changelog: <br><textarea id='text' name='changelog_body' cols='30' rows='4' required></textarea></label>";
			$content .= "					<input type='submit' value='Erstellen'/>";
			$content .= "				</form>";
			$content .= "				<div class='information'>".$changelog_message."</div>";
			$content .= "			</div>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Changelog bearbeiten</h4>";
			$content .= "				<form method='POST'>";
			$content .= "					<div><label>Changelog Auswählen</div>";
			$content .= "							<select name='changelog_id_bearbeiten'>";
      										while($dbsatz = $changelog_posts->fetchArray()){
      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id']."</option>";
      										}
      		$content .= "						</label></select>";
			$content .= "					<div><label>Überschrift:</label>";
			$content .= "							<input type='text' name='changelog_head_edit'></div>";
			$content .= "							<label>Changelog: <textarea id='text' name='changelog_body_edit' cols='30' rows='4'></textarea></label>";
			$content .= "					<input type='submit' value='&Auml;ndern'/>";
			$content .= "				</form>";
			$content .= "			</div>";
			$content .= "			<div class='item-form'>";
			$content .= "				<h4>Changelog entfernen</h4>";
			$content .= "				<form method='POST'>";
			$content .= "							<div><label>Changelog Auswählen</div>";
			$content .= "							<select name='changelog_id_loeschen'>";
      										while($dbsatz = $changelog_posts->fetchArray()){
      											$content.= "<option value='".$dbsatz['id']."'>".$dbsatz['id']."</option>";
      										}
      		$content .= "						</label></select><br>";
      		$content .= "					<input type='submit' value='L&ouml;schen'/>";
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


				$content .= "	<div class='item devlog' id='left'>";
				$content .= "		<div class='item-head'>";
				$content .= "			<h3>Devlog Management</h3>";
				$content .= "		</div>";
				$content .= "		<div class='item-body'>";
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