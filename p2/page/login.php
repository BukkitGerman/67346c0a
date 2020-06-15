<?php  
session_start();
$db = new SQLite3("../database/database.db");
include 'main.php';

if(isset($_GET['login'])){
	$username = $_POST['username'];
	$passwort = $_POST['passwort'];


	$stmt = $db->prepare("SELECT passwort, id FROM users WHERE username = :username");
	$stmt->bindValue(':username', $username);
	$stmt = $stmt->execute();
	$user = $stmt->fetchArray();
	$userpw = $user["passwort"];


	if ($user !== false){
		if(password_verify($passwort, $userpw)){
			$_SESSION['uid'] = $user['id'];

			die('Login erfolgreich. Weiter zu <a href="profile.php?user='.$_SESSION["uid"].'">deinem Profil!</a>');

	    } else {
	        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
	    }
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lexend+Deca&display=swap" rel="stylesheet">
	<title></title>
</head>
<?php 
if(isset($_SESSION['uid']))
{
	echo getNavigationbar($db, $_SESSION['uid']);
}else{
 	echo getNavigationbar($db);
}
?>
<body>
<div class="content-login">
 	<div class="item" id="login">
 	<h1>Login</h1><br>
		<form action="?login=1" method="post">
		<label>Username</label><br>
		<input class="login" type="text" size="40" maxlength="250" name="username" required><br><br>
 
		<label>Passwort</label><br>
		<input class="login" type="password" size="40"  maxlength="250" name="passwort" required><br>
 		<br>
		<input class="login" type="submit" value="Login">
		</form> 
		<br>
		<hr/>
		<div>
		<p>Wenn du noch kein Account hast dann<br> kannst du dich <a href="register.php">Hier Registrieren.</a></p>
		<br>
		<?php 
		if(isset($errorMessage)) {
    		echo $errorMessage;
		}
		?>
		</div>
	</div>
</div>
<?php
	echo getFooter();
?>
</body>
</html>