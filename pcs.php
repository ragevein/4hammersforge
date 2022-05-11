<?php 
	session_name('4hammers');
	session_start();
	extract($_REQUEST);
	$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
	$sql = "INSERT INTO likes (l_type, l_auth, l_ref_id) VALUES (".$type.", ".$_SESSION['u_id'].", ".$id." )";
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die('claw entry error'.$query.'<br>'.mysql_error());
	header( 'Location: index.php?mainaction='.$loc.'&id='.($sid == $id ? $id : $sid).'&cat='.$cat.''  ) ;
?>