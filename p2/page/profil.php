<?php
session_start();
$db = new SQLite3("../database/database.db");

include 'main.php';
include 'ts3.php';
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/profil.css">
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
<div class="container-profil">
	<?php  

	$sidebar = "
		<div class='sidebar'>
			<ul>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test1'>Test1</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test2'>Test2</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test3'>Test3</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test4'>Test4</a></li>
			</ul>
		</div>";
	
	if(isset($_GET['user'])){
		if($_GET['user'] == $_SESSION['uid']){
			if(isset($_GET['preview'])){
				if($_GET['preview'] != "true"){
					echo $sidebar;
				}
			}else{
				echo $sidebar;
			}
		}
	}
	?>
	<div class="content-profil">
		
	</div>
</div>





<?php
	echo getFooter();
?>
</body>
</html>