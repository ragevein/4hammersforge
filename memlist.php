
<?php
// make sure they are logged in && $_SESSION['u_id'] == 1
if (isset($_SESSION['login']) && $_SESSION['sec'] >= 1 ){
// column sorter
switch ($sort){
// order first name
	case "u_fname":
	if ($order == DESC){
	$sort = 'u_fname DESC';
	}
	else {
	$sort = 'u_fname Asc';
	}
	break;

// order by user name
	case "u_name":
	if ($order == DESC){
	$sort = 'u_name DESC';
	}
	else {
	$sort = 'u_name Asc';
	}
	break;
// order by security
	case "u_ref":
	if ($order == DESC){
	$sort = 'u_sec DESC';
	}
	else {
	$sort = 'u_sec Asc';
	}
	break;
	default:
	$sort = 'u_id Asc';
	}
// select all users
$sql = "SELECT * FROM users ORDER BY $sort";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die (mysql_error()."Query failed");
$numofrows = mysqli_num_rows($result);
// Columns and gives option to sort asc or desc
echo '<TABLE border="0" align="center" cellpadding="4" cellspacing="2">
		<tr class="b"><td colspan="6"><h1> &nbsp;&nbsp; Members</h1></td></tr>';
echo '<TR>
<TD width="150"><a href="'.$PHP_SELF.'&sort=u_name'; // col 1
 if ($sort == 'u_name Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">User Name</a></TD>';
echo '<TD width="100"><a href="'.$PHP_SELF.'&sort=u_fname'; //col 2
 if ($sort == 'u_fname Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">RL Name</a></TD><TD width=100>'; // column 3
echo '<a href="'.$PHP_SELF.'&sort=u_dday';
 if ($sort == 'u_dday Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">Joined</a></TD>';
echo '<TD width="200"><a href="'.$PHP_SELF.'&sort=u_time'; // col 4
 if ($sort == 'u_time Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">Activity</a></TD>';
echo '<td width="150"></td></TR>
	<tr><td colspan="7" height="2"><img src="img/header/spacer.gif" width="938" height="2"></td></tr>';
// output of users here
for($i = 0; $i < $numofrows; $i++) {
    $row = mysqli_fetch_array($result); //get a row from our result set
	$date = date_create($row['u_dday']);
    if($i % 2) { //this means if there is a remainder
        echo '<TR bgcolor="#1A2431">';
    } else { //if there isn't a remainder we will do the else
        echo '<TR bgcolor="#111111">';
    }
	// normal output of users
    echo '<TD><a href="index.php?mainaction=profile&sub=user&sid='.$row["u_id"].'" class="cool" ';
	switch ($row['u_sec']){
		case "3":
		echo ''.($row['u_id'] == 1 ? 'style="text-decoration: none;"' : 'style="text-decoration: none;"').'';
		break;
		case "2":
		echo 'style="color: green; text-decoration: none;"';
		break;
		default:
		echo 'style="color: gray; text-decoration: none;"';
		break;
	}
	echo '>'.ucfirst($row['u_name']).'</a></TD><TD class="bap">'.ucfirst($row["u_fname"]).'</TD><TD class="bap">'.date_format($date, 'M Y' ).'</TD><TD class="bap">'.time_since(strtotime($row['u_time'])).' ago</TD>
	</tr>';	
}
echo '
  <tr bgcolor="#1A2431"><td colspan="7" align="right">'.$numofrows.' total members</td></tr>
</table>';
}
// if not logged in -------------------
else {
echo 'You are not Athorized to view this page! Please log in to continue!';
}
?>