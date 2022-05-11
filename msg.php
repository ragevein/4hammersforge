<div class="container">
<table cellpadding="5" cellspacing="1">

<?php 

echo '<tr background="img/header/forumbar.gif" STYLE="background-repeat: no-repeat;"><td colspan="2"><b>Message Center</b>
'.($error == 1 ? ' &nbsp;Sorry you need to select a member before submitting' : '').'</td><td><img src="img/header/spacer.gif" height="35" width="100" border="0" alt=""></td></tr>';


if (!$offset){
	$offset = 0;
}
	$ipp = 15;
	$sql = "SELECT m_id FROM messages WHERE m_target = '".$_SESSION['u_id']."' || m_sender = '".$_SESSION['u_id']."' ";
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die ("News Query failed". mysql_error());
	$vpage	= mysqli_num_rows($result);
	$tpages = ceil(mysqli_num_rows($result)/$ipp);


$sql = "SELECT u_id, u_name FROM users ORDER BY u_name ASC";
if($resultu = mysqli_query($link, $sql)){}
//$resultu = mysql_query($query) or die (mysql_error());
switch ($subaction){
		default:
		echo '<form action="process.php" method="post" name="msg">';
		echo '<tr bgcolor="#1A2431"><td width="5"></td><td colspan="2">Send a message to a member:<br>
		<textarea rows="9" cols="77" name="body" tabindex="2"></textarea>';
		echo '<input type="Hidden" name="action" value="msg">';
		echo '<input type="Hidden" name="id" value="'.$SESSION_['u_id'].'">';
		echo ' <br>Send to: <select name="target" size="1">';
			echo '<option value="0" '.(!$sid ? 'selected' : '').'>Select Member</option>';
		for ($i = 0; $i < mysqli_num_rows($resultu); $i++){
			$row = mysqli_fetch_array($resultu);
			
			echo '<option value="'.$row['u_id'].'" '.($sid == $row['u_id'] ? 'selected' : '').'>'.ucfirst($row['u_name']).'</option>';
			
		}
		echo '</select>';
		echo '<input type="Submit" tabindex="3" value="SEND"></form>';
		echo '</td></tr> ';
		echo '<tr bgcolor="#1A2431"><td colspan="3" height="2"><img src="img/header/spacer.gif" width="938" height="2"></td></tr>';// 
		echo '<tr bgcolor="#1A2431"><td></td><td><b class="12">Newest message on top</b></td><td></td></tr>';
		$sql = "SELECT * FROM messages INNER JOIN users ON messages.m_sender = users.u_id WHERE m_target = '".$_SESSION['u_id']."' || m_sender = '".$_SESSION['u_id']."' ORDER BY m_id DESC LIMIT ".$ipp." OFFSET ".$offset."";
		if($result = mysqli_query($link, $sql)){}
		//$result = mysql_query($query) or die (mysql_error(). "Category Query failed");
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result);
			if ($row['m_target'] == $_SESSION['u_id'] && $row['m_view'] == 0){
				$sql = "UPDATE messages SET m_view = 1 WHERE m_id = ".$row['m_id']."";
				if($result = mysqli_query($link, $sql)){}
				//$updater = mysql_query($query2) or die(mysql_error()) ;
			}
			else {
				$sql = "SELECT u_id, u_name FROM users WHERE u_id = ".$row['m_target']."";
				if($result2 = mysqli_query($link, $sql)){}
				//$result2 = mysql_query($query) or die (mysql_error());
				$row2 = mysqli_fetch_array($result2);
			}
			if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}
			if ($row['m_sender'] == $_SESSION['u_id']){
			echo '<td></td><td>';
			
			echo '<b class="green">Sent to : <a href="index.php?mainaction=msg&sid='.$row2['u_id'].'" class="green">'.$row2['u_name']. '</a> : </b><b class="bop"> '.nl2br($row['m_body']).'</b>' ;
			}
			else {
			echo '<td></td><td>';
			echo '<b class="blue">From : <a href="index.php?mainaction=msg&sid='.$row['u_id'].'" class="blue">'.$row['u_name'].'</a> : </b><b class="bop">'.nl2br($row['m_body']).'</b>';
			}
			echo '</td><td width="125">'.date('M jS h:i a', strtotime($row['m_date'])).'</td></tr>';
			
		}
		//------- paging
			echo '<tr><td colspan="3">';
			$bu = 0;
		$last = ($tpages*$ipp) - $ipp;
		$big = (($offset/$ipp) + 3);
		$lil = (($offset/$ipp) - 2);
		echo '<table width="100%" bgcolor="#1A2431"><tr><td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="200" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td></tr><tr><td align="center">';
		echo ($offset == 0 ? '' : '<a href="index.php?mainaction=msg&offset=0" class="nav3">First</a>').'</td>
		<td align="center"> '.($offset == 0 ? '' : '<a href="index.php?mainaction=msg&offset='.($offset == 0 ? '0' : $offset - $ipp ).'" class="nav3"> << </a>').'</td>
		<td align="center">';
		echo ($offset >= ($ipp*3) ? '<span class="blue"> ... </span>' : ' ');
		for ($i = 1; $i <= $tpages; $i++){
			if ($big >= $i || (($offset == 0) && $i <= 4) ){
				if ($lil >= $i){
				  	if (($tpages == (($offset/5) +1)) && $i == ($i - 3)){
						$page = 5*$bu;
						echo '<a href="index.php?mainaction=msg&offset='.$page.'" class="nav3"> '.$i.' </a>';
						$bu = $bu + 1;
					}
					else {
					$page = $ipp*$bu;
					$bu = $bu + 1;
					}
				}
				else {
				$page = $ipp*$bu;
						if ($page == $offset){
							echo '<span class="gray">'.$i.'</span>';
						}
						else {
							echo '<a href="index.php?mainaction=msg&offset='.$page.'" class="nav3"> '.$i.' </a>';
						}
				$bu = $bu + 1;
				}
			}
			else {
			$page = $ipp*$bu;
			$bu = $bu + 1;
			}
		}
		echo ($tgapes > 4 ?  ($offset < (($tpages*$ipp) - ($ipp*3)) ? '<span class="blue"> ... </span>' : ' ') : '');
		 echo '</td><td align="center">';
		$next = $offset + $ipp;
		echo ($last == $offset ? '' : '<a href="index.php?mainaction=msg&offset='.$next.'"  class="nav3"> >> </a>').'</td><td align="center">'. ($last == $offset ? '' : '<a href="index.php?mainaction=msg&offset='.$last.'"  class="nav3">Last</a>' );
		echo '</td></tr></table>';
			echo '</td></tr>';
		break;
}
?>
<tr><td colspan="3"></td></tr>
</table>

</div>


