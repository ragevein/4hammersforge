<?php 
if (!isset($thismonth)){
	$thismonth = date("n");
	$curmonth = date("F");
	$curyear = date("Y");
	$theday = date("j");
}
?>
<table align="center"  bgcolor="#000000" border="0" cellpadding="3" cellspacing="1" width="950" height="600">
  <tr>
	<td colspan="7">
	  <table width="100%">
		<tr>
		  <td align="center" width="33%">
<?php
if (!isset($yerp)){
	$yarp = date('m', mktime(0,0,0,$thismonth-1,1,date("Y")));
	$yarp2 = 1;
}
if ($yarp == date('n')){
	$yarp2 = date('j');
}
//echo $thismonth.'- 1 = '.$yarp;
echo '<a href="index.php?mainaction=calendar&thismonth='.$yarp.'&theday='.$yarp2.'&curyear='.($thismonth == 1 ? $curyear-1 : $curyear).'">Previous</a>';
?>
		  </td>
		  <td align="center" width="33%"><h1>
<?php 
echo   ''.date("F", mktime(0,0,0,$thismonth+1,0,0)). ' '.$curyear.'';
?>
		  </h1></td>
		  <td align="center" width="33%" >

<?php
if (!isset($yerp)){
	$yerp = date('m', mktime(0,0,0,$thismonth+1,1,date("Y")));
	$yerp2 = 1;
}
if ($yerp == date('n')){
	$yerp2 = date('j');
}
//echo $thismonth.'+ 1 = '.$yerp;
echo '<a href="index.php?mainaction=calendar&thismonth='.$yerp.'&theday='.$yerp2.'&curyear='.($thismonth == 12 ? $curyear+1 : $curyear).'">Next</a>';
?>
		  </td>
		</tr>
	  </table>
	</td>
  </tr>
  <tr bgcolor="#1A2431">
    <td align="center">Sun</td>
	<td align="center">Mon</td>
	<td align="center">Tues</td>
	<td align="center">Wed</td>
	<td align="center">Thur</td>
	<td align="center">Fri</td>
	<td align="center">Sat</td>
  </tr>

<?php 
// calendar
$thedayoweek = date("l");

$negday = mktime(0,0,0, $thismonth,1,$curyear);
$sday = date("N", $negday);
if ($sday == 0) {
	$startday = mktime(0,0,0, $thismonth,-6,$curyear);
}
else {
	$startday = mktime(0,0,0, $thismonth,1-$sday,$curyear);
}
//echo $sday.$startday;

$do = $theday; //todays date
$do2 = $do - 1; // yesterday
$stm = mktime(0,0,0, $thismonth,$theday-$do,date("Y")); // creates first day of current month 
$day1 = date('j', $stm); // assigns the first day of the calendar to a var
$doit = date('j', $startday); // output for each day
$dacounter = -$do; //

