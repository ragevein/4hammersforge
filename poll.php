<?php 
if (isset($_SESSION['login']) && $_SESSION['sec'] == 3){

		echo '';
		echo '<table cellpadding="5" cellspacing="1" background="img/header/largebg.gif" STYLE="background-repeat: no-repeat;">
		<tr><td><form action="process.php" method="post" name="poll">';
		echo '<input type="Hidden" name="action" value="poll"><input type="Hidden" name="p_date" value="'.date("Y-m-d H:i:s").'">'; // 
		echo '<input type="Hidden" name="p_auth" value="'.$_SESSION['u_id'].'">
		<input type="Hidden" name="subaction" value="poll">';
		echo 'Question: <input type="Text" size="89" name="p_question"></td></tr>'; // 
		echo '<tr><td>Leave blank if you do not have 7 options, and they will not show up.</td></tr>'; // 
		echo '<tr><td>Option 1: <input type="Text" size="25" name="p_opt1"></td></tr>'; // 
		echo '<tr><td>Option 2: <input type="Text" size="25" name="p_opt2"></td></tr>'; // 
		echo '<tr><td>Option 3: <input type="Text" size="25" name="p_opt3"></td></tr>'; // 
		echo '<tr><td>Option 4: <input type="Text" size="25" name="p_opt4"></td></tr>'; // 
		echo '<tr><td>Option 5: <input type="Text" size="25" name="p_opt5"></td></tr>'; // 
		echo '<tr><td>Option 6: <input type="Text" size="25" name="p_opt6"></td></tr>'; // 
		echo '<tr><td>Option 7: <input type="Text" size="25" name="p_opt7"></td></tr>'; // 
		echo '<tr><td>Poll End Date = '; // 
		// end date ---------------------
					// Month
					echo 'M <select name="month" size="1">';
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
		echo '</td></tr>'; // 
		echo '<tr bgcolor="#1A2431"><td align="right"><input type="Submit"></form></td></tr> ';
		echo '<tr><td><img src="img/header/spacer.gif" width="928" height="2"></td></tr></table>';
}
else {
		echo 'You should not be here. Shame shame. Your attempt has been monitored.';
}
?>