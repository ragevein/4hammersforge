<?php 
if (!isset($today)){
$today = date("Y-m-j");
}
if (!isset($vday)){
$vday = date("Ymj");
}
if (!isset($viewday)){
	$viewday = date("j");
}
if (!isset($theday)){
	$theday = date("j");
}
	$dayofweek = date("N");
	$thismonth = date("n");
	$curyear = date("Y");
	$negday = mktime(0,0,0, $thismonth,1,$curyear);
	$sday = date("N", $negday);
	$kday = $theday - $dayofweek;

	if (!isset($sid)){
		$sid = $_SESSION['u_id'];
	}
	else {
		$sql = "SELECT u_name, u_id FROM users WHERE u_id =".$sid."";
		$query = mysqli_query($link, $sql);
		$view_user = mysqli_fetch_array($query);
	}

// viewing progress of single goals

	echo '<div class="fancy-header">QUEST CHALLENGE	
	<button class="slider"><a href="index.php?mainaction=rules">Da Rulez</a></button><span style="font-size:14pt; font-family:fantasy;">';
	if ($_SESSION['u_id'] == $sid){
		echo ' YOUR QUEST LOG ';
		echo '<button class="slider" id="open-button">ADD QUEST</button></div>';
	}
	else {
		echo " VIEWING ".$view_user['u_name']."'s QUEST LOG</div>";
	}
	echo '</span><div class="container">';	
