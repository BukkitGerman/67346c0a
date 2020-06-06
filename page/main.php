<?php




function getPermissionLevel($db, $usid){

		$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
		$result->bindValue(':usid', $usid);
		$result = $result->execute();
		$result = $result->fetchArray();
		$perm = $result['permission'];

		return $perm;
}



function showNavigation($db, $uid = false){

	$out = "<nav class='menu'>
	<ol>
		<li class='menu-item'><a href='/'>Home</a></li>
		<li class='menu-item'><a href='news.php'>Neuigkeiten
			<ol class='sub-menu'>
				<li class='menu-item'><a href='changelog.php'>Changelog</a></li>
				<li class='menu-item'><a href='devlog.php'>Devlog</a></li>
			</ol>
		</li>
		<li class='menu-item'><a href='requests.php'>Antr&auml;ge</a>
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
								<li class='menu-item'><a href='admin.php'>Administration</a></li>
								<li class='menu-item'><a href='logout.php'>Logout</a></li>
							</ol>
						</li>";
			}else{
				$out .= "<li class='menu-item'><a href='profil.php'>Profil</a>
							<ol class='sub-menu'>
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

		$out .= "</ol></nav>";
		
		return $out;
}


function showSidebar(){

}

function showFooter(){


}


?>