<?php
$db = new SQLite3("../database/database.db");

function showNavigation($aktive, $userid = false){
	if(isset($userid) && $userid != false){ //get user permission if userid isset & not false.

		$result = $db->prepare("SELECT permission FROM permissions WHERE uid = :uid");
		$result->bindValue(':uid', $userid);
		$result = $result->execute();
		$result = $result->fetchArray();
		$permission = $result['permission'];
	}

	//Show the Navigationbar

	echo "<nav>
			<ul>";

			if($aktive == "home"){
				echo "
					<li class='active'><a href='/''>Home</a></li>
        			<li><a href='/pages/changelog.php'>Changelog</a></li>
        			<li><a href='/pages/news.php'>News</a></li>
        			<li><a href='/pages/request.php'>Requests</a></li>
        			<li><a href='/pages/disscussion.php'>Disscussion</a></li>
        			";
        		if(isset($userid) && $userid != false){
        			if($permission >= 2){
        				echo "
        				<li><a href='admin.php'>Administration</a></li>
        				";
        			}

        			echo "
        			<li><a href='profil.php'>Profil</a></li>
        			";
				}

				if($userid == false){
        			echo "
        			<li style='float:right'><a href='login.php'>Login</a></li>
				";
				}elseif(isset($userid) && $userid != false){
					echo "
        			<li style='float:right'><a href='logout.php'>Logout</a></li>
				";
				}
		
			}elseif ($aktive == "changelog") {
				
			}elseif ($aktive == "news") {
				
			}elseif ($aktive == "request") {
				
			}elseif ($aktive == "disscussion") {
				
			}elseif ($aktive == "admin") {
				
			}elseif ($aktive == "profil") {
				
			}elseif ($aktive == "login") {
				
			}

	echo "	</ul>
		  </nav>";
}


function showSidebar(){

}

function showFooter(){


}


?>