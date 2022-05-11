<table>
  <tr>
    <td rowspan="5"><img src="img/header/spacer.gif" width="20" height="5"></td>
	<td><img src="img/header/spacer.gif" width="770" height="2" border="0"></td>
  </tr>
<?php 
// insert event form
if (isset($_SESSION['login']) && $_SESSION['sec'] >= 2){
	if($subaction == 'insert'){			

		echo '<tr><td><form action="process.php" method="post" name="event">';
		echo '<input type="Hidden" name="action" value="event">
		<input type="Hidden" name="e_date" value="'.date("Y-m-d H:i:s").'">';
		echo '<input type="Hidden" name="e_auth" value="'.$_SESSION['u_id'].'">
		<input type="Hidden" name="subaction" value="event">';
		echo 'Event Subject: <br>
		<input type="Text" size="65" name="sub" accept="text/plain"></br>'; // 
		echo 'Event Details: <br><textarea rows="9" cols="75" name="body"></textarea><br>
		Category <select name="cat" size="1"><option value="Appointment">Appointment</option>
		<option value="Party">Party</option>
		<option value="Lan Party">Lan Party</option>
		<option value="Online Party">Online Party</option>
		<option value="Kegger">Kegger</option>
		<option value="Rave">Rave</option>
		<option value="Camp Trip">Camp Trip</option>
		<option value="Vegas Run">Vegas Run</option>
		<option value="Other">Other</option></select></td></tr>'; // 
		
		echo '<tr><td>
			<table>
			  <tr>
			    <td>Date and time when event takes place:</td><td><img src="../img/header/spacer.gif" width="20" height="5"></td>
				<td rowspan="2">Choose who can view ur event : <br>
				All: <input type="Radio" name="vis" value="1"> You Only: <input type="Radio" name="vis" value="0"> 
				Specific Members Coming Soon</td></tr>'; // 
		// end date ---------------------
					// Month
					echo '<tr><td>M <select name="month" size="1">';
					$bm = date('n');
					for ($m = 1; $m <= 12; $m++){
						echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
					}
					echo '</select>';
					// Day
					echo 'D	<select name="day" size="1">';
					$bd = date('j');
						for ($d = 1; $d <= 31; $d++){
  						echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
						}
					echo '</select>';
					// Year
					echo 'Y <select name="year" size="1">';
						for ($y = 1910; $y <= date("Y"); $y++){
  						echo '<option value="'.$y.'" '.($y == date("Y") ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';
					// Hour
					echo 'H	<select name="hour" size="1">';
						for ($h = 0; $h <= 24; $h++){
  						echo '<option value="'.$h.'" '.($h == 0 ? 'selected' : '').'>'.$h.'</option>'; 
						}
					echo '</select>';
					// min
					echo 'Min	<select name="min" size="1">';
						for ($i = 0; $i <= 60; $i++){
  						echo '<option value="'.$i.'" '.($i == 0 ? 'selected' : '').'>'.$i.'</option>'; 
						}
					echo '</select>';
		// ------------------------------
		echo '</td></tr></table></td></tr>'; // 
		echo '<tr><td><img src="../img/header/spacer.gif" width="20" height="5"><input type="Submit"></form></td></tr> ';
	}
	elseif ($subaction == 'edit' && isset($_SESSION['login']) && $_SESSION['sec'] >= 2){
	// edit event 
			$sql = "SELECT * FROM events WHERE e_id =".$sid." ";
			if($result = mysqli_query($link, $sql)){}
			//$result3 = mysql_query($query3) or die ("Sweet query dieded!!!!");
			$row3 = mysqli_fetch_array($result3);
		if ($_SESSION['u_id'] == $row3['e_auth'] or $_SESSION['sec'] == 3){
			echo '<form action="process.php" name="event" method="post">
			<input type="Hidden" name="e_id" value="'.$row3['e_id'].'">
			<input type="Hidden" name="action" value="event">
			<input type="Hidden" name="subaction" value="edit">';
			echo '<tr><td>Editing Event on '.date('D M jS Y', strtotime($row3['e_date'])).' at '.date('g:i a', strtotime($row3['e_date'])).'<br>';
			echo 'Event Subject: <br>
		<input type="Text" size="65" name="sub" accept="text/plain" value="'.$row3['e_sub'].'"></br>'; // 
		echo 'Event Details: <br><textarea rows="9" cols="75" name="body">'.$row3['e_body'].'</textarea><br>
		Category <select name="cat" size="1">
		<option value="Appointment" '.($row3['e_cat'] == 'Appointment' ? 'selected' : '').'>Appointment</option>
		<option value="Party" '.($row3['e_cat'] == 'Party' ? 'selected' : '').'>Party</option>
		<option value="Lan Party" '.($row3['e_cat'] == 'Lan Party' ? 'selected' : '').'>Lan Party</option>
		<option value="Online Party" '.($row3['e_cat'] == 'Online Party' ? 'selected' : '').'>Online Party</option>
		<option value="Kegger" '.($row3['e_cat'] == 'Kegger' ? 'selected' : '').'>Kegger</option>
		<option value="Rave" '.($row3['e_cat'] == 'Rave' ? 'selected' : '').'>Rave</option>
		<option value="Camp Trip" '.($row3['e_cat'] == 'Camp Trip' ? 'selected' : '').'>Camp Trip</option>
		<option value="Vegas Run" '.($row3['e_cat'] == 'Vegas Run' ? 'selected' : '').'>Vegas Run</option>
		<option value="Other" '.($row3['e_cat'] == 'Other' ? 'selected' : '').'>Other</option>
		</select></td></tr>'; // 
		
		echo '<tr><td>
			<table>
			  <tr>
			    <td bgcolor="#000000">Date and time when event takes place:</td><td><img src="../img/header/spacer.gif" width="20" height="5"></td>
				<td rowspan="2" bgcolor="#000000">Choose who can view ur event : <br>
				All: <input type="Radio" name="vis" value="1" '.($row3['e_vis'] == 1 ? 'checked' : '').'> 
				You Only: <input type="Radio" name="vis" value="0" '.($row3['e_vis'] == 0 ? 'checked' : '').'> 
				Specific Members Comming Soon</td></tr>'; // 
		// end date ---------------------
					// Month
					// break down the data base date into tiny bites
					$bm = date('n', strtotime($row3['e_date']));
					echo '<tr><td>M <select name="month" size="1">';
					for ($m = 1; $m <= 12; $m++){
						echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
					}
					echo '</select>';
					// Day
					echo 'D	<select name="day" size="1">';
					$bd = date('j', strtotime($row3['e_date']));
						for ($d = 1; $d <= 31; $d++){
  						echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
						}
					echo '</select>';
					// Year
					$ym = date('Y', strtotime($row3['e_date']));
					echo 'Y <select name="year" size="1">';
						for ($y = 1910; $y <= date("Y"); $y++){
  						echo '<option value="'.$y.'" '.($y == $ym ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';
					// Hour
					$hm = date('H', strtotime($row3['e_date']));
					echo 'H	<select name="hour" size="1">';
						for ($h = 0; $h <= 24; $h++){
  						echo '<option value="'.$h.'" '.($h == $hm ? 'selected' : '').'>'.$h.'</option>'; 
						}
					echo '</select>';
					// min
					$mm = date('i', strtotime($row3['e_date']));
					echo 'Min	<select name="min" size="1">';
						for ($i = 0; $i <= 60; $i++){
  						echo '<option value="'.$i.'" '.($i == $mm ? 'selected' : '').'>'.$i.'</option>'; 
						}
					echo '</select>';
		// ------------------------------
		echo '</td></tr></table></td></tr>'; // 
		echo '<tr><td><img src="../img/header/spacer.gif" width="20" height="5"><input type="Submit"></form></td></tr>';
		}
		else {
		header( 'Location: index.php?mainaction=error&id=1');
		}
	}
	else {
			// view event 
			$sql = "SELECT * FROM events WHERE e_id =".$sid." ";
			if($result3 = mysqli_query($link, $sql)){}
			//$result3 = mysql_query($query3) or die ("Sweet query dieded!!!!");
			$row3 = mysqli_fetch_array($result3);
			echo '<tr><td>Veiwing Event on '.date('D M jS Y', strtotime($row3['e_date'])).' at '.date('g:i a', strtotime($row3['e_date']));
			if ($_SESSION['u_id'] == $row3['e_auth'] or $_SESSION['sec'] == 3){
			echo ' <a href="index.php?mainaction=event&subaction=edit&sid='.$sid.'">Edit</a>';
			}
			echo '<br>Subject: '.$row3['e_sub'].'<br>Details: '.$row3['e_body'].'<br>'.($row3['e_vis'] == 1 ? 'Viewable by all':'Viewable by you only').'<br>';
			
			echo '</td></tr>';
	}
}
else {
		echo 'You should not be here. Shame shame. Your attempt has been monitored.';
}
?>

</table>