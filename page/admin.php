<?php  
session_start();
$db = new SQLite3("../database/database.db");
include 'main.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/nav.css">
	<link rel="stylesheet" href="css/style.css">
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
<div class="content-admin">
	<?php
	if(isset($_SESSION["uid"])){
		if(getPermissionLevel($db, $_SESSION["uid"]) >= 2){

		}else{
			$content = "<h1 id='denied'>Access denied!</h1>";
		}
	}
	?>
</div>
</body>
</html>