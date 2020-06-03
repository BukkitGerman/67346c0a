<?php  
session_start();
$db = new SQLite3("../database/database.db");
include '../php/main.php';
?>
<!DOCTYPE html>
<html>
<head>
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

</body>
</html>