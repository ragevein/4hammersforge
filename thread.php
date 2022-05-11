<?php 
$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id WHERE f_id = '".$id."' ";
$sqlcat = "SELECT * FROM forum WHERE f_id = '".$cat."'";
if($resultcat = mysqli_query($link, $sqlcat)){}
//$resultcat = mysql_query($querycat);
$rowcat = mysqli_fetch_array($resultcat);
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ("Category Query failed");
$row = mysqli_fetch_array($result);

	//if ($_SESSION['quest'] == 0 && $cat != 42 ) {
	//echo 'Not authorized to view this page.  You need to be a member to view these pages.';
	//}
	//else {
		echo '
        <table cellpadding="5" cellspacing="1">
		  <tr class="b">
			<td colspan="3" background="img/header/forumbar.gif" STYLE="background-repeat: no-repeat;">';  
		echo '
        <table width="100%" cellpadding="5" cellspacing="2">
          <colgroup span="3" width="30%" />
          <tr>
            <td align="left"><a href="index.php?mainaction=thread&cat='.$cat.'" class="nav">&nbsp;<< &nbsp;BACK</a></td>
            <td align="center">'.($subaction == 'reply' ? 'Replying to ' : '').$rowcat['f_sub'].'</td>
            <td align="right">';
		if (isset($_SESSION['login'])){
			if ($subaction != 'reply') { // form to edit
			echo '<a href="'.$url.'?mainaction=vthread&subaction=reply&id='.$id.'&cat='.$cat.'&parent='.$id.'" class="nav">REPLY&nbsp;</a>';
			}
			else {
			echo '<img src="img/header/spacer.gif" width="195" height="2" alt="">';
			}
		}
		
		echo '
            </td>
          </tr>
        </table>
            </td>
          </tr>';
		if ($subaction == edit || $subaction == 'reply'){
			echo '<tr><td colspan="2">';
			require('form2.php');
			echo '</td></tr>';
			if (isset($sid) or $subaction == 'reply'){
				echo '<tr><td align="center" colspan="2" bgcolor="#000000">';
				echo ' Original Thread - '.$rowcat['f_sub'].'';
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
				echo '<td align="center">'.date("n-j-y h:i a", strtotime($row['f_date']));
			echo '</td><td>'.$row['f_sub'].'';
			echo '</td>';
			echo '</tr>';
			echo '<tr bgcolor="#1A2431">';
			echo '<td width="200" valign="top" align="center">';
			echo '<img src="img/avatars/'.($row['u_avatar'] != NULL ? $row['u_avatar'] : 'nopic.jpg').'" hspace="5" vspace="3" height="128" width="128"><br>';
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
			echo $row['u_name'].'</a><br>'; // like area
			echo '<table cellpadding="0" cellspacing="0" border="0"><tr><td valign="center">';
				if (isset($_SESSION['login']) ){ // makes sure they are logged in so they can like a post
					$sql = "SELECT * FROM likes WHERE l_type = 1 AND l_ref_id = ".$id." AND l_auth = ".$_SESSION[u_id].""; // checks db if you have liked this before
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query) or die ('likes query failure '.$query.'<br>'.mysql_error());
					$sql2 = "SELECT * FROM likes WHERE l_type = 1 AND l_ref_id = ".$id."";
					if($result2 = mysqli_query($link, $sql2)){}
					//$result2 = mysql_query($query2) or die ('likes query failure '.$query2.'<br>'.mysql_error());
					$numrows = mysqli_num_rows($result);
					$numrows2 = mysqli_num_rows($result2);
					if ($numrows2 == 0){
						$message = 'Be the first to like this post.';
					}
					else {
						$message = 'Like this post.';
					}
					if ($_SESSION['u_id'] == $row['f_auth']){ // just show the results, you can't like your own crap
						echo ''.$numrows2.'</td><td> Likes';
					}
					else {
						if ($numrows < 1){ // if you haven't already liked this post 
							echo ''.$numrows2.'</td><td><a href="claw_pcs.php?id='.$row['f_id'].'&type=1&auth='.$_SESSION['u_id'].'&loc=vthread&sid='.$id.'&cat='.$cat.'">Like</a> ';
						}
						else { // you have already liked this once
							echo ''.$numrows2.'</td><td>';
						}
					
					}
				}
				else { // user is not logged in but still show them if the post has any likes
					$sql = "SELECT * FROM likes WHERE c_type = 1 AND c_ref_id = ".$id.""; // grabs all the likes this post has 
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query) or die ('likes query failure '.$query.'<br>'.mysql_error());
					$numrows = mysqli_num_rows($result);
					echo ''.$numrows.'</td><td> Likes';	
				}
			echo '</td></tr></table>';
			if (isset($_SESSION['login']) && ($_SESSION['sec'] == 3 or $_SESSION['u_id'] == $row['f_auth'])){
				echo ' <a href="'.$url.'?mainaction=vthread&subaction=edit&id='.$id.'&cat='.$cat.'" class="green"> Edit</a> '; 
					if ( $_SESSION['sec'] == 3){
					echo ' <a href="index.php?mainaction=del&sub=forum&sid='.$row['f_id'].'" class="red">Del</a>';
					}
			}
			$u_sig = str_replace("&gay", "'", $row['u_sig']);
			$fixed = str_replace("&gay", "'", $row['f_body']);
			echo '</td>
			<td width="790" valign="top" height="90%"><table cellpadding="0" cellspacing="0"><tr><td><img src="img/header/spacer.gif" align="right" height="127" width="1" alt="">'.nl2br($fixed). '</td></tr>
			<tr><td valign="bottom"><img src="img/header/black.jpg" width="770" height="1" hspace="0" vspace="6"><br>'.nl2br($u_sig). '</td></tr></table></td></tr>'; // username under pic
			}
