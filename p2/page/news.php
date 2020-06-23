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
	<?php
		$posts = getNewsPosts($db);
		while ($dbsatz = $posts->fetchArray()) {
			$text .=" <div class='inner-item'>
						<div class='post'>
						<h3>".$dbsatz['header']."</h3>
						<div id='post_body'>
						".$dbsatz['neuigkeit']."
						</div>
						</div>
					</div>";
		}
		echo $text;
	?>
</div>






<?php
	echo getFooter();
?>
</body>
</html>