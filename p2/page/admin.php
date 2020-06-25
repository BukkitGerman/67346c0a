<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';
	
	$noPermission = "<div class='noPermission'><div>Keine Berechtigung!</div></div>";

	//*****************************************//
	//*************User Management*************//
	//*****************************************//

	if(isset($_POST['usid']) && isset($_POST['level']) && isAdmin($db, $_SESSION['uid'])){
		$smt = $db->prepare("UPDATE permissions SET permission = :berechtigung WHERE uid = :uid");
		$smt->bindValue(':berechtigung', $_POST['level']);
		$smt->bindValue('uid', $_POST['usid']);
		$smt->execute();
		$info = "Berechtigung gesetzt!";
	}


	//**********************************************//
	//*************Changelog Management*************//
	//**********************************************//

	if(isset($_POST['changelog_head']) && isset($_POST['changelog_body']) && isModerator($db, $_SESSION['uid'])){
		$smt = $db->prepare("INSERT INTO changelog (uid_creator, header, change) VALUES (:uid_creator, :header, :body)");
		$smt->bindValue(':uid_creator', $_SESSION['uid']);
		$smt->bindValue(':header', filter_var($_POST['changelog_head'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->bindValue(':body', filter_var($_POST['changelog_body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->execute();

		$changelog_message = "Changelog wurde erstellt!";
	}

	if(isset($_POST['changelog_rm_id']) && isModerator($db, $_SESSION['uid'])){
		$smt = $db->prepare("DELETE FROM changelog WHERE id = :id");
		$smt->bindValue(":id", $_POST['changelog_rm_id']);
		$smt->execute();

		$changelog_message = "Changelog wurde gel&ouml;scht!";
	}


	//*****************************************//
	//*************News Management*************//
	//*****************************************//

	if(isset($_POST['news_head']) && isset($_POST['news_body']) && isModerator($db, $_SESSION['uid'])){
		$smt = $db->prepare("INSERT INTO neuigkeiten (uid_creator, header, neuigkeit) VALUES (:uid_creator, :header, :body)");
		$smt->bindValue(':uid_creator', $_SESSION['uid']);
		$smt->bindValue(':header', filter_var($_POST['news_head'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->bindValue(':body', filter_var($_POST['news_body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->execute();

		$news_message = "Neuigkeit wurde erstellt!";
	}

	if(isset($_POST['news_rm_id']) && isModerator($db, $_SESSION['uid'])){
		$smt = $db->prepare("DELETE FROM neuigkeiten WHERE id = :id");
		$smt->bindValue(":id", $_POST['news_rm_id']);
		$smt->execute();

		$news_message = "Neuigkeit wurde gel&ouml;scht!";
	}

	//*******************************************//
	//*************Devlog Management*************//
	//*******************************************//

	if(isset($_POST['devlog_head']) && isset($_POST['devlog_body']) && isDeveloper($db, $_SESSION['uid'])){
		$smt = $db->prepare("INSERT INTO devlog (uid_creator, header, log) VALUES (:uid_creator, :header, :body)");
		$smt->bindValue(':uid_creator', $_SESSION['uid']);
		$smt->bindValue(':header', filter_var($_POST['devlog_head'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->bindValue(':body', filter_var($_POST['devlog_body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		$smt->execute();

		$devlog_message = "Devlog wurde erstellt!";
	}

	if(isset($_POST['devlog_rm_id']) && isDeveloper($db, $_SESSION['uid'])){
		$smt = $db->prepare("DELETE FROM devlog WHERE id = :id");
		$smt->bindValue(":id", $_POST['devlog_rm_id']);
		$smt->execute();

		$devlog_message = "Devlog wurde gel&ouml;scht!";
	}



$uebersicht = getContentFromTemplate("uebersicht", "html");
$userinfo = getUserinformation($db);
$changelogPosts = getChangelogPosts($db);
$devlogPosts = getDevlogPosts($db);
$newsPosts = getNewsPosts($db);

if(isset($_GET['sb'])){
	if($_GET['sb'] == "uebersicht"){
		$content = $uebersicht;
	}elseif (($_GET['sb'] == "nutzer") && isAdmin($db, $_SESSION['uid'])) {
		$content = "
		<h2>Nutzer Verwaltung</h2>
			<form method='POST'>
				<h3>Berechtigungs Level &Auml;ndern</h3>
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
			</form>";



	}elseif (($_GET['sb'] == "changelog") && isModerator($db, $_SESSION['uid'])) {
		$content = "<h2>Changelog Verwaltung</h2>
					<div>
					<h3>Changelog hinzuf&uuml;gen</h3>
						<form method='POST'>
							<label>&Uuml;berschrift:</label><br>
							<input type='text' name='changelog_head' required>
							<br><label>Changelog</label><br>
							<textarea id='text' name='changelog_body' cols='100' rows='10' required></textarea><br>
							<input type='submit' value='Erstellen'/>
						</form>
					</div>
					<hr/>
					<div>
					<h3>Changelog l&ouml;schen</h3>
						<form method='POST'>
							<label>Changelog Ausw&auml;hlen</label>
							<br>
							<select name='changelog_rm_id'>";
							while($dbsatz = $changelogPosts->fetchArray()){
								$content .= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].", ".$dbsatz['header']."</option>";
							}
		$content .= "		</select>
							<br><br>
							<input type='submit' value='L&ouml;schen'/>
						</form>
					</div>

					<div class='information'>  ".$changelog_message."  </div>";



	}elseif (($_GET['sb'] == "news") && isModerator($db, $_SESSION['uid'])) {
		$content = "<h2>Neuigkeiten Verwaltung</h2>
					<div>
					<h3>Neuigkeit hinzuf&uuml;gen</h3>
						<form method='POST'>
							<label>&Uuml;berschrift</label><br>
							<input type='text' name='news_head' required>
							<br><label>Neuigkeit</label><br>
							<textarea id='text' name='news_body' cols='100' rows='10' required></textarea><br>
							<input type='submit' value='Erstellen'/>
						</form>
					</div>
					<hr/>
					<div>
					<h3>Neuigkeit l&ouml;schen</h3>
						<form method='POST'>
							<label>Neuigkeit Ausw&auml;hlen</label>
							<br>
							<select name='news_rm_id'>";
							while($dbsatz = $newsPosts->fetchArray()){
								$content .= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].", ".$dbsatz['header']."</option>";
							}
		$content .= "		</select>
							<br><br>
							<input type='submit' value='L&ouml;schen'/>
						</form>
					</div>

					<div class='information'>  ".$news_message."  </div>";


	}elseif(($_GET['sb'] == "devlog") && isDeveloper($db, $_SESSION['uid'])) {
		$content = "<h2>Devlog Verwaltung</h2>
					<div>
					<h3>Devlog hinzuf&uuml;gen</h3>
						<form method='POST'>
							<label>&Uuml;berschrift:</label><br>
							<input type='text' name='devlog_head' required>
							<br><label>Devlog</label><br>
							<textarea id='text' name='devlog_body' cols='100' rows='10' required></textarea><br>
							<input type='submit' value='Erstellen'/>
						</form>
					</div>
					<hr/>
					<div>
					<h3>Devlog l&ouml;schen</h3>
						<form method='POST'>
							<label>Devlog Ausw&auml;hlen</label>
							<br>
							<select name='devlog_rm_id'>";
							while($dbsatz = $devlogPosts->fetchArray()){
								$content .= "<option value='".$dbsatz['id']."'>".$dbsatz['id'].", ".$dbsatz['header']."</option>";
							}
		$content .= "		</select>
							<br><br>
							<input type='submit' value='L&ouml;schen'/>
						</form>
					</div>

					<div class='information'>  ".$devlog_message."  </div>";
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
		if(isModerator($db, $_SESSION['uid'])){
?>
<div class='container-admin'>
	<div class="sidebar">
		<ul>
			<li><a href="?sb=uebersicht">&Uuml;bersicht</a></li>
			<?php
			if(isAdmin($db, $_SESSION['uid'])){
				echo '<li><a href="?sb=nutzer">Nutzer Verwaltung</a></li>';
			}
			?>
			<li><a href="?sb=news">Neuigkeiten Verwaltung</a></li>
			<li><a href="?sb=changelog">Changelog Verwaltung</a></li>
			<?php
			if(isDeveloper($db, $_SESSION['uid'])){
				echo '<li><a href="?sb=devlog">Devlog Verwaltung</a></li>';
			}
			?>
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