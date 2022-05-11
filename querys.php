<?php
if ($sub == 'user') {
	$sql = "SELECT * FROM users WHERE u_id = ".$sid."";
	if($result = mysqli_query($link, $sql)){
		$row = mysqli_fetch_row($result);
	}
	else {
		echo 'user query failed';
	}
}
elseif ($sub == 'forum') {
$sql = "SELECT * FROM forum WHERE f_id = ".$sid."";
	if($result = mysqli_query($link, $sql)){
		$row = mysqli_fetch_row($result);
	}
	else {
		echo 'forum query failed';
	}
}
/*
elseif ($mainaction == 'profile') {
$query = "SELECT * FROM birthday WHERE id = ".$sid."";
$result = mysql_query($query) or die (mysql_error(). 'Profile bday failed');
$row = mysql_fetch_row($result);
}
*/
	$sql = "SELECT * FROM birthday ORDER BY b_date ASC";
	if($result1 = mysqli_query($link, $sql)){
		$numofrows1 = mysqli_num_rows($result1);
	}
	else {
		echo 'birthday query failed';
	}


	$sql = "SELECT * FROM users ORDER BY u_bdate ASC";
	if($result2 = mysqli_query($link, $sql)){
		$numofrows2 = mysqli_num_rows($result2);
	}
	else {
		echo 'users query failed';
	}

?>