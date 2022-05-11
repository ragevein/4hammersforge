<?php 
session_name('4hammers');
session_start();
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
$action = 'nothing';

require('functions.php');
$ip = getenv('REMOTE_ADDR');

if (!isset($_SESSION['login'])){
	if ($action != "process" && $action != "logout"){
		if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
			$sql = "select * from users where u_name = '".$_COOKIE['cookname']."' and u_pass = '".$_COOKIE['cookpass']."'";
			
			//$result = mysqli_query($query) or die (mysqli_error()."wtf");
			if($result = mysqli_query($link, $sql)){
			  if (mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_array($result);
     	 		$_SESSION['login'] = $row['u_name'];;
      			$_SESSION['u_pass'] = $row['u_pass'];
	  			$_SESSION['sec'] = $row['u_sec'];
	  			$_SESSION['u_id'] = $row['u_id'];
				$_SESSION['dark'] = $row['u_dark'];
				$_SESSION['kingdom'] = $row['u_kingdom'];
				$_SESSION['guest'] = 0;
				if (!isset($_SESSION['old_date'])){
					$_SESSION['old_date'] = $row['u_time'];
				}
				$_SESSION['stay'] = $row['u_logged'];
				$_SESSION['cookie'] = 'logged';
			  }
			}
   		}
		   /*
		else {
		$_SESSION['guest'] = $ip;
		$sql = "SELECT * FROM guest WHERE g_ip = '".rtrim($ip)."'";
		$result = mysqli_query($link, $sql);
		//$result = mysqli_query($query) or die (mysqli_error(). 'Guest query failed.');
		$hits = mysqli_fetch_array($result);
		$nhits = $hits['g_hits'] + 1;
		$numrows = mysqli_num_rows($result);
			if ($numrows > 0){
				$sql = "UPDATE guest SET g_extra = ".date('s').", g_hits = ".$nhits." WHERE g_ip = '".rtrim($ip)."'";
				if($result = mysqli_query($link, $sql)){
					
				}
				else{
				echo 'update query failed';
					
				}
				//$result = mysqli_query($query) or die (mysqli_error(). 'Guest update failed.');
			}
			else {
				$sql = "INSERT INTO guest (g_ip) values ('".$ip."')";
				//$result = mysqli_query($query) or die (mysqli_error(). 'Guest update failed.');
				if($result = mysqli_query($link, $sql)){
					
				}
				else{
				echo 'insert query failed - '.$ip.$sql;
					
				}
			}
		}
		*/
	}
}

if ($_SESSION['stay'] == 1 && $action != 'logout'){
	setcookie("cookname", $_SESSION['login'], time()+60*60*24*100);
    setcookie("cookpass", $_SESSION['u_pass'], time()+60*60*24*100);
	$_SESSION['stay'] = 0;
}

if ($_POST['action'] == "logout"){
	unset($_SESSION['login']);
	unset($_SESSION['sec']);
	unset($_SESSION['u_id']);
	unset($_SESSION['old_date']);
	unset($_SESSION['stay']);
	unset($_SESSION['cookie']);
	unset($_SESSION['dark']);
	unset($_SESSION['guest']);
	if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
   		setcookie("cookname", "", time()-60*60*24*100);
   		setcookie("cookpass", "", time()-60*60*24*100);
	}
}
$url = 'https://www.4hammersforge.com/index.php';

// ok this is my login section

if (isset($_SESSION['login'])){
	$action = "logged";
}

if ($action == "process"){
	process($u_name, $u_pass);
}

/*
if ($_SERVER['SERVER_PORT']!=443)
{
$url = "https://". $_SERVER['SERVER_NAME']. ":443" .$_SERVER['REQUEST_URI'];
header("Location: $url");
}
*/


require('querys.php');

extract($_REQUEST);
require('header.php'); 
$PHP_SELF = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"];
global $PHP_SELF;

if(isset($mainaction)){
$PHP_SELF .= "?mainaction=".$mainaction;
}
	
	switch ($mainaction){
		case "error":
			if ($id == 1){
				echo 'Sorry, you are not authroized to do that.';
			}
			else {
			echo 'Sorry, you have submitted 2 posts in under 1 min. <br> This looks like suspicious pls 
					give your fingers and yourself a min to calm down.';
			}
			break;
		case "login":
			require('login.php');
			break;
		case "admin":
			require('admin.php');
			break;
		case "qlog":
			require('qlog.php');
			break;	
		case "status":
			require('status.php');
			break;
		case "streams":
			require('streams.php');
			break;
		case "calendar":
			require('calendar.php');
			break;
		case "minecraft":
			require('minecraft.php');
			break;
		case "mcmap":
			require('mcmap.php');
			break;
		case "profile";
			require('profile.php');
			break;
		case "test";
			require('test.php');
			break;
		case "forum":
			require('forum.php');
			break;
		case "thread":
			require('threads.php');
			break;
		case "vthread":
			require('thread.php');
			break;
		case "post":
			require('form2.php');
			break;
		case "msg":
			require('msg.php');
			break;
		case "checkin":
			require('checkin.php');
			break;
		case "addnews":
			require('pnews.php');
			break;
		case "polls":
			require('polls.php');
			break;
		case "poll":
			require('poll.php');
			break;
		case "motd":
			require('motd.php');
			break;
		case "memlist":
			require('memlist.php');
			break;
		case "signup":
			require('signup.php');
			break;
		case "del":
			require('querys.php');
			require('admin/delete.php');
			break;
		case "verify":
			require('verify.php');
			break;
		case "welcome";
			require('welcome.php');
			break;
		case "event";
			require('event.php');
			break;
		case "forgot";
			require('forgot.php');
			break;
		case "reset":
			require('reset.php');
			break;
		case "story":
			require('story.php');
			break;
		case "game":
			require('game.php');
			break;
		case "gamelist":
			require('gamelist.php');
			break;
		case "lewt":
			require('lewt.php');
			break;
		case "playground":
			require('playground.php');
			break;
		case "blockhop":
			require('blockhop.php');
			break;
		case "tchest":
			require('tchest.php');
			break;
		case "rules":
			require('qlog_rules.php');
			break;
		default:
			require('news.php');
			$area = 1;
			break;
	}

session_write_close();
require('footer.php');

?>