// replies to original post here		
$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id	WHERE f_parent = '".$row['f_id']."' ORDER BY f_date ASC";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ("Category Query failed");
	if (mysqli_num_rows($result) > 0){
		// replies if any section
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result);
			if ($subaction == edit && $rrow['f_id'] == $sid){
						echo '<tr bgcolor="#666666">';
			}
			else {
					if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}	
			}
			echo '<td width="200" valign="top" align="center">'.date("n-j-y h:i a", strtotime($row['f_date'])).'<br>';
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
			echo $row['u_name'].'</a><br>'; // like area
			echo '<table cellpadding="0" cellspacing="0" border="0"><tr><td valign="center">';
				if (isset($_SESSION['login']) ){ // makes sure they are logged in so they can like a post
					$sql = "SELECT * FROM likes WHERE l_type = 1 AND l_ref_id = ".$row['f_id']." AND l_auth = ".$_SESSION[u_id].""; // checks db if you have liked this before
					if($result1 = mysqli_query($link, $sql)){}
					//$result1 = mysql_query($query) or die ('likes query failure '.$query.'<br>'.mysql_error());
					$sql2 = "SELECT * FROM likes WHERE l_type = 1 AND l_ref_id = ".$row['f_id']."";
					if($result2 = mysqli_query($link, $sql2)){}
					//$result2 = mysql_query($query2) or die ('likes query failure '.$query2.'<br>'.mysql_error());
					$numrows1 = mysqli_num_rows($result1);
					$numrows2 = mysqli_num_rows($result2);
					if ($numrows2 == 0){
						$message = 'Be the first to like this post.';
					}
					else {
						$message = 'Like this post.';
					}
					if ($_SESSION['u_id'] == $row['f_auth']){ // just show the results, you can't like your own crap
						echo ''.$numrows2.'</td><td> Likes</a>';
					}
					else {
						if ($numrows1 < 1){ // if you haven't already liked this post 
							echo ''.$numrows2.'</td><td><a href="pcs.php?id='.$row['f_id'].'&type=1&auth='.$_SESSION['u_id'].'&loc=vthread&sid='.$id.'&cat='.$cat.'">Like</a> ';
						}
						else { // you hae already liked this once
							echo ''.$numrows2.'</td><td> Likes</a>';
						}
					
					}
				}
				else { // user is not logged in but still show them if the post has any likes
					$sql = "SELECT * FROM likes WHERE c_type = 1 AND c_ref_id = ".$row['f_id'].""; // grabs all the likes this post has 
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query) or die ('likes query failure '.$query.'<br>'.mysql_error());
					$numrows = mysqli_num_rows($result);
					echo ''.$numrows.'</td><td> Likes';	
				}
			echo '</td></tr></table>';
			
			
				
				
				
				
				if (isset($_SESSION['login']) && ($_SESSION['u_id'] == 1 or $_SESSION['u_id'] == $row['f_auth'])){
					echo '<br><a href="'.$url.'?mainaction=vthread&subaction=edit&id='.$id.'&sid='.$row['f_id'].'&cat='.$cat.'" class="green"> Edit</a>  ';
					if ($_SESSION['sec'] == 3){
						echo '<a href="index.php?mainaction=del&sub=forum&sid='.$row['f_id'].'" class="red">Del</a>';
					}
				}
			$fixed = str_replace("&gay", "'", $row['f_body']);
			$u_sig = str_replace("&gay", "'", $row['u_sig']);
			echo '</td>
			<td width="790" valign="top"><table cellpadding="0" cellspacing="0"><tr><td><img src="img/header/spacer.gif" align="right" height="127" width="1" alt="">'.nl2br($fixed). '</td></tr>';
				if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}
			echo '<tr><td valign="bottom"><img src="img/header/black.jpg" width="770" height="1" hspace="0" vspace="6"><br>'.nl2br($u_sig). '</td></tr></table></td></tr>';
			
			
		}
	}


	echo '<tr><td colspan="3"><img src="img/header/spacer.gif" height="2" width="938"></td></tr></table>';
// incriment views -----------------------------------------
if ($subaction != edit && !isset($views)){
	
	$sql = "UPDATE forum SET f_view=".$k." ".($auth == $_SESSION['u_id'] ? ", f_reply = 0" : "")." WHERE f_id = ".$id." ";
	if($result = mysqli_query($link, $sql)){}
	else {echo 'update failed';}
	//$resuh = mysql_query($update) or die ("Mysql Error:" . mysql_error());
}
// ---------------------------------------------------------
//}
?>

