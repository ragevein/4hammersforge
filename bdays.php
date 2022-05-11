
<?php

if (isset($_SESSION['login'])){
switch ($sort){
	case "f_name":
	if ($order == DESC){
	$sort = 'f_name DESC';
	}
	else {
	$sort = 'f_name Asc';
	}
	break;
	
	case "l_name":
	if ($order == DESC){
	$sort = 'l_name DESC';
	}
	else {
	$sort = 'l_name Asc';
	}
	break;
	
	case "b_day":
	if ($order == DESC){
	$sort = 'b_day DESC';
	}
	else {
	$sort = 'b_day Asc';
	}
	break;
	case "age":
	$sort = 'age Asc';
	break;
	case "sex":
	if ($order == DESC){
	$sort = 'sex DESC';
	}
	else {
	$sort = 'sex Asc';
	}
	break;
	default:
	$sort = 'l_name Asc';
	}

$sql = "SELECT * FROM birthday ORDER BY $sort";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die (mysql_error()."Query failed");
$numofrows = mysqli_num_rows($result);

echo '<TABLE border="0" width="750" align="center" cellpadding="4" cellspacing="2">';
// echo '<TR style="border: 1px solid #000;"><td colspan="7">'.$numofrows.' records in the database: <b>'.$currentdb.'</td>';
echo '<TR style="border: 1px solid #000;" bgcolor="#999999"><TD width=75><a href="'.$PHP_SELF.'&sort=l_name';
 if ($sort == 'l_name Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">Last Name</a></TD><TD width=75>';

echo '<a href="'.$PHP_SELF.'&sort=f_name';
 if ($sort == 'f_name Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">First Name</a></TD><TD width=75><a href="'.$PHP_SELF.'&sort=b_day" class="nav">BirthDay</a></TD>';
echo '<TD width=50><a href="'.$PHP_SELF.'&sort=b_day';
 if ($sort == 'b_day Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">Age</a></TD><TD width=75><a href="'.$PHP_SELF.'&sort=sex';
 if ($sort == 'sex Asc'): ;
 echo '&order=DESC';
 endif;
echo '" class="nav">Sex</a></TD><td></td></TR>';
for($i = 0; $i < $numofrows; $i++) {
    $row = mysqli_fetch_array($result); //get a row from our result set
    if($i % 2) { //this means if there is a remainder
        echo '<TR bgcolor="#333333">';
    } else { //if there isn't a remainder we will do the else
        echo '<TR bgcolor="#000000">';
    }
	if ($subaction == edit && $row['id'] == $sid){
		
			 echo '<form action="process.php" method="post" name="bday">
			 		<input type="hidden" name="action" value="bday">
					<input type="hidden" name="sub_action" value="update">
			 		<input name="id" type="Hidden" value="'.$row['id'].'">
					
					<TD><input type="Text" name="l_name" accept="text/plain" maxlength="75" size="13" value="'.$row['l_name'].'"></TD>
					<TD><input type="Text" name="f_name" accept="text/plain" maxlength="75" size="13" value="'.$row['f_name'].'"></TD>
					<TD>
					M <select name="month" size="1">';
					$phpdate = strtotime( $row['b_day'] );
					//$bdate1 = date( 'm', $phpdate1);
					$bm = date( 'm', $phpdate);
					for ($m = 1; $m <= 12; $m++){
						echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
					}
					echo '</select>
					D	<select name="day" size="1">';
					$bd = date( 'd', $phpdate);
						for ($d = 1; $d <= 31; $d++){
  						echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
						}
					echo '</select>
					Y <select name="year" size="1">';
					$by = date( 'Y', $phpdate);
						for ($y = 1910; $y <= 2012; $y++){
  						echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>
					</TD>
					<TD></TD>
					<TD>
					<select name="sex" size="1">
					<option value="Male" '.($row['sex'] == 'Male' ? 'selected' : '').'>Male</option>
					<option value="Female" '.($row['sex'] == 'Female' ? 'selected' : '').'>Female</option>
					</select>
					</TD>
					<td><input type="submit" size="25" value="SAVE"></td>
				   </form>';
	}
	else {
	$phpdate = strtotime( $row['b_day'] );
	//$a_age = ($phpdate -- date());
	//$bdate = date_format( $row['b_day'], 'Y-m-d' );
	$bdate = date( 'M-dS', $phpdate);
    echo '<TD>'.$row["l_name"].'</TD><TD>'.$row['f_name'].'</TD><TD>'.$bdate.'</TD><TD>';
	$unknown = getAge($row['b_day']);
	echo ($unknown != 31 ? $unknown : '?');
	echo '</TD><TD>'.$row['sex'].'</TD>
	<td><a href="'.$PHP_SELF.'&subaction=edit&sid='.$row['id'].'">Edit</a> | <a href="index.php?mainaction=del&sub=bday&sid='.$row['id'].'">Del</a></td>';
    echo '</TR>';
	}
}
?>  
 
  <tr bgcolor="#333333">
  <form action="process.php" method="post" name="bday">
  <input type="hidden" name="action" value="bday">
  <td> <input type="Text" name="l_name" accept="text/plain" maxlength="75" size="13"> </td>
  <td> <input type="Text" name="f_name" accept="text/plain" maxlength="75" size="13"> </td>
  <td>  M <select name="month" size="1">
<?php
	
	for ($m = 1; $m <= 12; $m++){
  	echo '<option value="'.$m.'">'.$m.'</option>'; 
	}
?>
  		</select>
		D
		<select name="day" size="1">
<?php
	
	for ($d = 1; $d <= 31; $d++){
  	echo '<option value="'.$d.'">'.$d.'</option>'; 
	}
?>
  		</select>
		Y
		<select name="year" size="1">
<?php
	
	for ($y = 1910; $y <= 2012; $y++){
  	echo '<option value="'.$y.'">'.$y.'</option>'; 
	}
?>
  		</select>
  </td>
  <td></td>
  <td> 
  		<select name="sex" size="1">
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		</select>
  </td>
  <td> <input type="submit" size="25" value="ENTER"></form> </td>
  </tr>
</table>
<?php 
}
else {
echo 'You are not Athorized to view this page! Please log in to continue!';
}
?>