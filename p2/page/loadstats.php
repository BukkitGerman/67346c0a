<?php 
header('Content-Type: application/json');
include 'main.php';
$db = new SQLite3("../database/database.db");

	$arr = array();
	$userinfo = getUserinformation($db);
	$x = 0;
	while($dbsatz = $userinfo->fetchArray()){
		$arr[$x] = array("id" => $dbsatz['id'], "username" => $dbsatz['username'], "email" => $dbsatz['email']);
		$x++;
	}
	echo json_encode($arr);
?>
