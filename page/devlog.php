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
<div class="content">
	<div class="outer-item">
		<div class="inner-item">
			Et est ut proident deserunt consequat sunt ad ex sit reprehenderit nostrud laboris do consequat in nulla in amet proident ullamco exercitation ut occaecat id adipisicing est.
		</div>
		<div class="inner-item">
			Non labore consequat excepteur elit id eiusmod nisi in ex labore officia voluptate pariatur dolore consequat qui laborum labore et et duis fugiat.
		</div>
	</div>
</div>
</body>
</html>