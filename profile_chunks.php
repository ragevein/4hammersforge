<div class="game-log">
  <?php 
  	if ($sub_action == 'addgame'){
		echo '<tr>
    <td colspan="2">You are adding a new game to the game data base.<br>';
	echo '<table>
	<tr><td><form action="process.php" method="post">
	<input type="Hidden" name="action" value="addgame">
	<input type="Hidden" name="sub" value="user">
	<input type="Hidden" name="sid" value="'.$sid.'">Game Title: </td><td><input type="text" name="name" size="25"></td></tr>
	<tr><td valign="TOP">Description: </td><td>
	 <textarea name="desc" cols="50" rows="5">
	 
	 </textarea></td></tr>
	<tr><td>Genre: </td><td>
		<select name="genre">
			<option value="MMORPG">MMORPG</option>
			<option value="RPG">RPG</option>
			<option value="MOBA">MOBA</option>
			<option value="FPS">FPS</option>
			<option value="RTS">RTS</option>
			<option value="SANDBOX">SANDBOX</option>
		</select></td></tr>
	<tr><td>Launch Date: </td><td>';
					echo 'M <select name="month" size="1">';
					$phpdate = strtotime( date('Y-m-d H:i:s') );
					//$bdate1 = date( 'm', $phpdate1);
					$bm = date( 'm', $phpdate);
					for ($m = 1; $m <= 12; $m++){
						echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
					}
					echo '</select>
					D	<select name="day" size="1">';
					$bd = date( 'd', $phpdate);
						for ($d = 1; $d <= 31; $d++){
  						echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
						}
					echo '</select>
					Y <select name="year" size="1">';
					$by = date( 'Y', $phpdate);
						for ($y = 2022; $y >= 1913; $y--){
  						echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';
	echo '
	</td></tr>
	<tr><td colspan="2">Core Game: <input type="Radio" name="type" value="0"> or Expansion:<input type="Radio" name="type" value="1"></td></tr>
	<tr><td>Developer: </td><td><input type="text" name="company" size="25"></td></tr>
	<tr><td>Platform: </td><td><select name="platform">
			<option value="PC">PC</option>
			<option value="Console">Console</option>
			<option value="Multi Platform">Multi Platform</option>
			<option value="Table Top">Table Top</option>
			<option value="Other">Other</option>
		</select></td></tr>
	<tr><td>Image: </td><td><input type="text" name="img" size="15"></td></tr>
	<tr><td><input type="submit"></td></tr>';
	echo '</table>';
	}
	else {
  ?>

<h3>Gamer Log:</h3>
	<?php 
		if ($_SESSION['u_id'] == $row[0] && $sub_action != 'uaddgame'){
			if ($sub_action != 'editugame') {
			echo '<a href="index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'&sub_action=uaddgame">ADD</a><br>';
			}
		}
		if ($sub_action == 'editugame'){
			$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE user_games.gu_id = '".$_SESSION['u_id']."'";
			if($eresult = mysqli_query($link, $sql)){}
			//$eresult = mysqli_query($query);
			$erow = mysqli_fetch_array($eresult);
			$enumrows = mysqli_num_rows($ersult);
			echo 'Editing <br>
			<form action="process.php" method="post">'.$erow['g_name'].'
			<br>Username:<br><input type="text" name="username" maxlength="75" size="15" value="'.$erow['gu_user_name'].'"><br>
			Server:<br><input type="Text" name="server" size="15" maxlenght="50" value="'.$erow['gu_server'].'"><br>
			Faction:<br><input type="Text" name="faction" size="15" maxlenght="50" value="'.$erow['gu_faction'].'"><br>Status:
			<select name="gu_status">
				<option value="0" '.($erow['gu_status'] == 0 ? 'selected' : '').'>Not currently Playing</option>
				<option value="1" '.($erow['gu_status'] == 1 ? 'selected' : '').'>Currently Playing</option>
				<option value="2" '.($erow['gu_status'] == 2 ? 'selected' : '').'>Casually Playing</option>
			</select><br>Time Played:
			<select name="gu_time">
				<option value="< 3 Months"  '.($erow['gu_time'] == '< 3 Months' ? 'selected' : '').'>< 3 Months</option>
				<option value="< 6 Months" '.($erow['gu_time'] == '< 6 Months' ? 'selected' : '').'>< 6 Months</option>
				<option value="< 1 Year" '.($erow['gu_time'] == '< 1 Year' ? 'selected' : '').'>< 1 Year</option>
				<option value="1 Year +" '.($erow['gu_time'] == '1 Year +' ? 'selected' : '').'>1 Year +</option>
				<option value="Several Years" '.($erow['gu_time'] == 'Several Years' ? 'selected' : '').'>Several Years</option>
			</select>
			<br>Score:
			<select name="score">';
				for ($m = 1; $m <= 10; $m++){
					echo '<option value="'.$m.'" '.($m == $erow['gu_score'] ? 'selected' : '').'>'.$m.'</option>'; 
				}
			echo '</select>
	  		<input type="Hidden" name="action" value="ueditgame">
	  		<input type="Hidden" name="sid" value="'.$gsid.'">
	  		<input type="Submit" value="UPDATE"><br>(1 meaning bad, 10 meaning amazing)</form>';
		}
		if ($_SESSION['u_id'] == $row[0] && $sub_action == 'uaddgame'){ // if your veiwing ur own profile
			$sql = "SELECT g_id, g_name FROM Games WHERE g_type = 0";
			if($games = mysqli_query($link, $sql)){}
			//$games = mysqli_query($game_query) or die ("Query failed, table games " .mysqli_error());
			$tgames = mysqli_num_rows($games);
		echo 'Add Game<br>
		<form action="process.php" method="post">
		<select name="game" size="1">
			<option value="">Choose a Game</option>';
			for($i = 0; $i < $tgames; $i++) {
			$grow = mysqli_fetch_array($games); //get a row from our result set
				$sql = "SELECT gu_userid, gu_gameid FROM user_games WHERE gu_gameid = ".$grow[0]." && gu_userid = ".$_SESSION['u_id']."";
				if($result = mysqli_query($link, $sql)){}
				//$cancel = mysqli_query($game_query2);
				$cancelcount = mysqli_num_rows($result);
				if ($cancelcount != 1){
				echo '<option value="'.$grow[0].'">'.$grow[1].'</option>';
				}
			}
		echo '</select><br>Username:<br><input type="text" name="username" maxlength="75" size="15"><br>
		Server:<br><input type="Text" name="server" size="15" maxlenght="50"><br>
		Faction:<br><input type="Text" name="faction" size="15" maxlenght="50"><br>Status:
		<select name="gu_status">
			<option value="0">Not currently Playing</option>
			<option value="1">Currently Playing</option>
			<option value="2">Casually Playing</option>
		</select><br>Time Played:
		<select name="gu_time">
			<option value="< 3 Months">< 3 Months</option>
			<option value="< 6 Months">< 6 Months</option>
			<option value="< 1 Year">< 1 Year</option>
			<option value="1 Year +">1 Year +</option>
			<option value="Several Years">Several Years</option>
		</select>
		<br>Score:
		<select name="score">';
			for ($m = 1; $m <= 10; $m++){
				echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
			}
		echo '</select>
	  <input type="Hidden" name="action" value="uaddgame">
	  <input type="Hidden" name="sid" value="'.$_SESSION['u_id'].'">
	  <input type="Submit" value="ADD"><br>(1 meaning bad, 10 meaning amazing)</form>';

	?>
	Don't see your game in the list? 
	<?php 
			if ($_SESSION['sec'] >= 2 ){
				echo '<a href="index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'&sub_action=addgame">ADD</a> it to the Data Base.<br><br>';
			}
			else {
				echo 'Msg <a href="index.php?mainaction=msg&sid=1" class="blue">Webmaster</a> and I will get it added for you.';
			}
		}
			echo 'Currently Playing:<br>';	
			$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$_SESSION['u_id']."' && gu_status = 1 && g_type = 0 ORDER BY g_name ASC"; 
			if($result = mysqli_query($link, $sql)){}
			//$games = mysqli_query($game_query) or die ("Query failed, table games " .mysqli_error());
			$tgames = mysqli_num_rows($result);
			if ($tgames == 0){
				echo 'N/A<br>';
			}
			else {
				for($i = 0; $i < $tgames; $i++) {
			 		$grow = mysqli_fetch_array($result); //get a row from our result set
			 		echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row[0] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
				}
			}
			echo 'Casually Playing:<br>';	
			$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$_SESSION['u_id']."' && gu_status = 2 && g_type = 0 ORDER BY g_name ASC"; 
			if($result = mysqli_query($link, $sql)){}
			//$games = mysqli_query($game_query) or die ("Query failed, table games " .mysqli_error());
			$tgames = mysqli_num_rows($result);
			if ($tgames == 0){
				echo 'N/A<br>';
			}
			else {
				for($i = 0; $i < $tgames; $i++) {
			 		$grow = mysqli_fetch_array($result); //get a row from our result set
			 		echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row[0] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
				}
			}
			echo 'Played:<br>';	
			$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE gu_userid = '".$_SESSION['u_id']."' && gu_status = 0 && g_type = 0 ORDER BY g_name ASC"; 
			if($result = mysqli_query($link, $sql)){}
			//$games = mysqli_query($game_query) or die ("Query failed, table games " .mysqli_error());
			$tgames = mysqli_num_rows($result);
			if ($tgames == 0){
				echo 'N/A<br>';
			}
			else {
				for($i = 0; $i < $tgames; $i++) {
			 		$grow = mysqli_fetch_array($result); //get a row from our result set
			 		echo '<a href="index.php?mainaction=game&sid='.$grow['g_id'].'" class="blue">'.$grow['g_name'].'</a> '.($_SESSION['u_id'] == $row[0] ? '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&sub_action=editugame&gsid='.$grow['gu_id'].'" class="green">Edit</a>' : '').'<br>';
				}
			}

	?>

		</div>

        <div class="game-ss">
<?php
echo'

  <h3>Pictures Gallery: New! </h3>';
	if ($_SESSION['u_id'] == $row[0]){
	echo '<a href="index.php?mainaction=profile&sub=user&sid='.$sid.'&addpic=1" class="green">Add Pic</a>';
	}
	 
	if ($_SESSION['u_id'] == $row[0] AND $addpic == 1){
  		$sql = "SELECT * FROM Games ORDER BY g_name ASC";
		if($catresult = mysqli_query($link, $sql)){}
		//$catresult = mysqli_query($query);
		$catrows = mysqli_num_rows($catresult);
		echo'<tr>
    	<td colspan="2"><form enctype="multipart/form-data" action="imgprs.php" method="post" name="news">
		<input type="Hidden" name="MAX_FILE_SIZE" value="50000000">
		<input name="userfile" type="File"> Name: <input type="Text" name="name" size="15"> Category: <select name="cat">
		<option value="0" Selected>General</option>';
		for($i = 0; $i < $catrows; $i++) {
			$catrow = mysqli_fetch_array($catresult); //get a row from our result set
		echo '<option value="'.$catrow[0].'">'.$catrow[1].'</option>';
		}
		echo '</select><input type="Submit" value=" Upload "><br>
		<textarea name="desc" cols="80" rows="10">Description</textarea>
		</form></td>
  		</tr>';
  	}
	//------------- General Category
	echo '<tr><td colspan="2">';
			if (!$offset){
				$offset = 0;
			}
			$ipp = 10;
			
		$sql = "SELECT * FROM image WHERE i_auth = ".$row[0]." AND i_cat = 0 ORDER BY i_id DESC LIMIT ".$ipp." OFFSET ".$offset."";
		if($dresult = mysqli_query($link, $sql)){}
		//$dresult = mysqli_query($query) or die ('img query failed'. mysqli_error() );
		$tpages = ceil(mysqli_num_rows($dresult)/$ipp);
		$tdata = mysqli_num_rows($dresult);
			if ($tdata == 0){
				echo '';
			}
			else{
				echo '<table><tr>';
				echo 'General <br>';
				for($i = 0; $i < $tdata; $i++) {
				$drow = mysqli_fetch_array($dresult); //get a row from our result set
				echo '<td class="eight" align="center"><a href="imgview.php?id='.$drow['i_id'].'"><img src="img/profile/thumb/'.$drow['i_src'].'" hspace="5" border="0"></a><br>'.date( 'M jS',strtotime($drow['i_date'])).'</td>';
				}
				echo '</tr></table>';
			//require('nextback.php');
			}
	echo '</td></tr>';
		//-------------- End of General Category

	//------------- image cateogories 
	$sql = "SELECT * FROM Games ORDER BY g_name ASC";
	if($cresult = mysqli_query($link, $sql)){}
	//$cresult = mysqli_query($query) ;
	//$cpages = ceil(mysqli_num_rows($cresult)/$ipp);
	$cdata = mysqli_num_rows($cresult);
	for($i = 0; $i < $cdata; $i++) {
			$crow = mysqli_fetch_array($cresult); //get a row from our result set
	
		//------------- Individual catagories
		
			if (!$offset){
				$offset = 0;
			}
			$ipp = 8;
			$sql = "SELECT * FROM image WHERE i_auth = ".$row[0]." AND i_cat = ".$crow['0']." ORDER BY i_id DESC LIMIT ".$ipp." OFFSET ".$offset."";
			if($dresult = mysqli_query($link, $sql)){}
			//$dresult = mysqli_query($query);
			$tpages = ceil(mysqli_num_rows($dresult)/$ipp);
			$tdata = mysqli_num_rows($dresult);
			if ($tdata == 0){
				echo '';
			}
			else{
			echo '';
				echo '';
				echo ''.$crow['1'].'<br>';
				for($i = 0; $i < $tdata; $i++) {
					$drow = mysqli_fetch_array($dresult); //get a row from our result set
					echo '<a href="imgview.php?id='.$drow['i_id'].'"><img src="img/profile/thumb/'.$drow['i_src'].'" hspace="5" border="0"></a><br>'.date( 'M jS',strtotime($drow['i_date'])).'</td>';
				}
				echo '';
			if ($tdata > 8){
			 echo 'Only showing newest 8 images, I will get a paging function written to allow viewing anything old.';
			}
			
			echo '
		</div>';



        if ($_SESSION['u_id'] == $sid){ 
            $why = "SELECT * FROM forum WHERE f_reply = 1 AND f_auth = '".$sid."'";
        
                    $result4 = mysqli_query($link, $why) or die("Mysql Error:" . mysqli_error());
                        $numrows2 = mysqli_num_rows($result4);
                        
                        for ($i = 0; $i < $numrows2; $i++){
                            $row2 = mysqli_fetch_array($result4);
                            echo 'Someone has replied to your post about: <br>
                            <a href="index.php?mainaction=vthread&id='.$row2['f_id'].'&cat='.$row2['$f_cat'].'" class="nav">"'.$row2['f_sub'].'"</a><br>';
                        }
        }


        if ($_SESSION['u_id'] == $sid){ //AND f_auth = '".$_SESSION['u_id']."'
            echo 'Forum activity since your last login<br>';
            $weird = "SELECT * FROM forum WHERE f_date > '".$_SESSION['old_date']."'";
                        $wresult = mysqli_query($weird);
                        //$cutoff = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")-2,date("Y")));
        
                        if (isset($_SESSION['login'])) {//"
                            $post = 0;
                            $reply = 0;
                            $numrows4 = mysqli_num_rows($wresult);
                            for ($i = 0; $i < $numrows4; $i++){
                                $row4 = mysqli_fetch_array($wresult);
                                if ($row4['f_parent'] == 0){
                                    $post = $post+1;
                                }
                                else {
                                    $reply = $reply+1;
                                }
                            }
                            echo $post.' Posts '.$reply.' Replies<br>';
                            
                        }
            }

            if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                echo '<form enctype="multipart/form-data" action="process.php" method="post" name="users">
                    <input type="hidden" name="action" value="user">
                  <input type="Hidden" name="MAX_FILE_SIZE" value="5000000">
                  <input type="hidden" name="sub_action" value="update">
                  <input type="hidden" name="u_id" value="'.$row[0].'">
                  <input type="Hidden" name="loc" value="profile">';
              }

              if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                echo '<input type="Text" name="u_kingdom" value="'.$kingdom.'" border="0" vspace="0">';
             }

             if ($sub_action == 'edit' && $_SESSION['u_id'] == $row[0]){
                echo 'First Name:';
              }

              if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                echo '<input type="Text" name="u_fname" value="'.$row[1].'" border="0" vspace="0">';
             }

             if ($sub_action == 'edit' && $_SESSION['u_id'] == $row[0]){
                echo 'Last Name:';
                }

                if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                    echo '<input type="Text" name="u_lname" value="'.$row[2].'" border="0" vspace="0" accept="text/plain">';
              }

              if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                echo '<input type="Text" name="u_email" value="'.$row[5].'" border="0" vspace="0" accept="text/plain">';
                }

                if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                    echo 'M <select name="month" size="1">';
                              $phpdate = strtotime( $row[6] );
                              //$bdate1 = date( 'm', $phpdate1);
                              $bm = date( 'm', $phpdate);
                              for ($m = 1; $m <= 12; $m++){
                                  echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
                              }
                              echo '</select>
                              D	<select name="day" size="1">';
                              $bd = date( 'd', $phpdate);
                                  for ($d = 1; $d <= 31; $d++){
                                    echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
                                  }
                              echo '</select>
                              Y <select name="year" size="1">';
                              $by = date( 'Y', $phpdate);
                                  for ($y = 2013; $y >= 1913; $y--){
                                    echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
                                  }
                              echo '</select>';
                        }
                        else {
                        echo date("M jS", strtotime($row[6]));
                        }  

