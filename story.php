<?php
	if (isset($test)){
		$table = 'test_news';
	}
	else {
		$table = 'news';
	}
$sql = "SELECT * FROM ".$table." WHERE n_id = ".$id."";
if($result = mysqli_query($link, $sql)){
		echo '<div class="news" style="width: 100%;">';
			echo'<table cellpadding="1" cellspacing="1" border="0">';  
				$row = mysqli_fetch_array($result);
				echo '<tr><td>
					  	<table>';
				$n_id = $row['n_id'];
			// edit form
			if ($subaction == edit && ($_SESSION['u_id'] == 1 || $_SESSION['u_id'] == $row['n_auth'])){
				echo '<tr><td  valign="top"><form action="iprocess.php" method="post" name="news"><input type="Hidden" name="action" value="news">
				<input type="Hidden" name="sub_action" value="update"><input type="Hidden" name="id" value="'.$row['n_id'].'"';
				echo '<input type="Text" size="80" maxlength="250" name="sub" value="'.$row['n_sub'].'">';
				echo '</td><td align="right">'.date("n-j-y", strtotime($row['n_date'])).'</td><td width="25"></td></tr><tr>
				<td colspan="3">';
				$nbody = str_replace("&gay", "'", $row['n_body']);
				echo '<p><textarea rows="9" cols="70" name="body">'.$nbody. '</textarea><br><input type="Submit"></p>';
				echo '</form>';
				echo '</td></tr></table>';
			}
			else { /// not edit
				$sql ="SELECT * FROM users WHERE u_id = '".$row['n_auth']."'";
				if($result2 = mysqli_query($link, $sql)){
				//$resul = mysql_query($quer) or die ("Cant look up user");
				$ro = mysqli_fetch_array($result2);
				$ntitle = str_replace("&gay", "'", $row['n_title']);
				echo '<tr><td><img src="img/avatars/'.$ro[10].'" height="75" width="75" align="left" hspace="7" vspace="0">
				Entry '.$row['n_id'].' - '. $ntitle.
				'<br>'.date("M jS", strtotime($row['n_date'])).'&nbsp;&nbsp;  posted by -&nbsp; 
				<a href="index.php?mainaction=profile&sub=user&sid='.$ro['u_id'].'" class="blue"> '.$ro[3].'</a>';

				if (isset($_SESSION['login']) &&($_SESSION['u_id'] == 1 || $_SESSION['u_id'] == $row['n_auth'])){
					echo '&nbsp;&nbsp;&nbsp;<a href="index.php?mainaction=addnews&subaction=edit&sid='.$row['n_id'].'" class="green">Edit</a> | 
					<a href="index.php?mainaction=del&sub=news&sid='.$row['n_id'].'" class="red">Del</a>';
				}
				$nbody = str_replace("&gay", "'", $row['n_body']);
				echo '</b></td></tr><tr><td><p>'.nl2br($nbody). '</p></td></tr></table>';
				}
			}
			$sql = "SELECT * FROM comment INNER JOIN users ON comment.com_auth = users.u_id WHERE com_npost = ".$row['n_id']." ";
			if($result = mysqli_query($link, $sql)){}
			//$result = mysql_query($query) or die ("Comment ". mysql_error());
			$rowcount = mysqli_num_rows($result);
			echo '<tr><td>Comments: '.$rowcount.'<br><img src="img/header/spacer.gif" width="500" height="3" border="0"></td></tr>';
			for ($i = 0; $i < $rowcount; $i++){
				$row = mysqli_fetch_array($result);
			//	if($i % 2) {
       //					 echo '<tr bgcolor="#333333">';
   	 //				} else {
       	 //				echo '<tr bgcolor="#444444">';
    //				}
				echo '<tr><td valign="middle">';
				if ($subaction == 'comedit' && $sid == $row['com_id'] && ($_SESSION['u_id'] == $row['com_auth'] or $_SESSION['u_id'] == 1)){
				echo '<img src="img/avatars/'.$row['u_avatar'].'" height="50" width="50" align="left" hspace="5" vspace="5"><form action="process.php" method="post">
				<input type="Hidden" name="action" value="comment"><input type="Hidden" name="com_id" value="'.$row['com_id'].'">
				<input type="Hidden" name="n_id" value="'.$n_id.'"><input type="Hidden" name="subaction" value="update">
				<a href="index.php?mainaction=profile&&sub=user&sid='.$row['u_id'].'" class="blue">'.$row['u_name'].'</a> 
				'.time_since(strtotime($row['com_date'])).' ago <br><textarea name="body" cols="70" rows="10">'.$row['com_body'].'</textarea>';
				echo '<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value=" UPDATE "></form>';
				}
				else {
				echo '<tr><td><img src="img/avatars/'.$row['u_avatar'].'" height="50" width="50" align="left" hspace="5" vspace="5">
				<a href="index.php?mainaction=profile&&sub=user&sid='.$row['u_id'].'" class="blue">'.$row['u_name'].'</a> 
				'.time_since(strtotime($row['com_date'])).' ago '.($row['u_id'] == $_SESSION['u_id'] ? '
				<a href="index.php?mainaction=story&subaction=comedit&id='.$id.'&sid='.$row['com_id'].'" class="green">Edit</a>' : '').' <br>'.nl2br($row['com_body']);
				}
				echo '</td></tr>';
			
			}
			if ($_SESSION['login'] && $subaction != 'comedit'){
				echo '<tr><td>Add a Comment:<br>
				<form action="process.php" method="post">
				<input type="Hidden" name="action" value="comment"><input type="Hidden" name="n_id" value="'.$n_id.'">
				<input type="Hidden" name="auth" value="'.$_SESSION['u_id'].'"><textarea name="body" cols="70" rows="10"></textarea><br><input type="Submit"></form></td></tr>';
			}
			elseif ($subaction != 'comedit') {
				echo '<tr><td>Login to comment</td></tr>';
			}
			
			echo '</table></div>';
}
		/*
			echo '<div class="rightside">';
			require('rightside.php');
			echo '</div>';
		*/

?>