for ($i = 1; $i <= 6;){ // should loop 6 times giving me 6 rows
echo '<tr>'; 
	for ($e = 1; $e <= 7; $e++){ // loop 7 times giving me the weeks
			if ($doit > $day1){ // if startday greater then 1st of month
				if(!isset($adder)){ // if adder not set, set it to first day of the month
					$adder = -$do2; // puts first day to yesterday
				}
				$supercount2 = mktime(0,0,0,$thismonth,$theday+$adder,date("Y"));
				// does the cell shading depening on if its a previous month etc.
				echo '<td width="120" height="125" align="right" valign="top" '.(date('m', $supercount2) == $thismonth ? (date('d', $supercount2) != $theday ? 'bgcolor="#1A2431"' : 'bgcolor="#111111"') : 'bgcolor="#222222"').'>';
				echo date('j', $supercount2); // outputs the day in top right corner of cell
				if ($_SESSION['sec'] == 3){  // for admin eyes only
				// Bday finder below query grabs only dates that have correct month and day and ignores the year
				$sql = "SELECT * FROM birthday WHERE DayOfMonth(b_day) = '".date('j', $supercount2)."' AND Month(b_day) = '".date('m', $supercount2)."' ";
				if($result3 = mysqli_query($link, $sql)){}
				//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
				$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.ucfirst($row3['f_name']).'';
					}
					$sql = "SELECT u_bdate, u_name, u_fname FROM users WHERE DayOfMonth(u_bdate) = '".date('j', $supercount2)."' AND Month(u_bdate) = '".date('m', $supercount2)."' ";
					if($result3 = mysqli_query($link, $sql)){}
					//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
					$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.ucfirst($row3['u_fname']).'';
					}
					$sql = "SELECT e_date, e_id, e_sub, e_vis, e_auth FROM events WHERE DayOfMonth(e_date) = '".date('j', $supercount2)."' AND Month(e_date) = '".date('m', $supercount2)."'  AND year(e_date) = '".date('Y', $supercount2)."' ";
					if($result3 = mysqli_query($link, $sql)){}
					//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
					$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						if ($row3['e_vis'] == 0 && $row3['e_auth'] != $_SESSION['u_id']){
						// only lets the author view the event
						}
						else { // everyone can see it
						echo '<br><a href="index.php?mainaction=event&sid='.$row3['e_id'].'">'.substr($row3['e_sub'],0,10.).'...'.'</a>';
						}
					}
				}
				else { // all users see this
				$sql = "SELECT u_bdate, u_name, u_fname FROM users WHERE DayOfMonth(u_bdate) = '".date('j', $supercount2)."' AND Month(u_bdate) = '".date('m', $supercount2)."' ";
				if($result3 = mysqli_query($link, $sql)){}
				//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
				$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.ucfirst($row3['u_fname']).'';
					}
					$sql = "SELECT e_date, e_id, e_vis, e_auth, e_sub FROM events WHERE DayOfMonth(e_date) = '".date('j', $supercount2)."' AND Month(e_date) = '".date('m', $supercount2)."' AND year(e_date) = '".date('Y', $supercount2)."' ";
					if($result = mysqli_query($link, $sql)){}
					//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
					$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						if ($row3['e_vis'] == 0 && $row3['e_auth'] != $_SESSION['u_id']){
						// only lets the author view the event
						}
						else { // everyone can see it
						echo '<br><a href="index.php?mainaction=event&sid='.$row3['e_id'].'">'.substr($row3['e_sub'],0,10.).'...'.'</a>';
						}
					}
				}
				echo '</td>';
				$adder = $adder +1;
			}
			else {
				$thenow = date('j', $startday);  // last month at top of calendar
				echo '<td width="120" height="125" bgcolor="#222222" align="right" valign="top"> '.$doit;
				$doit3 =  mktime(0, 0, 0, $thismonth,$doit,date("Y")); // creates date for the current day
				
				//----------------------
				if ($_SESSION['sec'] == 3){
				// Bday finder below query grabs only dates that have correct month and day and ignores the year
				$sql = "SELECT * FROM birthday WHERE DayOfMonth(b_day) = '".date('j', $doit3)."' AND Month(b_day) = '".date('m', $doit3)."'-1 ";
				if($result3 = mysqli_query($link, $sql)){}
				//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
				$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.$row3['f_name'].'';
					}
					$sql = "SELECT e_date, e_id, e_vis, e_auth, e_sub FROM events WHERE DayOfMonth(e_date) = '".date('j', $supercount2)."' AND Month(e_date) = '".date('m', $supercount2)."' ";
					if($result3 = mysqli_query($link, $sql)){}
					//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
					$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						if ($row3['e_vis'] == 0 && $row3['e_auth'] != $_SESSION['u_id']){
						// only lets the author view the event
						}
						else { // everyone can see it
						echo '<br><a href="index.php?mainaction=event&sid='.$row3['e_id'].'">'.substr($row3['e_sub'],0,10.).'...'.'</a>';
						}
					}
					$sql = "SELECT u_bdate, u_name FROM users WHERE DayOfMonth(u_bdate) = '".date('j', $doit3)."' AND Month(u_bdate) = '".date('m', $doit3)."'-1 ";
				if($result3 = mysqli_query($link, $sql)){}
				//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
				$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.ucfirst($row3['u_fname']).'';
					}
				}
				else {
				$sql = "SELECT u_bdate, u_name FROM users WHERE DayOfMonth(u_bdate) = '".date('j', $doit3)."' AND Month(u_bdate) = '".date('m', $doit3)."'-1 ";
				if($result3 = mysqli_query($link, $sql)){}
				//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
				$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						echo '<br>BDAY for <br>'.ucfirst($row3['u_fname']).'';
					}
					$sql = "SELECT e_date, e_id, e_vis, e_auth, e_sub FROM events WHERE DayOfMonth(e_date) = '".date('j', $supercount2)."' AND Month(e_date) = '".date('m', $supercount2)."' ";
					if($result3 = mysqli_query($link, $sql)){}
					//$result3 = mysql_query($query3) or die (mysql_error()."Sweet query dieded!!!!");
					$numofrows3 = mysqli_num_rows($result3);
					for($c = 0; $c < $numofrows3; $c++) { // 
						$row3 = mysqli_fetch_array($result3);
						if ($row3['e_vis'] == 0 && $row3['e_auth'] != $_SESSION['u_id']){
						// only lets the author view the event
						}
						else { // everyone can see it
						echo '<br><a href="index.php?mainaction=event&sid='.$row3['e_id'].'">'.substr($row3['e_sub'],0,10.).'...'.'</a>';
						}
					}
				}
				echo '</td>';
				$doit++;
			}
	}
	$i++;
}
?>
</tr>
</table>
<?php 
//echo '$doit ='.$doit.'&nbsp;  $day1 (Firstday of month) = '.$day1.'<br>'; // echoing some vars so i can figure out why its breaking
//echo '$thenow = '.$thenow.' $startday = '.$startday.' $do2 = '.$do2;
?>