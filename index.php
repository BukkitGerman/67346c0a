<?php  
session_start();
$db = new SQLite3("/database/database.db");
include '/php/main.php';

if(isset($_SESSION["uid"])){
	showNavigation("home", $_SESSION['uid']);
}else{
	showNavigation("home");
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="../css/nav.css">
	<title></title>
</head>

<body>
<p>test</p>
</body>
</html>