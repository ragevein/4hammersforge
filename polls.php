<?php 
if (isset($_SESSION['login']) && $_SESSION['sec'] >= 1 ){
// column sorter
switch ($sort){
// order question
	case "p_question":
		if ($order == DESC){
		$sort = 'p_question DESC';
		}
		else {
		$sort = 'p_question Asc';
		}
	break;
// order by end date
	case "p_date":
		if ($order == DESC){
		$sort = 'p_date DESC';
		}
		else {
		$sort = 'p_date Asc';
		}
	break;
// order by author
	case "u_name":
		if ($order == DESC){
		$sort = 'u_name DESC';
		}
		else {
		$sort = 'u_name Asc';
		}
	break;
	default:
	$sort = 'p_date DESC';
	}

$sql = "SELECT * FROM poll INNER JOIN users ON poll.p_auth = users.u_id ORDER BY $sort";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ("Query failed". mysql_error());
$numofrows = mysqli_num_rows($result);
// Columns and gives option to sort asc or desc
echo '<TABLE border="0" width="750" align="center" cellpadding="4" cellspacing="2">
		<tr><td colspan="3" background="img/header/largebg.gif" class="teep"><b class="beep">Black Dragon Tech Polls</b></td></tr>';
echo '<TR style="border: 1px solid #000;"><TD><a href="'.$PHP_SELF.'&sort=p_question'; //col 1
 if ($sort == 'p_question Asc'){ //col 1
 	echo '&order=DESC';
 }
echo '" class="nav">Poll</a></TD>
<TD><a href="'.$PHP_SELF.'&sort=u_name'; //col 2
if ($sort == 'u_name Asc'){
 	echo '&order=DESC';
}
echo '">Author</a></TD>';
echo '<td width="100"><a href="'.$PHP_SELF.'&sort=p_date'; //col 3
if ($sort == 'p_date Asc'){
	echo '&order=DESC';
}
echo '">Date Posted</a></TD>';
echo '</TR>
	<tr><td colspan="3" height="2"></td></tr>';
// output of users here
for($i = 0; $i < $numofrows; $i++) {
    $row = mysqli_fetch_array($result); //get a row from our result set
	// ------------------ vote data ----------------------------------------------
		$sql = "SELECT * FROM poll_data WHERE pd_pollid = '".$row['p_id']."'";
		if($p_result = mysqli_query($link, $sql)){}
		//$p_result = mysql_query($p_query) or die ("Poll results failed");
		$votes = mysqli_num_rows($p_result);
					$v_opt1 = 0;
					$v_opt2 = 0;
					$v_opt3 = 0;
					$v_opt4 = 0;
					$v_opt5 = 0;
					$v_opt6 = 0;
					$v_opt7 = 0;
			   		for ($l = 0; $l < $votes; $l++){
						$r_votes = mysqli_fetch_array($p_result);
							if ($r_votes['pd_vote'] == 1){$v_opt1 = $v_opt1+1; }
							if ($r_votes['pd_vote'] == 2){$v_opt2 = $v_opt2+1; }
							if ($r_votes['pd_vote'] == 3){$v_opt3 = $v_opt3+1; }
							if ($r_votes['pd_vote'] == 4){$v_opt4 = $v_opt4+1; }
							if ($r_votes['pd_vote'] == 5){$v_opt5 = $v_opt5+1; }
							if ($r_votes['pd_vote'] == 6){$v_opt6 = $v_opt6+1; }
							if ($r_votes['pd_vote'] == 7){$v_opt7 = $v_opt7+1; }
							if ($r_votes['pd_userid'] == $_SESSION['u_id']){ 
							$voted = 'yes';
							}
					}
    if($i % 2) { //this means if there is a remainder
        echo '<TR bgcolor="#333333">';
    } else { //if there isn't a remainder we will do the else
        echo '<TR bgcolor="#000000">';
    }
	
// normal output of users
    echo '<TD><a href="index.php?mainaction=polls&sid='.$row["p_id"].'" class="nav">'.ucfirst($row["p_question"]).'</a></TD>
	<td>'.$row['u_name'].'</td>
	<td class="bap">'.date("M jS Y", strtotime($row['p_date'])).'</TD></tr>';
	if($i % 2) { //this means if there is a remainder
        echo '<TR bgcolor="#333333">';
    } else { //if there isn't a remainder we will do the else
        echo '<TR bgcolor="#000000">';
    }
	echo'
	<TD class="bap" colspan="3">';
	if ($row['p_opt1'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt1 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt1']).' - '.$v_opt1.' votes<br>';
		if ($v_opt1 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
		
	}
	if ($row['p_opt2'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt2 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt2']).' - '.$v_opt2.' votes<br>';
		if ($v_opt2 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}
	if ($row['p_opt3'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt3 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt3']).' - '.$v_opt3.' votes<br>';
		if ($v_opt3 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}
	if ($row['p_opt4'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt4 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt4']).' - '.$v_opt4.' votes<br>';
		if ($v_opt4 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}
	if ($row['p_opt5'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt5 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt5']).' - '.$v_opt5.' votes<br>';
		if ($v_opt5 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}
	if ($row['p_opt6'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt6 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt6']).' - '.$v_opt6.' votes<br>';
		if ($v_opt6 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %"  class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}	
	if ($row['p_opt7'] != ""){
		$multy = 100 / $votes;
		$percent = $v_opt7 * $multy;
		$width = ($percent / 100) * 600 ;
		echo  ucfirst($row['p_opt7']).' - '.$v_opt7.' votes<br>';
		if ($v_opt7 == 0){
			echo '<img src=img/spacer.gif width="5" height="10" title="'.$percent.' %" class="s"> '.round($percent, 1).' % <br><br>';		
		}
		else {
			echo '<img src=img/spacer.gif width="'.$width.'" height="10" title="'.$percent.' %" border="1" class="s"> '.round($percent, 1).' % <br><br>';
		}
	}

	echo 'Total votes = '.$votes.'</tr>';
	}
echo '<tr><td colspan="7" height="2"></td></tr>
</table>';
}
// if not logged in -------------------
else {
echo 'You are not Athorized to view this page! Please log in to continue!';
}
?>