<?php
if(!isset($subaction)){
$subaction = NULL;
}
if (!isset($_SESSION['login'])){
echo 'Please log to continue.';
}
else {
$sql = "SELECT * FROM Games WHERE g_id = '".$sid."'";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query);
$row = mysqli_fetch_array($result);
$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id INNER JOIN users ON user_games.gu_userid = users.u_id WHERE Games.g_id = '".$sid."'";
if($result2 = mysqli_query($link, $sql)){}
//$result2 = mysqli_query($query);
$numrows2 = mysqli_num_rows($result2);

?>
<table background="dev/img/header/largebg.gif" STYLE="background-repeat: no-repeat;">
  <tr>
    <td align="center" colspan="2"><img src="dev/img/header/spacer.gif" width="928" height="2"></td>
  </tr>
  <tr>
	<td><a href="index.php?mainaction=games" class="nav"><< &nbsp;BACK TO GAMES</a></td>
  </tr>
  <tr>
    <td>
	  <table cellpadding="5" cellspacing="1">
	    <tr>
		  <td valign="top" align="center" rowspan="6">
		  <?php
		  	if ($sub_action == 'editgame'){
				echo '
				<form enctype="multipart/form-data" action="process.php" method="post">
				<input type="Hidden" name="action" value="editgame">
				<input type="Hidden" name="sub" value="user">
				<input type="Hidden" name="sid" value="'.$sid.'">
				<input type="Hidden" name="MAX_FILE_SIZE" value="50000000">
				<input type="text" name="name" size="25" value="'.$row['g_name'].'">';
	
			}
			else {
				echo '<b>'.$row['g_name'].'</b>';
				if ($_SESSION['sec'] >= 3){
				echo ' <a href="'.$PHP_SELF.'&sub_action=editgame&sid='.$sid.'" class="green">Edit</a>';
				} 
			}
		  
		  ?>
		  <br>
		  <?php
		    if ($row['g_img'] != ""){
				echo '<img vspace="12" src="'.$row['g_img'].'" width="200">'; 
			}
			else {
			echo '<img vspace="12" src="img/avatars/nopic.jpg">';
			}
				if ($sub_action == 'editgame'){
				echo '
		  	<br>URL to hosted image: <input type="text" name="img" size="15" value="'.$row['g_img'].'">
			<br>or Upload your own <input name="userfile" type="File">';
				}
		  ?>
		    <br><img src="dev/img/spacer.gif" width="200" height="2">
		  </td>
		  <td>
		 	<b>Developer:</b><br><img src="dev/img/spacer.gif" width="175" height="2">
		  </td>
		  <td width="415">
		  <?php
		  		if ($sub_action == 'editgame'){
		  			echo '<input type="text" name="company" size="25" value="'.$row['g_company'].'">';
				}
				else {
				  	echo $row['g_company']; 
				}
		  ?>
		  </td>
		</tr>
		<tr>
		  <td>
		 	<b>Launch Date:</b>
		  </td>
		  <td>
		  <?php
		  		if ($sub_action == 'editgame'){
		  			echo 'M <select name="month" size="1">';
					$phpdate = strtotime($row['g_ldate']); //date('Y-m-d H:i:s')
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
					$curY = date('Y');
					$gYear = date( 'Y', $phpdate);
						for ($y = $curY; $y >= 1970; $y--){
  						echo '<option value="'.$y.'" '.($y == $gYear ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';			
				}
				else {
				  	echo date("M jS Y", strtotime($row['g_ldate'])); 
				}
			?>
		  </td>
		</tr>
		<tr>
		  <td>
		 	<b>Genre:</b>
		  </td>
		  <td>
		  <?php
		  		if ($sub_action == 'editgame'){
					echo '
					<select name="genre">
						<option value="MMORPG" '.($row['g_genre'] == 'MMORPG' ? 'Selected' : '').'>MMORPG</option>
						<option value="RPG" '.($row['g_genre'] == 'RPG' ? 'Selected' : '').'>RPG</option>
						<option value="MOBA" '.($row['g_genre'] == 'MOBA' ? 'Selected' : '').'>MOBA</option>
						<option value="FPS" '.($row['g_genre'] == 'FPS' ? 'Selected' : '').'>FPS</option>
						<option value="RTS" '.($row['g_genre'] == 'RTS' ? 'Selected' : '').'>RTS</option>
						<option value="SANDBOX" '.($row['g_genre'] == 'SANDBOX' ? 'Selected' : '').'>SANDBOX</option>
					</select>';
				}
				else {
		  
		  		echo $row['g_genre']; 
				}
		  ?>
		  </td>
		</tr>
		<tr>
		  <td>
		 	<b>Platform:</b>
		  </td>
		  <td>
		  <?php
		  		if ($sub_action == 'editgame'){
					echo '		
		  			<select name="platform">
						<option value="PC" '.($row['g_platform'] == 'PC' ? 'Selected' : '').'>PC</option>
						<option value="Console" '.($row['g_platform'] == 'Console' ? 'Selected' : '').'>Console</option>
						<option value="Multi Platform" '.($row['g_platform'] == 'Multi Platform' ? 'Selected' : '').'>Multi Platform</option>
						<option value="Table Top" '.($row['g_platform'] == 'Table Top' ? 'Selected' : '').'>Table Top</option>
						<option value="Other" '.($row['g_platform'] == 'Other' ? 'Selected' : '').'>Other</option>
					</select>';
				}
				else {
		  			echo $row['g_platform']; 
				}
		  ?>
		  </td>
		</tr>
		<tr>
		  <td valign="top">
		 	<b>Description:</b>
		  </td>
		  <td>
		  <?php
		  	if ($sub_action == 'editgame'){
				echo '
		  		<textarea name="desc" cols="50" rows="5">'.$row['g_desc'].'</textarea>';
			}
			else {
		  	echo nl2br($row['g_desc']); 
			}
		  ?>
		  </td>
		</tr>
		<?php
			if ($sub_action == 'editgame'){
		  		echo '
		<tr>
		  <td></td><td>
		   	
					<b>Core Game: <input type="Radio" name="type" value="0" '.($row['g_type'] == 0 ? 'Checked' : '').'> or Expansion:</b><input type="Radio" name="type" value="1" '.($row['g_type'] == 1 ? 'Checked' : '').'>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Update">
		  </td>
		</tr>';
			}
			?>
		<tr>
		  <td><img src="dev/img/spacer.gif" width="175" height="2"></td>
		</tr>
		<?php // add urself as a player of this game
		if ($sub_action == 'addugame'){
		echo '
		<tr><td colspan="3">
		<table><tr><td rowspan="2"><img src="img/spacer.gif" width="40" height="2"</td><td>
		<form action="process.php" method="post">
		<br><b>Username:</b><br><input type="text" name="username" maxlength="75" size="15">
		</td><td>
		<b>Server:</b><br><input type="Text" name="server" size="15" maxlenght="50">
		</td><td>
		<b>Faction:</b><br><input type="Text" name="faction" size="15" maxlenght="50">
		</td><td><b>Status:</b>
		<select name="gu_status">
			<option value="0">Not currently Playing</option>
			<option value="1">Currently Playing</option>
			<option value="2">Casually Playing</option>
		</select></td><td><b>Time Played:</b>
		<select name="gu_time">
			<option value="< 3 Months">< 3 Months</option>
			<option value="< 6 Months">< 6 Months</option>
			<option value="< 1 Year">< 1 Year</option>
			<option value="1 Year +">1 Year +</option>
			<option value="Several Years">Several Years</option>
		</select>
		</td><td><b>Score:</b>
		<select name="score">';
			for ($m = 1; $m <= 10; $m++){
				echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
			}
		echo '</select></td></tr>
	  <tr><td colspan="4">
	  Review:<br><textarea name="gu_review" cols="63" rows="8"></textarea>
	  <input type="Hidden" name="game" value="'.$sid.'">
	  <input type="Hidden" name="loc" value="game">
	  <input type="Hidden" name="action" value="uaddgame">
	  </td><td align="center">(1 meaning bad, 10 meaning amazing)<br>
	  <input type="Submit" value="ADD"></form>
	  </td></tr></table></td></tr>';
		}
		elseif ($sub_action == 'editugame'){
		
			$sql = "SELECT * FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE user_games.gu_id = '".$gsid."'";
			if($eresult = mysqli_query($link, $sql)){}
			//$eresult = mysql_query($query);
			$erow = mysqli_fetch_array($eresult);
			$enumrows = mysqli_num_rows($ersult);
			echo '
			<tr>
			  <td colspan="3" align="center">
			    <table>
				  <tr>
				    <td>
					<b>Editing </b><br>
			<form action="process.php" method="post">
			<b>Username:</b><br><input type="text" name="username" maxlength="75" size="15" value="'.$erow['gu_user_name'].'"></td>
			<td><b>Server:</b><br><input type="Text" name="server" size="15" maxlenght="50" value="'.$erow['gu_server'].'"></td>
			<td><b>Faction:</b><br><input type="Text" name="faction" size="15" maxlenght="50" value="'.$erow['gu_faction'].'"></td>
			<td><b>Status:</b><br>
			<select name="gu_status">
				<option value="0" '.($erow['gu_status'] == 0 ? 'selected' : '').'>Not currently Playing</option>
				<option value="1" '.($erow['gu_status'] == 1 ? 'selected' : '').'>Currently Playing</option>
				<option value="2" '.($erow['gu_status'] == 2 ? 'selected' : '').'>Casually Playing</option>
			</select></td>
			<td><b>Time Played:</b><br>
			<select name="gu_time">
				<option value="< 3 Months"  '.($erow['gu_time'] == '< 3 Months' ? 'selected' : '').'>< 3 Months</option>
				<option value="< 6 Months" '.($erow['gu_time'] == '< 6 Months' ? 'selected' : '').'>< 6 Months</option>
				<option value="< 1 Year" '.($erow['gu_time'] == '< 1 Year' ? 'selected' : '').'>< 1 Year</option>
				<option value="1 Year +" '.($erow['gu_time'] == '1 Year +' ? 'selected' : '').'>1 Year +</option>
				<option value="Several Years" '.($erow['gu_time'] == 'Several Years' ? 'selected' : '').'>Several Years</option>
			</select></td>
			<td>
			<b>Score:</b><br>
			<select name="score">';
				for ($m = 1; $m <= 10; $m++){
					echo '<option value="'.$m.'" '.($m == $erow['gu_score'] ? 'selected' : '').'>'.$m.'</option>'; 
				}
			echo '</select></td></tr><tr><td colspan="5"><b>Your Review:</b><br>
			<textarea name="review" cols="80" rows="5">'.$erow['gu_review'].'</textarea></td><td>
	  		<input type="Hidden" name="action" value="ueditgame">
			<input type="Hidden" name="loc" value="game">
	  		<input type="Hidden" name="sid" value="'.$gsid.'"> 
			<input type="Hidden" name="gsid" value="'.$sid.'">
	  		<input type="Submit" value="UPDATE"></form></td></tr></table></td></tr>';

		}
		else {
		$sql = "SELECT gu_userid FROM user_games WHERE gu_userid = ".$_SESSION['u_id']." && gu_gameid = ".$sid."";
		if($ruin = mysqli_query($link, $sql)){}
		//$ruin = mysql_query($query) or die ('query faild'. mysql_error());
		$ruincount = mysqli_num_rows($ruin);
			if ($ruincount != 1){
			echo '
			<tr>
		 	 <td></td>
			  <td colspan="2">
			    Played or Playing this game?  <a href="'.$PHP_SELF.'&sub_action=addugame&sid='.$sid.'" >ADD</a> yourself to the list and give a review.
			  </td>
			</tr>';
			}
		?>
		<tr>
		  <td colspan="3" background="dev/img/header/largebg.gif" STYLE="background-repeat: no-repeat;">
		  <img src="dev/img/header/spacer.gif" width="928" height="2">
		    <table cellpadding="5" cellspacing="2" border="0" width="100%">

			  <tr>
			    <td>
				  <b>BDT User Name:</b>
				</td>
				<td>
				  <b>Game Username:</b>
				</td>
				<td>
				   <b>Server:</b>
				</td>
				<td>
				  <b>Faction:</b>
				</td>
				<td>
				  <b>Time Played:</b>
				</td>
				<td>
				  <b>Rating</b>
				</td>
				<td></td>
			  </tr>
			  <?php 
			  $rating = 0;
			  for($i = 0; $i < $numrows2; $i++) {
			 		$urow = mysqli_fetch_array($result2); //get a row from our result set
			 
				
			  		echo '
			  <tr bgcolor="#1A2431">
			    <td><a href="index.php?mainaction=profile&&sub=user&sid='.$urow["gu_userid"].'" class="nav">'.$urow['u_name'].'</a></td>
			    <td>';
						echo $urow['gu_user_name'];
			   echo '
				</td>
				<td>'.$urow['gu_server'];
				
				echo '
				</td>
				<td>'.$urow['gu_faction'].'</td>
				<td>'.$urow['gu_time'].'</td>
				<td align="right">'.$urow['gu_score'].'</td>
				<td>'.($_SESSION['u_id'] == $urow["gu_userid"] ? '<a href="index.php?mainaction=game&sub_action=editugame&sid='.$sid.'&gsid='.$urow['gu_id'].'" class="green">Edit</a>' : '').'</td>
			  </tr>';
			  $rating = $rating + $urow['gu_score'];
			  }
			  $rating = $rating / $numrows2;
			   echo '<tr bgcolor="#1A2431"><td></td><td></td><td></td><td></td><td></td><td>Avg: '.round($rating, 1).'</td><td></td></tr>';
			   echo '<tr bgcolor="#1A2431"><td></td><td></td><td></td><td></td><td colspan="2">Total Members: '.$numrows2.'</td><td></td></tr>';
			  ?>
			</table>
		   
		  </td>
		</tr>
		<?php
		}
		?>
		
	  </table>
	</td>
  </tr>
  <tr>
    <td align="center" colspan="2"></td>
  </tr>
  <?php
  if (isset($_SESSION['u_id']) AND $addpic == 1){
  
		echo'<tr>
    	<td colspan="2"><form enctype="multipart/form-data" action="imgprs.php" method="post" name="gamess">
		<input type="Hidden" name="MAX_FILE_SIZE" value="50000000">
		<input type="Hidden" name="target" value="game">
		<input type="Hidden" name="cat" value="'.$sid.'">
		<input name="userfile" type="File"> <b>Name:</b> <input type="Text" name="name" size="15"> ';
		echo '</select><input type="Submit" value=" Upload "><br>
		<textarea name="desc" cols="80" rows="10">Description</textarea>
		</form></td>
  		</tr>';
  	}
  ?>
  <tr>
    <td colspan="2">
	  <table cellpadding="5" cellspacing="1" background="dev/img/header/largebg.gif" STYLE="background-repeat: no-repeat;" width="100%">
	    <tr>
		  <td><b>Screen Shots</b>
	<?php 
	if (isset($_SESSION['u_id']) AND $addpic != 1){
	echo '<a href="index.php?mainaction=game&addpic=1&sid='.$sid.'" class="green"> Add</a> a Screenshot for this game.';
	}
	?>
	</td>
  </tr>
  <tr>
    <td>
	<?php
	  echo '<table><tr>';
	  		if (!$offset){
				$offset = 0;
			}
			$ipp = 10;
			$sql = "SELECT * FROM image INNER JOIN users ON image.i_auth = users.u_id WHERE i_cat = ".$sid." ORDER BY i_id DESC LIMIT ".$ipp." OFFSET ".$offset."";
			if($dresult = mysqli_query($link, $sql)){}
			//$dresult = mysql_query($query);//
			$tpages = ceil(mysqli_num_rows($dresult)/$ipp);
			$tdata = mysqli_num_rows($dresult);
				for($i = 0; $i < $tdata; $i++) {
					$drow = mysqli_fetch_array($dresult); //get a row from our result set
					echo '<td class="eight" align="center"><a href="/img/profile/'.$drow['i_src'].'"><img src="img/profile/thumb/'.$drow['i_src'].'" hspace="5" border="0"></a>
					<br>'.date( 'M jS',strtotime($drow['i_date'])).'<br>by ';
					//$drow['u_name']
					switch ($drow['u_sec']){
					case "3":
					echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$drow["u_id"].'" class="blue">';
					break;
					case "2":
					echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$drow["u_id"].'" class="green"> ';
					break;
					default:
					echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$drow["u_id"].'" class="green"> ';
					break;
					}
					echo ucfirst($drow['u_name']).'</a>';
					
					echo '</td>';
					// keeps rows at 8 items long then makes a new row
					if ($i % 7 == 0){
						if ($i > 1){
						echo '</tr><tr>';
						}					
					}
				}
				echo '</tr></table>';
			require('dev/nextback.php');
	?>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr>
    <td align="center" colspan="2"></td>
  </tr>
</table>
<?php
}
?>