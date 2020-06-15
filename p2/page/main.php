<?php

function getPermission($db, $userid)
{

}

function isAdmin($db, $userid)
{
	
}

function isModerator($db, $userid)
{
	
}

function isSupporter($db, $userid)
{
	
}

function getUsername($db, $uid)
{
	$result = $db->prepare("SELECT username FROM users WHERE id = :usid");
	$result->bindValue(':usid', $uid);
	$result = $result->execute();
	$result = $result->fetchArray();
	$usrname = $result['username'];

	return $usrname;
}

function getNavigationbar($db, $uid = false)
{
	$result = "<header id='particles-js'>
	<script type='text/javascript' src='js/particles.js'></script>
	<script type='text/javascript' src='js/app.js'></script>
	<nav id='normal'>
	<ul>
		<li id='titelli'><h1 id='titel'><a href='/'>Gamer4life</a></h1></li>
		<li><a href='/'>Home</a></li>
		<li><a href='news.php'>Neuigkeiten</a>
			<ul>
				<li><a href='changelog.php'>Changelog</a></li>
				<li><a href='devlog.php'>Devlog</a></li>
			</ul>
		</li>
		<li id='antrag'><a href='requests.php'>Antr&auml;ge</a>
			<ul>
				<li><a href='entban.php'>Entban Antrag</a></li>
				<li><a href='channel.php'>Channel Antrag</a></li>
			</ul>
		</li>";
		if($uid != false){
			$permission = getPermission($db, $uid);
			if($permission >= 5){
				$result .= "<li><a href='profil.php'>Profil</a>
							<ul>
								<li id='welcome'>Willkommen, ". getUsername($db, $uid) ."</li>
								<li><a href='admin.php'>Administration</a></li>
								<li><a href='logout.php'>Logout</a></li>
							</ul>
						</li>";
			}else{
				$result .= "<li><a href='profil.php'>Profil</a>
							<ul>
								<li id='welcome'>Willkommen, ". getUsername($db, $uid) ."</li>
								<li><a href='logout.php'>Logout</a></li>
							</ul>
						</li>";
			}
		}else{
			$result .= "<li><a href='login.php'>Login</a>
						<ul>
							<li><a href='register.php'>Register</a></li>
						</ul>
					</li>";
		}

		$result .= "</ul></nav></header>";

	return $result;
}

function getFooter(){
	$result = "
	<footer>
	<div class='footer-item'>
		<ul>
			<li class='footer'><a href='impressum.php'>Impressum</a></li>
				<li class='footer copryright'><a>Copryright © 2020</a>
					<ul>
						<li>Copryright © 2020 Gamer4life. All right reserved. Developed by BukkitGerman</li>
					</ul>

				</li>
			<li class='footer'><a href='ts3server://gamer4life.net'>Teamspeak</a></li>
		</ul>
	</div>
	</footer>";

	return $result;
}

function isDebugAktive($db, $userid)
{

}

?>