<?php
echo '<br>';

echo '<form action="process.php" method="post" name="motd">';
echo '<input type="hidden" name="action" value="motd">';
if (isset($sid)){
	$sql = "SELECT * FROM motd WHERE m_id = ".$sid;
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die ('motd query failed'. mysql_error() );
	$row = mysqli_fetch_array($result);
	echo '<input type="Hidden" name="update" value="yes">';
	echo '<input type="Hidden" name="sid" value="'.$sid.'">';
}
$fixed = str_replace("&gay", "'", $row['m_body']);
echo 'Message of the Day<br><br><textarea rows="15" cols="75" name="body">'.(isset($sid) ? $fixed : '').'</textarea><br><input type="submit">';
echo '</form>';
?>