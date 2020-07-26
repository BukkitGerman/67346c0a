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
				<li><a href='?user=".$_SESSION['uid']."&sb=profil'>Profil</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=settings'>Einstellungen</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test3'>Test3</a></li>
				<li><a href='?user=".$_SESSION['uid']."&sb=Test4'>Test4</a></li>
			</ul>
		</div>";

	$profil_normal = "
			 	<div class='header-profil'>
				 	<div class='background-profil'>
					 		<div class='picture-profil rund'>
				 				<img class='rund rund-img' src='img/profil/test.png'/>
				 			</div>
				 	</div>
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
		


			if(isset($_GET['sb'])){
				if($_GET['sb'] == "profil"){
					$content = $profil_normal;
				}elseif($_GET['sb'] == "settings"){
					$content = "Test";
				}
			}else{
				$content = $profil_normal;
			}
		}else{
			$content = $profil_normal;
		}
	}

	


	
	?>


	<div class="content-profil">
		<div class='inner-profil'>
		 <?php echo $content; ?>
		</div>
	</div>
</div>





<?php
	echo getFooter();
?>
</body>
</html>