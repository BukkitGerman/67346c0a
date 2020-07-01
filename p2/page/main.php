<?php

require_once("../libraries/TeamSpeak3/TeamSpeak3.php");

function getPermission($db, $userid)
{
	$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	return $result['permission'];
}

function getDeveloperStatus($db, $userid)
{
	$result = $db->prepare("SELECT developer FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	return $result['developer'];
}

function isDeveloper($db, $userid)
{
	$result = $db->prepare("SELECT developer FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	if($result['developer'] >= 1){
		return true;
	}else{
		return false;
	}
}

function isAdmin($db, $userid)
{
	$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	if($result['permission'] >= 4){
		return true;
	}else{
		return false;
	}
}

function isModerator($db, $userid)
{
	$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	if($result['permission'] >= 3){
		return true;
	}else{
		return false;
	}
}

function isSupporter($db, $userid)
{
	$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	if($result['permission'] >= 2){
		return true;
	}else{
		return false;
	}
}

function getUsername($db, $userid)
{
	$result = $db->prepare("SELECT username FROM users WHERE id = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	$usrname = $result['username'];

	return $usrname;
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
			if(isAdmin($db, $uid)){
				$result .= "<li><a href='profil.php?user=".$_SESSION['uid']."'>Profil</a>
							<ul>
								<li id='welcome'>Willkommen, ". getUsername($db, $uid) ."</li>
								<li><a href='admin.php'>Administration</a></li>
								";
					if(isDeveloper($db, $uid)){
					 $result .= "<li><a href='stats.php'>Statistiken</a></li>";
					}


				$result .="		<li><a href='logout.php'>Logout</a></li>
							</ul>
						</li>";
			}else{
				$result .= "<li><a href='profil.php?user=".$_SESSION['uid']."'>Profil</a>
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

function isDebugActive($db, $userid)
{
	$result = $db->prepare("SELECT debug FROM dev_settings WHERE uid = :usid");
	$result->bindValue(':usid', $userid);
	$result = $result->execute();
	$result = $result->fetchArray();
	if($result['debug'] >= 1){
		return true;
	}else{
		return false;
	}
}

function getDatasetFromTable($db, $table ,$id = false){
	if($post_id == false){
		$result = $db->prepare("SELECT * FROM :table ORDER BY DESC");
		$result->bindValue(':table', $table);
		$result = $result->execute();
		$result = $result->fetchArray();

		return $result;
	}else{
		$result = $db->prepare("SELECT * FROM :table WHERE id = id ORDER BY DESC");
		$result->bindValue(':table', $table);
		$result->bindValue(':id', $id);
		$result = $result->execute();
		$result = $result->fetchArray();
		return $result;
	}
}

function getChangelogPosts($db, $postID = false){
	if($postID == false){
		$result = $db->prepare("SELECT * FROM changelog ORDER BY id DESC");
		$result = $result->execute();
		return $result;
	}elseif($postID != false){
		$result = $db->prepare("SELECT * FROM changelog WHERE id = :id");
		$result->bindValue(':id', $postID);
		$result = $result->execute();
		return $result->fetchArray();
	}
}


function getNewsPosts($db, $postID = false){
	if($postID == false){
		$result = $db->prepare("SELECT * FROM neuigkeiten ORDER BY id DESC");
		$result = $result->execute();
		return $result;
	}elseif($postID != false){
		$result = $db->prepare("SELECT * FROM neuigkeiten WHERE id = :id");
		$result->bindValue(':id', $postID);
		$result = $result->execute();
		return $result->fetchArray();
	}
}

function getDevlogPosts($db, $postID = false){
	if($postID == false){
		$result = $db->prepare("SELECT * FROM devlog ORDER BY id DESC");
		$result = $result->execute();
		return $result;
	}elseif($postID != false){
		$result = $db->prepare("SELECT * FROM devlog WHERE id = :id");
		$result->bindValue(':id', $postID);
		$result = $result->execute();
		return $result->fetchArray();
	}
}

function verifyEmail($db, $userid, $token){
	if($token != '######'){
		$smt = $db->prepare("SELECT email_token FROM users WHERE id = :uid");
		$smt->bindValue(':uid', $userid);
		$smt = $smt->execute();
		$smt = $smt->fetchArray();

		if($smt['email_token'] == $token){
			$smt = $db->prepare("UPDATE users SET verify_email = 1 WHERE id = :uid");
			$smt->bindValue(':uid', $userid);
			$smt->execute();

			return true;
		}else{
			return false;
		}
	}
}

function verifyTeamspeak($db, $userid, $token){
	if($token != '######'){
		$smt = $db->prepare("SELECT teamspeak_token FROM users WHERE id = :uid");
		$smt->bindValue(':uid', $userid);
		$smt = $smt->execute();
		$smt = $smt->fetchArray();

		if($smt['teamspeak_token'] == $token){
			$smt = $db->prepare("UPDATE users SET verify_teamspeak = 1 WHERE id = :uid");
			$smt->bindValue(':uid', $userid);
			$smt->execute();

			return true;
		}else{
			return false;
		}
	}
}


function generateToken(){
	$token = openssl_random_pseudo_bytes(12);
	$token = bin2hex($token);
	return $token;
}

function getContentFromTemplate($name, $endung){

	$url = "../templates/".$name.".".$endung;

	$handle = fopen($url, "r");
	if($handle){
		while (($buffer = fgets($handle, 4096)) !== false) {
			$result .= $buffer;
		}
	}

	if(!feof($handle)){
		$result = "Error!";
	}

	fclose($handle);

	return $result;
}



function filterText($text){
	$filter_list = array(
					"<abbr>", 
					"<address>",
					"<element>",
					"<area>", 
					"<article>", 
					"<aside>", 
					"<audio>", 
//					"<b>", 
					"<base>", 
					"<bdi>", 
					"<bdo>", 
					"<blockquote>",
					"<body>", 
					"<br>", 
					"<button>",
					"<canvas>",
					"<caption>",
					"<cite>", 
					"<code>", 
					"<col>", 
					"<colgroup>",
					"<data>", 
					"<datalist>",
					"<dd>", 
					"<del>", 
					"<details>", 
					"<del>", 
					"<details>",
					"<dfn>", 
					"<dialog>", 
					"<div>", 
					"<dl>", 
					"<dt>", 
					"<em>",
					"<embed>",
					"<တဠeldset>",
					"<တဠgcaption>",
					"<တဠgure>", 
					"<footer>", 
					"<form>", 
					"<h1>",
					"<h2>", 
					"<h3>", 
					"<h4>", 
					"<h5>",
					"<h6>",
					"<head>", 
					"<header>",
					"<hgroup>",
					"<hr>", 
					"<html>", 
//					"<i>", 
					"<iframe>", 
					"<img>", 
					"<input>", 
					"<ins>",
					"<kbd>", 
					"<label>", 
					"<legend>",
					"<label>", 
					"<legend>",
//					"<li>", 
					"<link>", 
					"<main>", 
					"<map>", 
					"<mark>", 
					"<menu>", 
					"<meta>",
					"<meter>", 
					"<nav>", 
					"<noscript>",
					"<object>", 
					"<ol>",
					"<optgroup>",
					"<option>", 
					"<output>",
//					"<p>", 
					"<param>", 
					"<pre>", 
					"<progress>",
					"<q>", 
					"<rp>", 
					"<rt>", 
					"<ruby>", 
					"<s>", 
					"<samp>", 
					"<script>", 
					"<section>",
					"<script>", 
					"<section>",
					"<select>", 
					"<small>", 
					"<source>",
					"<span>", 
					"<strong>", 
					"<style>", 
					"<sub>", 
					"<summary>",
					"<sup>", 
					"<table>", 
					"<tbody>", 
					"<td>", 
					"<textarea>",
					"<tfoot>", 
					"<th>", 
					"<thead>",
					"<time>",
					"<title>", 
					"<tr>", 
					"<track>",//						"<ul>",
					"<var>",
					"<video>", 
					"<wbr>", 


					"</abbr>", 
					"</address>",
					"</element>",
					"</area>", 
					"</article>", 
					"</aside>", 
					"</audio>", 
//					"</b>", 
					"</base>", 
					"</bdi>", 
					"</bdo>", 
					"</blockquote>",
					"</body>", 
					"</br>", 
					"</button>",
					"</canvas>",
					"</caption>",
					"</cite>", 
					"</code>", 
					"</col>", 
					"</colgroup>",
					"</data>", 
					"</datalist>",
					"</dd>", 
					"</del>", 
					"</details>", 
					"</del>", 
					"</details>",
					"</dfn>", 
					"</dialog>", 
					"</div>", 
					"</dl>", 
					"</dt>", 
					"</em>",
					"</embed>",
					"</တဠeldset>",
					"</တဠgcaption>",
					"</တဠgure>", 
					"</footer>", 
					"</form>", 
					"</h1>",
					"</h2>", 
					"</h3>", 
					"</h4>", 
					"</h5>",
					"</h6>",
					"</head>", 
					"</header>",
					"</hgroup>",
					"</hr>", 
					"</html>", 
//					"</i>", 
					"</iframe>", 
					"</img>", 
					"</input>", 
					"</ins>",
					"</kbd>", 
					"</label>", 
					"</legend>",
					"</label>", 
					"</legend>",
//					"</li>", 
					"</link>", 
					"</main>", 
					"</map>", 
					"</mark>", 
					"</menu>", 
					"</meta>",
					"</meter>", 
					"</nav>", 
					"</noscript>",
					"</object>", 
					"</ol>",
					"</optgroup>",
					"</option>", 
					"</output>",
//					"</p>", 
					"</param>", 
					"</pre>", 
					"</progress>",
					"</q>", 
					"</rp>", 
					"</rt>", 
					"</ruby>", 
					"</s>", 
					"</samp>", 
					"</script>", 
					"</section>",
					"</script>", 
					"</section>",
					"</select>", 
					"</small>", 
					"</source>",
					"</span>", 
					"</strong>", 
					"</style>", 
					"</sub>", 
					"</summary>",
					"</sup>", 
					"</table>", 
					"</tbody>", 
					"</td>", 
					"</textarea>",
					"</tfoot>", 
					"</th>", 
					"</thead>",
					"</time>",
					"</title>", 
					"</tr>", 
					"</track",
//					"</ul>",
					"</var>",
					"</video>", 
					"</wbr>",);


	$text = str_replace($filter_list, "####", $text);

	return $text;
}




?>