<?php 
$query = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id WHERE f_id = '".$id."' ";
$querycat = "SELECT * FROM forum WHERE f_id = '".$cat."'";
$resultcat = mysql_query($querycat);
$rowcat = mysql_fetch_array($resultcat);
$result = mysql_query($query) or die ("Category Query failed");
$row = mysql_fetch_array($result);
	//if ($_SESSION['quest'] == 0 && $cat != 42 ) {
	//echo 'Not authorized to view this page.  You need to be a member to view these pages.';
	//}
	//else {
		echo '<table cellpadding="5" cellspacing="1">
		  <tr class="b">
			<td colspan="3" background="img/header/forumbar.gif" STYLE="background-repeat: no-repeat;">';  
		echo '
        <table width="100%" cellpadding="5" cellspacing="2">
          <colgroup span="3" width="30%" />
          <tr>
            <td valign="middle"><a href="index.php?mainaction=thread&cat='.$cat.'" class="nav"><< &nbsp;BACK</a></td>
		    <td align="center"><b class="beep">'.($subaction == 'reply' ? 'Replying to ' : '').$rowcat['f_sub'].'</b></td>
            <td align="right">';
		if (isset($_SESSION['login'])){
			if ($subaction != 'reply') { // form to edit
			echo '<a href="'.$url.'?mainaction=vthread&subaction=reply&id='.$id.'&cat='.$cat.'&parent='.$id.'" class="nav">REPLY</a>';
			}
			else {
			echo '<img src="img/header/spacer.gif" width="195" height="2" alt="">';
			}
		}
		
		echo '</td></tr></table></td></tr>';
		if ($subaction == edit || $subaction == 'reply'){
			echo '<tr><td colspan="2">';
			require('form2.php');
			echo '</td></tr>';
			if (isset($sid) or $subaction == 'reply'){
				echo '<tr><td align="center" colspan="2" background="img/header/forumbar.gif" STYLE="background-repeat: no-repeat;">';
				echo '<b class="beep"> Original Thread - '.$rowcat['f_sub'].'</b>';
				echo '</td></tr>';
			}
		}

			$k = $row['f_view']+1; // to incriment views at bottom
			$auth = $row['f_auth'];
			if ($subaction == edit && $row['f_id'] == $id && !isset($sid) && ($_SESSION['u_id'] == $row['f_auth'] or $_SESSION['sec'] == 3)){
			// show nothing while editing
			}
			else {
					echo '<tr bgcolor="#1A2431">';
				echo '<td align="center"><b class="bop">'.date("n-j-y h:i a", strtotime($row['f_date']));
			echo '</td><td><b class="beep">'.$row['f_sub'].'</b>';
			echo '</td>';
			echo '</tr>';
			echo '<tr bgcolor="#1A2431">';
			echo '<td width="200" valign="top" align="center">';
			echo '<img src="img/avatars/'.($row['u_avatar'] != NULL ? $row['u_avatar'] : 'nopic.jpg').'" hspace="5"  height="128" width="128"><br>';
			switch ($row['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="blue">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="green">Member ';
				break;
				default:
				echo '';
				break;
			}
			echo $row['u_name'].'</a><br>';
			if (isset($_SESSION['login']) && ($_SESSION['sec'] == 3 or $_SESSION['u_id'] == $row['f_auth'])){
				echo '<a href="'.$url.'?mainaction=vthread&subaction=edit&id='.$id.'&cat='.$cat.'" class="green"> Edit</a> |'; 
					if ( $_SESSION['sec'] == 3){
					echo ' <a href="index.php?mainaction=del&sub=forum&sid='.$row['f_id'].'" class="red">Del</a></b>';
					}
			}
			echo '</td>
			<td width="790" valign="top" height="90%"><table cellpadding="0" cellspacing="0"><tr><td><img src="img/header/spacer.gif" align="right" height="127" width="1" alt="">'.nl2br($row['f_body']). '</td></tr>
			<tr><td valign="bottom"><img src="img/header/black.jpg" width="770" height="1" hspace="0" vspace="6"><br>'.nl2br($row['u_sig']). '</td></tr></table></td></tr>'; // username under pic
			}
		
$query = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id	WHERE f_parent = '".$id."' ORDER BY f_date ASC";

$result = mysql_query($query) or die ("Category Query failed");
	if (mysql_num_rows($result) > 0){
		// replies if any section
		for ($i = 0; $i < mysql_num_rows($result); $i++){
			$row = mysql_fetch_array($result);
			if ($subaction == edit && $row['f_id'] == $sid){
						echo '<tr bgcolor="#666666">';
			}
			else {
					if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}	
			}
			echo '<td width="200" valign="top" align="center"><b class="bop">'.date("n-j-y h:i a", strtotime($row['f_date'])).'<br>';
			echo '<img src="img/avatars/'.($row['u_avatar'] != NULL ? $row['u_avatar'] : 'nopic.jpg').'" hspace="5" vspace="2" height="128" width="128"><br>';
			switch ($row['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="blue">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="green">Member ';
				break;
				default:
				echo '';
				break;
			}
			echo $row['u_name'].'</a><br>';
				if (isset($_SESSION['login']) && ($_SESSION['u_id'] == 1 or $_SESSION['u_id'] == $row['f_auth'])){
					echo '<a href="'.$url.'?mainaction=vthread&subaction=edit&id='.$id.'&sid='.$row['f_id'].'&cat='.$cat.'" class="green"> Edit</a> | ';
					if ($_SESSION['sec'] == 3){
						echo '<a href="index.php?mainaction=del&sub=forum&sid='.$row['f_id'].'" class="red">Del</a>';
					}
				}
			echo '</b></td>
			<td width="790" valign="top"><table cellpadding="0" cellspacing="0"><tr><td><img src="img/header/spacer.gif" align="right" height="127" width="1" alt="">'.nl2br($row['f_body']). '</td></tr>';
				if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}
			echo '<tr><td valign="bottom"><img src="img/header/black.jpg" width="770" height="1" hspace="0" vspace="6"><br>'.nl2br($row['u_sig']). '</td></tr></table></td></tr>';
			
			
		}
	}


	echo '<tr><td colspan="3"><img src="img/header/spacer.gif" height="2" width="938"></td></tr></table>';
// incriment views -----------------------------------------
if ($subaction != edit && !isset($views)){
	
	$update = "UPDATE forum SET f_view=".$k." ".($auth == $_SESSION['u_id'] ? ", f_reply = 0" : "")." WHERE f_id = ".$id." ";
	$resuh = mysql_query($update) or die ("Mysql Error:" . mysql_error());
}
// ---------------------------------------------------------
//}
?>