// daily goals ----------------------------------------------
	$sql = "SELECT * FROM goal WHERE g_user = '".$sid."' AND g_type = 0";
	if($result = mysqli_query($link, $sql)){}
	$numrows = mysqli_num_rows($result);
	// need to make a day variable
	$rday = $viewday - 1; //
	$negday = mktime(0,0,0, $thismonth,$rday,$curyear); // prev day var
	$neatday = mktime(0,0,0, $thismonth,$viewday,$curyear); // var
	$slammer = date("M jS", $neatday);
	$prevday = date("Ymd", $negday);
	echo '
	<div class="box">
	<div class="row_topper">Daily Quests '.($_SESSION['u_id'] == $sid ? '<a href="index.php?mainaction=qlog&viewday='.$rday.'&today='.$prevday.'" class="green"><<</a>' : '').$slammer;
	if(strtotime($today) < strtotime(date("Ymd"))){ //	
		$nday = $viewday + 1; //
		$nexday = mktime(0,0,0, $thismonth,$nday,$curyear); // next day var	
		//$nextday = $nexday + 1;
		$nextday = date("Ymd", $nexday);
		echo ' <a href="index.php?mainaction=qlog&viewday='.$nday.'&today='.$nextday.'" class="green">>></a>';
	}
	echo '</div>';
	$ddone = 0;
	$dtotal = $numrows;// makes a var for total quests
	for($c = 0; $c < $numrows; $c++) { 
		$row = mysqli_fetch_array($result);
		$sql2 = "SELECT * FROM goal_data WHERE g_date = '".$today."' AND g_parent = ".$row['g_id']." ";
		if($result2 = mysqli_query($link, $sql2)){}
		$g_name = str_replace("&gay", "'", $row['g_name']);
		$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text
		$numrows2 = mysqli_num_rows($result2);
			if	($numrows2 == 1){
				$ddone++; // adds up a var with completed quests
			}	
		echo '<div class="row_pill">
		<form type="multipart" method="post" name="goal" action="process.php">
		<input type="hidden" name="action" value="g_data">
		<input type="hidden" name="g_type" value="'.$row['g_type'].'">
		<input type="hidden" name="g_date" value="'.$today.'">
		<input type="hidden" name="g_parent" value="'.$row['g_id'].'">
		<input type="hidden" name="g_user" value="'.$sid.'">
		<input type="hidden" name="g_info" value="">';
		if ($_SESSION['u_id'] == $sid){
			echo '<div class="left"><a href="index.php?mainaction=qlog&goal=1&update='.$row['g_id'].'" class="blue">'.$ttrunc.'</a><input type="hidden" name="g_id" value="'.$row['g_id'].'"></div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '<input type="submit" value="Complete">').'</div></form></div>';
		}
		else {
			echo '<div class="left">'.$ttrunc.'</div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '').'</div></form></div>';
		}
	}
	echo '<div class="row_bottom">Completed '.$ddone.'/'.$dtotal.'</div></div>';

	// weekly goals --------------------------------------------
	$sql = "SELECT * FROM goal WHERE g_user = '".$sid."' AND g_parent = 0 AND g_type = 1";
	if($result = mysqli_query($link, $sql)){}
	$numrows = mysqli_num_rows($result);
	$wprev_end = date('Y-m-d', mktime(0,0,0, $thismonth,$kday-1,$curyear)); // gets end of last week
	$wprev_start = date('Y-m-d', mktime(0,0,0, $thismonth,$kday-1-6,$curyear));
	$w_start = date('Y-m-d', mktime(0,0,0, $thismonth,$kday,$curyear));
	$w_end = date('Y-m-d', mktime(0,0,0, $thismonth,$kday+6,$curyear));
	$week_start = date('M jS', mktime(0,0,0, $thismonth,$kday,$curyear)); 
	$week_end = date('M jS', mktime(0,0,0, $thismonth,$kday+6,$curyear));
	echo '
	<div class="box">
	<div class="row_topper">Weekly '.$week_start.' to '.$week_end.'</div>';
	$wdone = 0;
	$wtotal = $numrows;// makes a var for total quests
	for($c = 0; $c < $numrows; $c++) { 
		$row = mysqli_fetch_array($result); //u_time BETWEEN '$wayold' AND '$olddate'
		$sql2 = "SELECT * FROM goal_data WHERE g_parent = ".$row['g_id']." AND g_type = 1 AND g_date BETWEEN '".$w_start."' AND '".$w_end."' ";
		if($result2 = mysqli_query($link, $sql2)){}
		$numrows2 = mysqli_num_rows($result2);
		$g_name = str_replace("&gay", "'", $row['g_name']);
		$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
		$numrows2 = mysqli_num_rows($result2);
			if	($numrows2 == 1){
				$wdone++; // adds up a var with completed quests
			}	
		echo '<div class="row_pill">
		<form type="multipart" method="post" name="goal" action="process.php">
		<input type="hidden" name="action" value="g_data">
		<input type="hidden" name="g_type" value="'.$row['g_type'].'">
		<input type="hidden" name="g_date" value="'.$today.'">
		<input type="hidden" name="g_parent" value="'.$row['g_id'].'">
		<input type="hidden" name="g_user" value="'.$sid.'">
		<input type="hidden" name="g_info" value="">';
		if ($_SESSION['u_id'] == $sid){
			echo '<div class="left"><a href="index.php?mainaction=qlog&goal=1&update='.$row['g_id'].'" class="blue">'.$ttrunc.'</a><input type="hidden" name="g_id" value="'.$row['g_id'].'"></div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '<input type="submit" value="Complete">').'</div></form></div>';
		}
		else {
			echo '<div class="left">'.$ttrunc.'</div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '').'</div></form></div>';
		}
	}
	echo '<div class="row_bottom">Completed '.$wdone.'/'.$wtotal.'</div></div>';

	// monthly goals --------------------------------------------
	$sql = "SELECT * FROM goal WHERE g_user = '".$sid."' AND g_parent = 0 AND g_type = 2";
	if($result = mysqli_query($link, $sql)){}
	$numrows = mysqli_num_rows($result);
	echo '
	<div class="box">
	<div class="row_topper">Monthly</div>';
	$mdone = 0;
	$mtotal = $numrows;// makes a var for total quests
	for($c = 0; $c < $numrows; $c++) { 
	$row = mysqli_fetch_array($result);
		$sql2 = "SELECT * FROM goal_data WHERE g_date = '".$today."' AND g_parent = ".$row['g_id']." ";
		if($result2 = mysqli_query($link, $sql2)){}
		$numrows2 = mysqli_num_rows($result2);
		$g_name = str_replace("&gay", "'", $row['g_name']);
		$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
		$numrows2 = mysqli_num_rows($result2);
			if	($numrows2 == 1){
				$mdone++; // adds up a var with completed quests
			}	
		echo '<div class="row_pill">
		<form type="multipart" method="post" name="goal" action="process.php">
		<input type="hidden" name="action" value="g_data">
		<input type="hidden" name="g_type" value="'.$row['g_type'].'">
		<input type="hidden" name="g_date" value="'.$today.'">
		<input type="hidden" name="g_parent" value="'.$row['g_id'].'">
		<input type="hidden" name="g_info" value="">';
		if ($_SESSION['u_id'] == $sid){
			echo '<div class="left"><a href="index.php?mainaction=qlog&goal=1&update='.$row['g_id'].'" class="blue">'.$ttrunc.'</a><input type="hidden" name="g_id" value="'.$row['g_id'].'"></div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '<input type="submit" value="Complete">').'</div></form></div>';
		}
		else {
			echo '<div class="left">'.$ttrunc.'</div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '').'</div></form></div>';
		}
		
	}
	echo '<div class="row_bottom">Completed '.$mdone.'/'.$mtotal.'</div></div>';
	// yearly goals --------------------------------------------
	$sql = "SELECT * FROM goal WHERE g_user = '".$sid."' AND g_parent = 0 AND g_type = 3";
	if($result = mysqli_query($link, $sql)){}
	$numrows = mysqli_num_rows($result);
	echo '
	<div class="box">
	<div class="row_topper">Yearly</div>';
	$ydone = 0;
	$ytotal = $numrows;// makes a var for total quests
	for($c = 0; $c < $numrows; $c++) { 
	$row = mysqli_fetch_array($result);
		$sql2 = "SELECT * FROM goal_data WHERE g_parent = ".$row['g_id']." ";
		if($result2 = mysqli_query($link, $sql2)){}
		$numrows2 = mysqli_num_rows($result2);
		$g_name = str_replace("&gay", "'", $row['g_name']);
		$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
		$numrows2 = mysqli_num_rows($result2);
			if	($numrows2 == 1){
				$ydone++; // adds up a var with completed quests
			}	
		echo '<div class="row_pill">
		<form type="multipart" method="post" name="goal" action="process.php">
		<input type="hidden" name="action" value="g_data">
		<input type="hidden" name="g_type" value="'.$row['g_type'].'">
		<input type="hidden" name="g_date" value="'.$today.'">
		<input type="hidden" name="g_parent" value="'.$row['g_id'].'">
		<input type="hidden" name="g_info" value="">';
		if ($_SESSION['u_id'] == $sid){
			echo '<div class="left"><a href="index.php?mainaction=qlog&goal=1&update='.$row['g_id'].'" class="blue">'.$ttrunc.'</a><input type="hidden" name="g_id" value="'.$row['g_id'].'"></div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '<input type="submit" value="Complete">').'</div></form></div>';
		}
		else {
			echo '<div class="left">'.$ttrunc.'</div>
			<div class="right">'.($numrows2 == 1 ? 'Done!' : '').'</div></form></div>';
		}
	}
	echo '<div class="row_bottom">Completed '.$ydone.'/'.$ytotal.'</div></div></div>';

	// Tracker area -------------------------------------------	

	echo '<div class="fancy-header">STATISTICS</div><div class="container-2">';

		//------------------ fancy graph----------------------------------------------------------------------------------------------------
			$w_start = date('Y-m-d', mktime(0,0,0, $thismonth,$kday+$i,$curyear));
			$w_end = date('Y-m-d', mktime(0,0,0, $thismonth,$kday+6,$curyear));
			echo '<table valign="top" align="left" bgcolor="#000000" border="0" cellpadding="3" cellspacing="1" width="500">
		    <tr>
			  <td colspan="7">Weekly progress: '.$w_start.' through '.$w_end.'</td>
			</tr>
			<tr bgcolor="#1A2431">';
		for ($i=1; $i <= 7; $i++){
			if (!isset($l)){
			$l = 1;
			}
			$block = mktime(0,0,0, $thismonth,$kday+$l-1,$curyear);
			$vday = date('D jS', $block);
			echo '<td align="center" width=50>'.$vday.'</td>';
			$l++;
		}
			echo '</tr><tr>';
		for ($i=1; $i <= 7; $i++){
			if (!isset($d)){
			$d = 1;
			}
			$block = mktime(0,0,0, $thismonth,$kday+$d-1,$curyear);
			$d++;
			$dday = date('Y-m-d', $block);
			$vday = date('j', $block);
			$sql = "SELECT * FROM goal_data WHERE g_date = '".$dday."' AND g_user = '".$sid."' AND g_type = 0 ";
			if($result = mysqli_query($link, $sql)){}
			$numrows = mysqli_num_rows($result);
			echo '<td align="center">';
			$daybar = ($numrows / $dtotal)*100;
			$blkbar = 100 - $daybar;
			//echo round($daybar);
			echo '
			<div>
				<div class="bar">
					<div class="bbar" style="height:'.$blkbar.'px">
						<div class="percent">
							'.round($daybar).'%
						</div>
					</div>
				</div>
			</div>';
			echo '</td>';
		}
			echo'</tr></table></div>';
	echo '<div class="container-2">';
	$sql = "SELECT g_id FROM goal WHERE g_user = '".$sid."' ";
	$result = mysqli_query($link, $sql);
	$numrows = mysqli_num_rows($result);
	echo '<table><tr><td><h2>Total goals/quests:</h2> '.$numrows;
	echo '</td><td><h2>Rewards - Lewt - Trophies</h2>';
	$sql = "SELECT g_id, g_user FROM goal_data WHERE g_user = '".$sid."' ";
	$result = mysqli_query($link, $sql);
	$numrows = mysqli_num_rows($result);
	$sql = "SELECT u_exp, u_coin FROM users WHERE u_id = '".$sid."' ";
	$result2 = mysqli_query($link, $sql);
	$info = mysqli_fetch_array($result2);
	echo '</td><td><h2>Rank:  Treasury: </h2>'.$info['u_coin'].' gold crowns</td><td> <h2>Total completed quests</h2> '.$numrows.' </td><td><h2>EXP:</h2> '.$info['u_exp'].'</td></tr></table></div></div>';
	// ------------------------- add a new goal or update ---------------------------------------
	echo '<dialog class="modal" id="modal">';
		if (isset($update)){
			$sql3 = "SELECT * FROM goal WHERE g_id = '".$update."' AND g_user = '".$sid."' ";
			if($result3 = mysqli_query($link, $sql3)){}
			$numrows3 = mysqli_num_rows($result3);
			$ginfo = mysqli_fetch_array($result3);
		}
		echo '<div ><form enctype="multipart/form-data" action="process.php" method="post" name="goal">
		<input type="hidden" name="action" value="goal">
		'.($numrows3 == 1 ? '<input type="hidden" name="update" value="yes"><input type="hidden" name="g_id" value="'.$ginfo['g_id'].'">
		<input type="hidden" name="g_parent" value="'.$ginfo['g_parent'].'"><input type="hidden" name="g_update" value="'.$today.'">' : ' ').'	
		<BR>New Quest: <input type="Text" accept="text/plain" size="45" name="g_name" tabindex="1" '.($numrows3 == 1 ? 'value="'.$ginfo['g_name'].'"' : ' ').'>
		<select name="g_cat">';
		$sql7 = "SELECT * FROM goal_cat ORDER BY c_name ASC";
		if($result7 = mysqli_query($link, $sql7)){
			$numrows7 = mysqli_num_rows($result7);
			for($c = 0; $c < $numrows7; $c++) { 
				$row7 = mysqli_fetch_array($result7);
				if ($numrows3 == 1){
					echo '<option value="'.$row7['c_id'].'" '.($ginfo['g_cat'] == $row7['c_id'] ? 'selected' : '').'>'.$row7['c_name'].'</option>';
				}
				else {
					echo '<option value="'.$row7['c_id'].'">'.$row7['c_name'].'</option>';
				}
			}	
		}
		echo '
		</select>
		<br>';
		if ($numrows3 == 1){
			echo '<input type="radio" id="choice1" name="g_type" value="0" '.($ginfo['g_type'] == 0 ? 'checked' : '').' ><label for="choice1">Daily:</label>
			<input type="radio" id="choice2" name="g_type" value="1" '.($ginfo['g_type'] == 1 ? 'checked' : '').' ><label for="choice2">Weekly:</label>
			<input type="radio" id="choice3" name="g_type" value="2" '.($ginfo['g_type'] == 2 ? 'checked' : '').' ><label for="choice3">Monthly:</label>
			<input type="radio" id="choice4" name="g_type" value="3" '.($ginfo['g_type'] == 3 ? 'checked' : '').' ><label for="choice4">Yearly:</label>';
			echo '<BR>
			<label for="choice5">Private:</label><input type="radio" id="choice5" name="g_vis" value="0" '.($ginfo['g_vis'] == 0 ? 'checked' : '').'>
			<label for="choice6">Visible:</label><input type="radio" id="choice6" name="g_vis" value="1" '.($ginfo['g_vis'] == 1 ? 'checked' : '').'>
			| <input type="radio" id="choice7" name="g_group" value="0" '.($ginfo['g_group'] == 0 ? 'checked' : '').'><label for="choice7">Solo:</label>
			<input type="radio" id="choice8" name="g_group" value="1" '.($ginfo['g_group'] == 1 ? 'checked' : '').'><label for="choice8">Group:</label>
			| <input type="radio" id="choice9" name="g_repeat" value="0" '.($ginfo['g_repeat'] == 0 ? 'checked' : '').'><label for="choice9">Repeatable:</label>
			<input type="radio" id="choice10" name="g_repeat" value="1" '.($ginfo['g_repeat'] == 1 ? 'checked' : '').'><label for="choice10">One time:</label>';
		}
		else {
			echo '<input type="radio" id="choice1" name="g_type" value="0" checked><label for="choice1">Daily:</label>
			<input type="radio" id="choice2" name="g_type" value="1"><label for="choice2">Weekly:</label>
			<input type="radio" id="choice3" name="g_type" value="2"><label for="choice3">Monthly:</label>
			<input type="radio" id="choice4" name="g_type" value="3"><label for="choice4">Yearly:</label>';
			echo '<BR>
			<input type="radio" id="choice5" name="g_vis" value="0" checked><label for="choice5">Private:</label>
			<input type="radio" id="choice6" name="g_vis" value="1"><label for="choice6">Visible:</label>
			| <input type="radio" id="choice7" name="g_group" value="0" checked><label for="choice7">Solo:</label>
			<input type="radio" id="choice8" name="g_group" value="1"><label for="choice8">Group:</label>
			| <input type="radio" id="choice9" name="g_repeat" value="0" checked><label for="choice9">Repeatable:</label>
			<input type="radio" id="choice10" name="g_repeat" value="1"><label for="choice10">One time:</label>';
		}
		echo '<BR>Desc: <br><textarea rows="9" cols="77" name="g_desc" tabindex="2">'.($numrows3 == 1 ? $ginfo['g_desc'] : ' ').'</textarea><BR>
		<input type="Submit" '.($numrows3 == 1 ? 'value="UPDATE"' : 'value="ENTER"').'  tabindex="3">
		</form></div>';	
	echo '<button class="slider" id="close-button">Cancel</button></dialog>';

	echo '<script src="qlog.js"></script>';
?>


