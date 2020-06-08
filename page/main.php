<?php




function getPermissionLevel($db, $usid = false){

	if($usid == false){
		return $db->query("SELECT * FROM permissions");
	}else{
		$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
		$result->bindValue(':usid', $usid);
		$result = $result->execute();
		$result = $result->fetchArray();
		$perm = $result['permission'];

		return $perm;
	}
}

function getChangelogPosts($db, $postID = false){
	if($postID == false){
		$result = $db->prepare("SELECT * FROM changelog");
		$result = $result->execute();
		return $result;
	}elseif($postID != false){
		$result = $db->prepare("SELECT * FROM changelog WHERE id = :id");
		$result->bindValue(':id', $postID);
		$result = $result->execute();
		return $result->fetchArray();
	}
}

function getDebugStatus($db, $usid){
		$result = $db->prepare("SELECT debug FROM dev_settings WHERE uid = :usid");
		$result->bindValue(':usid', $usid);
		$result = $result->execute();
		$result = $result->fetchArray();
		
		return $result['debug'];
}


function getUserinformation($db, $usid = false){

	if($usid == false){
		return $db->query("SELECT * FROM users");
	}else{
		$result = $db->prepare("SELECT * FROM users WHERE id = :usid");
		$result->bindValue(':usid', $usid);
		$result = $result->execute();
		$result = $result->fetchArray();
		
		return $result;
	}
}


function isUserDev($db, $usid){

	$result = $db->prepare("SELECT developer FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $usid);
	$result = $result->execute();
	$result = $result->fetchArray();
	$perm = $result['developer'];

	if($perm >= 1){
		return true;
	}else{
		return false;
	}
}

function getUsername($db, $usid){
	$result = $db->prepare("SELECT username FROM users WHERE id = :usid");
	$result->bindValue(':usid', $usid);
	$result = $result->execute();
	$result = $result->fetchArray();
	$usrname = $result['username'];

	return $usrname;
}


function showNavigation($db, $uid = false){

	$out = "<nav class='menu'>
	<div class='title'>
	<div><ol>
		<li class='menu-item'><a href='/'>Home</a></li>
		<li class='menu-item'><a href='news.php'>Neuigkeiten
			<ol class='sub-menu'>
				<li class='menu-item'><a href='changelog.php'>Changelog</a></li>
				<li class='menu-item'><a href='devlog.php'>Devlog</a></li>
			</ol>
		</li>
		<li id='title'><h1><a href='/'>Gamer4Life</a></h1></li>
		<li class='menu-item' id='antrag'><a href='requests.php'>Antr&auml;ge</a>
			<ol class='sub-menu'>
				<li class='menu-item'><a href='entban.php'>Entban Antrag</a></li>
				<li class='menu-item'><a href='channel.php'>Channel Antrag</a></li>
			</ol>
		</li>";
		if($uid != false){
			$permission = getPermissionLevel($db, $uid);
			if($permission >= 2){
				$out .= "<li class='menu-item'><a href='profil.php'>Profil</a>
							<ol class='sub-menu'>
								<li class='menu-item' id='welcome'>Willkommen, ". getUsername($db, $uid) ."</li>
								<li class='menu-item'><a href='admin.php'>Administration</a></li>
								<li class='menu-item'><a href='logout.php'>Logout</a></li>
							</ol>
						</li>";
			}else{
				$out .= "<li class='menu-item'><a href='profil.php'>Profil</a>
							<ol class='sub-menu'>
								<li class='menu-item' id='welcome'>Willkommen, ". getUsername($db, $uid) ."</li>
								<li class='menu-item'><a href='logout.php'>Logout</a></li>
							</ol>
						</li>";
			}
		}else{
			$out .= "<li class='menu-item'><a href='login.php'>Login</a>
						<ol class='sub-menu'>
							<li class='menu-item'><a href='register.php'>Register</a></li>
						</ol>
					</li>";
		}

		$out .= "</ol></div></div></nav>";
		
		return $out;
}

function showFooter(){
	$output = "	";

	return $output;
}


?>