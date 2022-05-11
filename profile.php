<?php

if(!isset($subaction)){
	$subaction = NULL;
}
if (!isset($_SESSION['login'])){
	echo 'Please log in to view members.';
}
else {
	if (!isset($sid)){
	$sid = $_SESSION['u_id'];

	}
	$sql = "SELECT f_id FROM forum WHERE f_auth = '".$sid."' AND f_parent = 0";
	if($qposts = mysqli_query($link, $sql)){}
	$rposts = mysqli_num_rows($qposts);
	$sql = "SELECT f_id FROM forum WHERE f_auth = '".$sid."' AND f_parent != 0";
	if($qreply = mysqli_query($link, $sql)){}
	$qreply = mysqli_num_rows($qreply);
	$sql = "SELECT pd_id FROM poll_data WHERE pd_userid = '".$sid."'";
	if($qpoll = mysqli_query($link, $sql)){}
	$rpoll = mysqli_num_rows($qpoll);
	$sql = "SELECT * FROM users WHERE u_id = ".$sid."";
	if($result = mysqli_query($link, $sql)){}
	$row = mysqli_fetch_array($result);

	$sql = "SELECT r_name, r_value FROM ranks WHERE r_value = ".$row['u_rank']."";
	$rank_thing = mysqli_query($link, $sql);
	$rank_query = mysqli_fetch_array($rank_thing);


	

	// remove the &gay and put back the '
	$ffname = str_replace("&gay", "'", $row['u_fname']);
	$flname = str_replace("&gay", "'", $row['u_lname']);
	$fbio = str_replace("&gay", "'", $row['u_bio']);
	$fsig = str_replace("&gay", "'", $row['u_sig']);
	$fpc = str_replace("&gay", "'", $row['u_pc']);
	$kingdom = str_replace("&gay", "'", $row['u_kingdom']);

		?>
		<div class="container">
			<div class="card">
		<?php 
			if ($row['u_avatar'] != NULL){
				echo '<img class="avatar" vspace="12" src="img/avatars/'.$row['u_avatar'].'">';  
			}
			else {
				echo '<img class="avatar" vspace="12" src="img/avatars/nopic.jpg"> ';
			}	
			echo '<div class="av">Hellotherefour';
			if ($_SESSION['u_id'] != $sid){
				echo '<a href="index.php?mainaction=msg&sid='.$sid.'"><button class="slider" id="msg">MSG</button></a>';
				echo '<a href="index.php?mainaction=qlog&sid='.$sid.'"><button class="slider" id="goal">Goal</button></a>';
			}
			else {
				echo '<a href="index.php?mainaction=lewt&lewtaction=lewtchest"><img src="img/chest.png" alt="Lewt Chest!" id="chest"></a>';
				echo '<a href="index.php?mainaction=lewt&lewtaction=pick"><button class="slider" id="pick" alt="hello">Looting</button></a>';
			}
				echo '</div><div class="content">';
				

	echo '<div class="accordion">'; // contact info
	echo '<button type="button" class="down1">Profile</button>';
	echo '<div class="accordion__content">';
	if ($_SESSION['u_id'] == $row['u_id']){ // if your veiwing ur own profile
						echo '<h3>Your Profile: </h3>';
					}
					else { // else show title to viewer
						echo '<h3>'.ucfirst($row['u_fname']).'</h3>';
					}
					// need to move this to the update area
					if ($update == 'success'){
						echo '<tr><td align="center">Your password is updated. Thank You.</td>';
					}

					if ($_SESSION['u_id'] == $row['u_id'] && ($sub_action != 'edit' && $sub_action != 'pass')){
						echo '<button id="update-button">Update</button><button id="update-button-2">Change Password</button>';
						// check so see if they have leveled up ----------------------
						$rank = $row['u_rank'];
						$exp = $row['u_exp'];
						echo rankcheck($rank,$exp,$sid);
					}

	echo '<table><tr><td width="150">User Name:</td><td width="150">'. ucfirst($row['u_name']).'</td></tr>';
	echo '<tr><td>Name:</td><td>';  echo ucfirst($row['u_fname']).' '.ucfirst($row['u_lname']).'</td></tr>';
	echo '<tr><td>Birthdate:</td><td>'.date( "M jS", strtotime($row['u_bdate'])).'</td></tr>';
	echo '<tr><td>Kingdom:</td><td>'. ucfirst($kingdom).'</td></tr>';
//<a class="blue" href="http://www.youtube.com/user/'.$row['u_utube'].'" target="_blank"></a>
	echo '<tr><td>Rank:</td><td>'.$rank_query['r_name'].'</td></tr>';
	echo '<tr><td>Exp:</td><td>'.$row['u_exp'].'</td></tr>';
	echo '<tr><td>Gold:</td><td>'.$row['u_coin'].'</td></tr>';
	echo '</table>';
	echo '</div>';// end contact content
	echo '</div>';// end accordion

	echo '<div class="accordion">'; // contact info
	echo '<button type="button" class="down1">Contact Info</button>';
	echo '<div class="accordion__content">';
	echo '<table><tr><td>Email:</td><td>'.($row['u_privacy'] == 1 ? ($_SESSION['u_id'] != $row['u_id'] ? 'n/a' : $row['u_email']) : $row['u_email'] ).'</td></tr>';
	echo '<tr><td>SteamID:</td><td>'.$row['u_steam'].'</td></tr><tr><tr><td>BattleTag:</td><td>'.$row['u_btag'].'</td></tr><tr><td>Facebook:</td><td>'.$row['u_fbook'].'</td></tr>';
	echo '<tr><td>You Tube Chan:</td><td>'.($row['u_utube'] != NULL ? ''.$row['u_utube'].'' : 'Not Avail').'</td></tr></table>';
	echo '</div>';// end contact content
	echo '</div>';// end accordion

	echo '<div class="accordion">';
	echo '<button type="button" class="down1">Deets</button>';
	echo '<div class="accordion__content">';	
	echo '<h3>Bio:</h3>'.nl2br(htmlspecialchars($fbio));
	echo '<h3>PC Specs:</h3>'.nl2br($fpc).'';
	echo '</div>';// end forum content
	echo '</div>';// end accordion

	echo '<div class="accordion">';
	echo '<button type="button" class="down1">Forum Stats</button>';
	echo '<div class="accordion__content">';	
	echo '<table><tr><td>Replies: </td><td>'.$qreply.'</td></tr>';
	echo '<tr><td>Posts:</td><td>'.$rposts.'</td></tr>';
	echo '<tr><td>Poll Votes:</td><td>'.$rpoll.'</td></tr></table>';
	echo '</div>';// end forum content
	echo '</div>';// end accordion

	echo '<div class="accordion">';
	echo '<button type="button" class="down1">Game Stats</button>';
	echo '<div class="accordion__content">';	
	echo '<h3>Currently Playing:</h3>';	
	$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$sid."' && gu_status = 1 && g_type = 0 ORDER BY g_name ASC"; 
	if($result = mysqli_query($link, $sql)){}
	
	$tgames = mysqli_num_rows($result);
	if ($tgames == 0){
		echo 'N/A<br>';
	}
	else {
		for($i = 0; $i < $tgames; $i++) {
			 $grow = mysqli_fetch_array($result); //get a row from our result set
			 echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row['u_id'] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
		}
	}
	echo '<h3>Casually Playing:</h3>';	
	$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$sid."' && gu_status = 2 && g_type = 0 ORDER BY g_name ASC"; 
	if($result = mysqli_query($link, $sql)){}

	$tgames = mysqli_num_rows($result);
	if ($tgames == 0){
		echo 'N/A<br>';
	}
	else {
		for($i = 0; $i < $tgames; $i++) {
			 $grow = mysqli_fetch_array($result); //get a row from our result set
			 echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row['u_id'] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
		}
	}
	echo '<h3>Played:</h3>';	
	$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$sid."' && gu_status = 0 && g_type = 0 ORDER BY g_name ASC"; 
	if($result = mysqli_query($link, $sql)){}
	$tgames = mysqli_num_rows($result);
	if ($tgames == 0){
		echo 'N/A<br>';
	}
	else {
		for($i = 0; $i < $tgames; $i++) {
			 $grow = mysqli_fetch_array($result); //get a row from our result set
			 echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row['u_id'] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
		}
	}
	echo '</div>';// end forum content
	echo '</div>';// end accordion

	echo '</div>';// end content i think

	// ------------------- char card ----------------------------------------------------
	echo '<div class="game"><img class="silo" src="'.($row['u_sex'] == 1 ? 'img/warsilo.png' : ($row['u_sex'] == 2 ? 'img/femalesilo.png' : 'img/golem.png')).'" alt="">
	<div class="item-slot1">SW</div><div class="item-slot2">SH</div><div class="item-slot3">H</div></div>
	</div></div>';// end game and card and container
	// ------------------- update form in the modal -------------------------------------
	echo '
	<dialog class="modal" id="modal">
	  <div id="update-area">
		<h3>Update Your Deets</h3>
			<form enctype="multipart/form-data" action="process.php" method="post" name="users">
            <input type="hidden" name="action" value="user">
            <input type="Hidden" name="MAX_FILE_SIZE" value="5000000">
            <input type="hidden" name="sub_action" value="update">
            <input type="hidden" name="u_id" value="'.$_SESSION['u_id'].'">
            <input type="Hidden" name="loc" value="profile">';
            echo 'First Name: <input type="Text" name="u_fname" value="'.$row['u_fname'].'" border="0" vspace="0">';
            echo ' Last Name: <input type="Text" name="u_lname" value="'.$row['u_lname'].'" border="0" vspace="0" accept="text/plain"><br>';
            echo 'Birth Date: Month <select name="month"> ';
            $phpdate = strtotime( $row['u_bdate'] );
            $bm = date( 'm', $phpdate);
            	for ($m = 1; $m <= 12; $m++){
                	echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
                }
            echo '</select> Day <select name="day">';
            $bd = date( 'd', $phpdate);
                for ($d = 1; $d <= 31; $d++){
                    echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
                }
            echo '</select> Year <select name="year">';
            $by = date( 'Y', $phpdate);
                for ($y = 2013; $y >= 1913; $y--){
                    echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
                }
            echo '</select><br>'; 
			echo 'Sex:<input type="Radio" name="u_sex" value="1" '.($row[7] == 1 ? 'checked' : '').'>Gent  <input type="Radio" name="u_sex" value="2" '.($row[7] == 2 ? 'checked' : '').'>
			Lady  <input type="Radio" name="u_sex" value="3" '.($row[7] == 3 ? 'checked' : '').($row[7] == 0 ? 'checked' : '').'>Rock Golem <i>(i dont have sex organs)</i><br>';
            echo 'Email: <input type="Text" name="u_email" value="'.$row['u_email'].'" border="0" vspace="0" accept="text/plain"> ';
			echo 'Keep my email private: Yes <input type="Radio" name="u_privacy" value="1" '.($row['u_privacy'] == 1 ? 'checked' : '').'> No <input type="Radio" name="u_privacy" value="0" '.($row[8] == 0 ? 'checked' : '').'><br>';
			echo 'Kingdom: <input type="Text" name="u_kingdom" value="'.$row['u_kingdom'].'" border="0" vspace="0" accept="text/plain"> <br>';
			echo 'SteamID: <input type="Text" name="u_steam" value="'.$row['u_steam'].'" border="0" vspace="0" accept="text/plain"> ';
			echo 'BattleTag: <input type="Text" name="u_btag" value="'.$row['u_btag'].'" border="0" vspace="0" accept="text/plain"><br>';
			echo 'Facebook: <input type="Text" name="u_fbook" value="'.$row['u_fbook'].'" border="0" vspace="0" accept="text/plain"> ';
            echo 'Youtube: <input type="Text" name="u_utube" value="'.$row['u_utube'].'" border="0" vspace="0" accept="text/plain"><br>';  
			echo '<h3>Bio:<i>(Tell us a bit about yourself)</i></h3>';
            echo '<textarea name="u_bio" cols="80" rows="6">'.htmlspecialchars($fbio).'</textarea>';
            echo '<h3>Forum Signature:</h3>';
            echo '<textarea name="u_sig" cols="80" rows="6">'.htmlspecialchars($fsig).'</textarea>';
			echo '<h3>PC Specs: </h3><textarea name="u_pc" cols="80" rows="6">'.htmlspecialchars($fpc).'</textarea>';	
            echo  '<h3>Upload Avatar:</h3><input name="userfile" type="File"><br>
            Name your avatar: <input name="i_name" type="TEXT" size="10" maxlength="75"><br>
            (Jpeg or Gif images only.  Dimensions need to be 128x128 and max size 1 mB.  If the image is larger it will be automatically resized and it will not look as good as if you did it yourself.)<br>
            <input type="submit" value="SAVE CHANGES"></form><button class="button close-button" id="close-button">Cancel</button>
	  </div>
	</dialog>';
	echo '
	<dialog class="modal" id="modal-2">
	<div id="pass-area"><h3>Change Password</h3>
	<form enctype="multipart/form-data" action="process.php" method="post" name="users" id="form">
	<input type="hidden" name="action" value="user">
	  <input type="hidden" name="sub_action" value="update">
	  <input type="hidden" name="update_pass" value="yes">
	  <input type="hidden" name="u_id" value="'.$row[0].'">
	  <input type="Hidden" name="loc" value="profile"><table><tr><td colspan="2" id="error">';
	  if ($error == 1){
		  echo 'Your old password is incorrect!';
	  }
	echo '</td></tr>
	<tr><td>Old Password: </td><td><input type="Password" name="old_pass" id="old_pass" accept="text/plain"></td></tr>
	<tr><td>New Password: </td><td><input type="Password" name="pass1" id="pass1" accept="text/plain"></td></tr>
	<tr><td>ReEnter Password:</td><td><input type="Password" name="pass2" id="pass2" accept="text/plain"></td></tr>
	<tr><td colspan="2"><input type="submit" value="UPDATE PASSWORD"></form></td></tr></table>
	</div>
	</dialog>';
	echo '<script src="profile.js"></script>';
}
?>