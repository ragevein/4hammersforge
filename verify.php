<?php 
	$sql = "SELECT * FROM temp WHERE t_pass = '".$key."'";
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die ('Ahh it effed up!');
	$data = mysqli_fetch_array($result);
	if (mysqli_num_rows($result) < 1 ){
		echo 'Error you key is invalid go away you bastard!';
	}
	else {
		$sql = "UPDATE temp
				Set t_done = 1
				WHERE t_pass = '".$key."'";
		if($result = mysqli_query($link, $sql)){}
		//$result = mysql_query($query) or die ('Error Query Failed '.mysql_error());
		
		$sql = "UPDATE users
				SET u_sec = 2
				WHERE u_id = ".$data['t_u_id']."";
		if($result = mysqli_query($link, $sql)){}
		//$result = mysql_query($query) or die ('Error Query Failed '.mysql_error());
		if(isset($_SESSION['login'])){
		$_SESSION['sec'] = 2;
		}
			echo '<table><tr><td>';
			echo 'Thanks'.$data['t_user'].', for verifying your email.  You can now utilize the members forums.</td></tr>
			<tr><td></td></tr></table>';
	}
?>