<?php 
	$query = "SELECT * FROM temp WHERE t_pass = '".$key."'";
	$result = mysqli_query($link, $query);// or die ('Ahh it effed up!');
	//echo $query;
	
	if (mysqli_num_rows($result) < 1 ){
		echo 'Error you key is invalid go away you bastard!';
	}
	else {
		$data = mysqli_fetch_array($result);
		$date_age =  time() - strtotime($data['t_time']);
		//echo 'database time: '.strtotime($data['t_time']).' unformated: '.$data['t_time'].' current unix time: '.time();
		//echo 'time since password reset request'.$date_age;
		if ($date_age > 1800 || $data['t_done'] == 1){
			
			echo 'Your password reset time has expired.  Please restart the recovery process 
			<a href="index.php?mainaction=forgot">Here</a>';
		}
		elseif ($data['t_ip'] != $ip){
			echo 'Your password reset information is invalid. Please restart the process  
			<a href="index.php?mainaction=forgot">Here</a>';
		}
		else {
			echo '<table><tr><td colspan="3">';
			if ($error == 1){
				echo 'Your passwords did not match.';
			}
			if ($error == 2){
				echo 'Your password was to short. Comon brah!';
			}
			echo '<form action="process.php" method="post">
			<input type="Hidden" name="id" value="'.$data['t_u_id'].'">
			<input type="Hidden" name="key" value="'.$key.'">
			<input type="Hidden" name="action" value="reset">
			'.$data['t_user'].', Please enter in your new password:</td></tr>
			<tr><td>Password:</td><td align="right"> <input type="Password" name="pass1" size="10"></td></tr>
			<tr><td>Reenter:</td><td align="right"> <input type="Password" name="pass2" size="10"></td></tr>
			<tr><td></td><td align="right"> <input type="Submit" value="SUBMIT"></td></tr>
			</table></form>';
		}
	}
	
?>

