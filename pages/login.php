<?php  
session_start();
$db = new SQLite3("../database/database.db");
include '../php/main.php';

if(isset($_GET['login'])){
	$username = $_POST['username'];
	$passwort = $_POST['passwort'];


	$stmt = $db->prepare("SELECT passwort FROM users WHERE username = :username");
	$stmt->bindValue(':username', $username);
	$stmt = $stmt->execute();
	$user = $stmt->fetchArray();
	$userpw = $user["passwort"];


	if ($user !== false){
		if(password_verify($passwort, $userpw)){
			$_SESSION['userid'] = $user['id'];

			die('Login erfolgreich. Weiter zu <a href="profile.php?user='.$_SESSION["userid"].'">deinem Profil!</a>');

	    } else {
	        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
	    }
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
	<title></title>
</head>
<?php 
if(isset($_SESSION["uid"])){
	showNavigation("home", $_SESSION['uid']);
}else{
	showNavigation("home");
}
?>
<body>
<div class="con">
 	<div class="item" id="login">
 	<h1>Login</h1><br>
		<form action="?login=1" method="post">
		Username:<br>
		<input class="login" type="text" size="40" maxlength="250" name="username" required><br><br>
 
		Dein Passwort:<br>
		<input class="login" type="password" size="40"  maxlength="250" name="passwort" required><br>
 		<br>
		<input class="login" type="submit" value="Login">
		</form> 
		<hr/>
		<div>
		<p>Wenn du noch kein Account hast dann kannst du dich <a href="register.php">Hier Registrieren.</a></p>
		<br>
		<?php 
		if(isset($errorMessage)) {
    		echo $errorMessage;
		}
		?>
		</div>
	</div>
</div>
</body>
</html>