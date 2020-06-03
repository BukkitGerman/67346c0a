<?php  
session_start();
$db = new SQLite3("../database/database.db");
include '../php/main.php';
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
<?php

$Showform = true;

if(isset($_GET['register'])){
	if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["passwort"]) && isset($_POST["passwort2"])){
		$e = false;
		$username = $_POST['username'];
		$email = $_POST['email'];
		$passwort = $_POST['passwort'];
		$passwort2 = $_POST['passwort2'];
	

		if(strlen($username) <= 3){
			echo "Bitte geben sie einen Usernamen ein der Mindestens 3 Zeichen lang ist!";
			$e = true;
		}

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "E-Mail nicht gültig, bitte geben sie eine G&uuml;ltige E-Mail ein!<br>";
			$e = true;
		}
		if(strlen($passwort) == 0){
			echo "Bitte geben sie ein Passwort ein!";
			$e = true;
		}

		if(strlen($passwort) <= 7){
			echo "Passwort ist zu kurz!";
			$e = true;
		}

		if($passwort != $passwort2){
			echo "Passw&ouml;rter stimmen nicht überein!";
			$e = true;
		}


		if(!$e){
			$result = $db->prepare("SELECT * FROM users WHERE email = :email");
			$result->bindValue(":email", $email);
			$result = $result->execute();
			$user = $result->fetchArray();

			if($user != false){
				echo "E-Mail Adresse ist vergeben!";
				$e = true;
			}

		}

		if(!$e){
			$result = $db->prepare("SELECT * FROM users WHERE username = :username");
			$result->bindValue(":username", $username);
			$result = $result->execute();
			$user = $result->fetchArray();

			if($user != false){
				echo "Username Adresse ist vergeben!";
				$e = true;
			}

		}

		if(!$e){
			$pw_hash = password_hash($passwort, PASSWORD_DEFAULT);

			$smt = $db->prepare("INSERT INTO users (username, email, passwort) VALUES (:username, :email, :passwort)");
			$smt->bindValue(':username', $username);
			$smt->bindValue(':email', $email, SQLITE3_TEXT);
			$smt->bindValue('passwort', $pw_hash);
			$smt->execute();

			$smt = $db->prepare("SELECT id FROM users WHERE username = :username");
			$smt->bindValue(':username', $username);
			$result = $smt->execute();
			$user = $result->fetchArray();
			$uid = $user['id'];

			$smt = $db->prepare("INSERT INTO permissions (uid, permission, developer) VALUES (:uid, :perm, :dev)");
			$smt->bindValue(':uid', $uid);
			$smt->bindValue(':perm', 0);
			$smt->bindValue('dev', 0);
			$smt->execute();

			if($result){
				echo "Registrierung erfolgreich! <a href='login.php'>Zum Login</a>";
				$Showform = false;
			} else {
				echo "Es ist ein Fehler aufgetreten!";
			}
		}

	}
}



if($Showform){
?>
<div class="con">
 <div class="item" id="login">
<h1>Registrierung</h1><br>
<form action="?register=1" method="post">
E-Mail:<br>
<input type="text" size=40 maxlength="30" name="username" required placeholder="username"><br>

E-Mail:<br>
<input type="email" size=40 maxlength="250" name="email" required placeholder="example@example.de"><br>

Passwort:<br>
<input type="password" size="40" maxlength="250"name="passwort" required><br>

Passwort widerholen:<br>
<input type="password" size="40" maxlength="250"name="passwort2" required><br>
<br>
<input type="submit" name="Registrieren" value="Registrieren">
	
</form>
<?php
}
?>
</div>
</div>
</body>
</html>