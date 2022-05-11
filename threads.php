<?php 
if (!$offset){
	$offset = 0;
}
$ipp = 15;
$sql = "SELECT f_id FROM forum WHERE f_cat = '".$cat."' && f_parent = 0 && f_arch = 0 ";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ("News Query failed". mysql_error());
$vpage	= mysqli_num_rows($result);
$tpages = ceil(mysqli_num_rows($result)/$ipp);
$query = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id	WHERE f_cat = '".$cat."' && f_parent = 0 && f_arch = 0 ORDER BY f_order DESC, f_rdate DESC LIMIT ".$ipp." OFFSET ".$offset."";
$sql = "SELECT * FROM forum WHERE f_id = '".$cat."'";
if($resultcat = mysqli_query($link, $sql)){}
//$resultcat = mysql_query($querycat);
$rowcat = mysqli_fetch_array($resultcat);
if($result = mysqli_query($link, $query)){}
//$result = mysqli_query($query) or die ("Category Query failed");
		echo '
<table cellpadding="5" cellspacing="1" valign="top">
 <tr>
    <td colspan="4" background="img/header/forumbar.gif" STYLE="background-repeat: no-repeat;">
	  <table width="100%" cellpadding="5" cellspacing="2" border="0">
        <colgroup span="3" width="30%" />
	    <tr>
		  <td width="175">&nbsp;<a href="index.php?mainaction=forum" class="nav"><< &nbsp;BACK</a></td>
		  <td align="center">'.$rowcat['f_sub'].'</td>
		';  
		echo '
		  <td align="right">';
		if (isset($_SESSION['login']) && $_SESSION['sec'] >= 1){
			echo '<a href="index.php?mainaction=post&cat='.$cat.'&parent=0" class="nav">CREATE THREAD</a>';
		}
		else {
			echo '<img src="img/header/spacer.gif" width="175" height="35" alt="">';
		}
		echo '
		  </td>
		</tr>
	  </table>
	</td>
  </tr>';
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$row = mysqli_fetch_array($result);
			// get last reply and amount 
			$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id	WHERE f_parent = '".$row['f_id']."' ORDER BY forum.f_date DESC";
			if($result2 = mysqli_query($link, $sql)){}
			//$result2 = mysql_query($query) or die ("Cant look up replies");
			$replies = mysqli_num_rows($result2);
			$bag = mysqli_fetch_array($result2);
			$views = $row['f_view'];
				if ( $row['f_date'] > $_SESSION['old_date']) {
					echo '<tr bgcolor="#361111">';
				}
				else {
					if($i % 2) {
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}
				}
				echo '
    <td><img src="img/header/spacer.gif" width="50" height="2" alt=""></td>
	<td>'.($row['f_order'] != 0 ? '<span class="eight">[sticky]</span> ':'').'
				<a href="index.php?mainaction=vthread&id='.$row['f_id'].'&cat='.$cat.'" class="nav">'. $row['f_sub'].'</a><br>
				Author '.$row['u_name'].' '.date('n-j-y', strtotime($row['f_date'])).'</td>' ;

				echo '
	<td align="left">'.$replies.' Replies&nbsp;-&nbsp;'.$views.' views </td><td>'.($replies != 0 ? 'last reply by
				 '.$bag['u_name'].'&nbsp; ' : '').($replies != 0 ? time_since(strtotime($bag['f_date'])) : ' Posted 
				 '.time_since(strtotime($row['f_date']))).' ago ';
				
				echo '<br><img src="img/header/spacer.gif" width="225" height="2" alt="">
	</td>
  </tr>';
		}
		if ($tpages != 1){
		echo '
  <tr>
    <td colspan="4" bgcolor="#1A2431">';
		$bu = 0;
		$last = ($tpages*$ipp) - $ipp;
		$big = (($offset/$ipp) + 3);
		$lil = (($offset/$ipp) - 2);
		echo '
	  <table width="100%">
  		<tr>
    	  <td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		  <td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		  <td><img src="img/header/spacer.gif" width="200" height="2" alt=""></td>
		  <td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		  <td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td></tr>
  		<tr>
    	  <td align="center">';
			echo ($offset == 0 ? '' : '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset=0" class="nav3">First</a>').'</td>
		  <td align="center"> '.($offset == 0 ? '' : '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset='.($offset == 0 ? '0' : $offset - $ipp ).'" class="nav3"> << </a>').'</td>
		  <td align="center">';
			echo ($offset >= ($ipp*3) ? '<span class="blue"> ... </span>' : ' ');
			for ($i = 1; $i <= $tpages; $i++){
				if ($big >= $i || (($offset == 0) && $i <= 4) ){
					if ($lil >= $i){
				  		if (($tpages == (($offset/5) +1)) && $i == ($i - 3)){
							$page = 5*$bu;
							echo '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset='.$page.'" class="nav3"> '.$i.' </a>';
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
							echo '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset='.$page.'" class="nav3"> '.$i.' </a>';
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
		 	echo '
		  </td>
		  <td align="center">';
			$next = $offset + $ipp;
			echo ($last == $offset ? '' : '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset='.$next.'"  class="nav3"> >> </a>').'</td>
		  <td align="center">'. ($last == $offset ? '' : '<a href="index.php?mainaction=thread&cat='.$row['f_cat'].'&offset='.$last.'"  class="nav3">Last</a>' );
		echo '
		  </td>
  		</tr>
	  </table>';
		}
		echo '
	</td>
  </tr>';
		echo '
  <tr><td colspan="4"><img src="img/header/spacer.gif" height="2" width="938"></td>
  </tr>';
 
?>
</table>

