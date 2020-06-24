<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';
include 'ts3.php';

if(isset($_GET['type']) && isset($_GET['usr']) && isset($_GET['token'])){
	if($_GET['type'] == 'email'){
		$smt = $db->prepare("SELECT verify_email FROM users WHERE id = :uid");
		$smt->bindValue(':uid', $_GET['usr']);
		$smt = $smt->execute();
		$smt = $smt->fetchArray();
		if($smt['verify_email'] == 0){
			$smt = $db->prepare("SELECT email_token FROM users WHERE id = :uid");
			$smt->bindValue(':uid', $_GET['usr']);
			$smt = $smt->execute();
			$smt = $smt->fetchArray();

			if(verifyEmail($db, $_GET['usr'], $_GET['token'])){
				$content = "<p>Du hast dich erfolgreich Verifiziert!</p>";
			}else{
				$content = "<p>Es ist ein Fehler aufgetreten!</p>";
			}
	}elseif($smt['verify_email'] == 1){
		$content = "<p>Bereits Verifiziert!</p>";
	}
	}elseif ($_GET['type'] == 'teamspeak') {
		//************************//
		//TODO: Add Functionality!//
		//************************//
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
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
<div class="content">
	<?php
		echo $content;
	?>
</div>
<?php
	echo getFooter();
?>
</body>
</html>