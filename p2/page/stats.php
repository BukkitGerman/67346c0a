<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';
include 'ts3.php';

?>
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



	<script type="text/javascript" src="js/stats.js"></script>
</div>









<?php
	if(!isset($_GET['data']))
	echo getFooter();
?>
</body>
</html>