if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
			   		echo '<input type="Text" name="u_fbook" value="'.$row[20].'" border="0" vspace="0" accept="text/plain">';
			  	}
                  else {
                    if ($row[21] != NULL){
                        echo '<a href="http://www.facebook.com/'.$row[20].'" target="_blank">'.$row[20].'</a>';
                    }
                    else {
                        echo 'Not Avail';
                    } 
                }
                if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                    echo '<input type="Text" name="u_utube" value="'.$row[16].'" border="0" vspace="0" accept="text/plain">';
                    }
                    if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                        echo '<tr><td colspan="2">Keep my email private: Yes <input type="Radio" name="u_privacy" value="1" '.($row[8] == 1 ? 'checked' : '').'> No <input type="Radio" name="u_privacy" value="0" '.($row[8] == 0 ? 'checked' : '').'></td></tr>';
                        echo '<tr><td colspan="2">Sex:<input type="Radio" name="u_sex" value="1" '.($row[7] == 1 ? 'checked' : '').'>Gent  <input type="Radio" name="u_sex" value="2" '.($row[7] == 2 ? 'checked' : '').'>Lady  <input type="Radio" name="u_sex" value="3" '.($row[7] == 3 ? 'checked' : '').($row[7] == 0 ? 'checked' : '').'>Rock Golem <i>(i dont have sex organs)</i></td></tr>';
                    }

                    switch ($row[8]){
                        case "3":
                        echo 'Admin ';
                        break;
                        case "2":
                        echo 'Member ';
                        break;
                        default:
                        echo '';
                        break;
                    }

                    if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                        echo '<h3>Forum Signature:</h3>';
                        echo '<textarea name="u_sig" cols="80" rows="10">';
                          echo htmlspecialchars($fsig);
                          echo '</textarea>'; 
                          echo '<h3>PC Specs: </h3><textarea name="u_pc" cols="80" rows="10">';
                          echo htmlspecialchars($fpc);
                          echo '</textarea>';	
                        echo  '<h3>Upload Avatar:</h3>
                          <input name="userfile" type="File">
                          <br>Name your avatar: <input name="i_name" type="TEXT" size="10" maxlength="75">
                          <br>(Jpeg or Gif images only.  Dimensions need to be 128x128 and max size 1 mB.  If the image is larger it will be automatically resized and it will not look as good as if you did it yourself.)
                      
                          <br>(images you upload will only be available to you)
                          <br>
                          <input type="submit" value="SAVE CHANGES"></form><form action="index.php" method="post">
                          <input type="Hidden" name="mainaction" value="profile">
                          <input type="Hidden" name="sub" value="user">
                          <input type="Hidden" name="sid" value="'.$sid.'">
                          <input type="Submit" value="CANCEL">'; 
                       }

                       if ($sub_action == 'edit' && ($_SESSION['u_id'] == $row[0] or $_SESSION['u_id'] == 1)){
                        echo '<textarea name="u_bio" cols="80" rows="10">';
                        echo htmlspecialchars($fbio);
                        echo '</textarea>';
                       
                        }

                        if ($_SESSION['u_id'] == $row[0] && $sub_action == 'pass'){
                            if ($error == 1){
                              echo '<tr><td colspan="2">Your old password was incorrect. Please try again.</td></tr>';
                          }
                           if ($error == 2){
                              echo '<tr><td colspan="2">Your new passwords did not match. Please try again.</td></tr>';
                          }
                           if ($error == 3){
                              echo '<tr><td colspan="2">You did not enter in a password or its shorter then 6 characters.</td></tr>';
                          }
                              echo '<form enctype="multipart/form-data" action="process.php" method="post" name="users">
                                  <input type="hidden" name="action" value="user">
                                <input type="hidden" name="sub_action" value="update">
                                <input type="hidden" name="update_pass" value="yes">
                                <input type="hidden" name="u_id" value="'.$row[0].'">
                                <input type="Hidden" name="loc" value="profile">
                      <tr><td>Old Paswword:</td>
                      <td>
                      <input type="Password" name="old_pass" accept="text/plain">
                      </td>
                    </tr>
                    <tr>
                      <td>
                      New Password: 
                      </td>
                      <td>
                      <input type="Password" name="pass1" accept="text/plain">
                      </td>
                    </tr>
                    <tr>
                      <td>
                      ReEnter Password: 
                      </td>
                      <td>
                      <input type="Password" name="pass2" accept="text/plain">
                      </td>
                    </tr>
                    <tr>
                      <td>
                     
                      </td>
                      <td>
                      <input type="SUBMIT" value="ENTER"></form>
                      <form action="index.php" method="post">
                  <input type="Hidden" name="mainaction" value="profile">
                  <input type="Hidden" name="sub" value="user">
                  <input type="Hidden" name="sid" value="'.$sid.'">
                  <input type="Submit" value="CANCEL"></form>
                      </td>
                    </tr>';

                    if ($_SESSION['u_id'] != $row[0]){
                        echo '<br><a href="index.php?mainaction=msg&sid='.$row[0].'" class="blue">Send Message</a>';
                        }	