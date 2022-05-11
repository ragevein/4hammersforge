
<!--
Test Map info<br><br>

North is higher the - Z value  -100 is south of -500<br>

East is higher the + x value - is west<br><br>

<table><tr><td></td><td>N -</td><td></td></tr>
<tr><td></td><td> </td><td></td></tr>
<tr><td>W -</td><td> </td><td>E +</td></tr>
<tr><td></td><td></td><td></td></tr>
<tr><td></td><td>S +</td><td></td></tr></table>
-->

<table name="main"><tr><td><table background="img/map/mapbg2.jpg" fixed class="i">
<?php 
$uid = $_SESSION['u_id'];
// check DB for mc_settings if record exists load the default paramaters
$query = "SELECT * FROM mc_settings WHERE mc_world = '$world' AND mc_u_id = '$uid' AND mc_dem = '$dem'";
//echo $query;
if ($result = mysqli_query($link, $query)){
	$vsetting = mysqli_fetch_array($result);
	// record = 1 set the paramaters
	if (!isset($div)){
		$div = $vsetting['mc_res'];
		$sx = $vsetting['mc_sx'];
		$sz = $vsetting['mc_sz'];
		$mc_set_id = $vsetting['mc_id'];
	}

}
$testz = $sz;
if (!isset($sx)){
$sx = -15;
}
if (!isset($sz)){
$sz = -15;
}
if (!isset($div)){
$div = 800;
}
if (!isset($x)){
$x = $sx;
}
if (!isset($z)){
$z = $sz;
}
$xend = $x+31;
$zend = $z+31;

if (!isset($world)){
$world = '1';
}
if (!isset($dem)){
$dem = '0';
}
if ($dem == '0'){
	echo '<tr><td colspan="31" class="teep" bgcolor="#000"><b><a href="index.php?mainaction=minecraft" class="blue2">Back</a> Viewing The Overworld - <a href="index.php?mainaction=mcmap&dem=1&div='.($div/2). '" class="blue2">Nether Map</a> - <a href="index.php?mainaction=mcmap&dem=2" class="blue2">End Map</a></b></td></tr>';
}
elseif ($dem == '1'){
	echo '<tr><td colspan="31" class="teep" bgcolor="#000"><b><a href="index.php?mainaction=minecraft" class="blue2">Back</a> Viewing The Nether - <a href="index.php?mainaction=mcmap&dem=0" class="blue2">Overworld Map</a> - <a href="index.php?mainaction=mcmap&dem=2" class="blue2">End Map</a></b></td></tr>';
}
elseif ($dem == '2'){
	echo '<tr><td colspan="31" class="teep" bgcolor="#000"><b><a href="index.php?mainaction=minecraft" class="blue2">Back</a> Viewing The End</b> - <a href="index.php?mainaction=mcmap&dem=0" class="blue2">Overworld Map</a> - <a href="index.php?mainaction=mcmap&dem=1&div='.($div/2). '" class="blue2">Nether Map</a></td></tr>';
}
echo '<tr><td colspan="31" class="teep" bgcolor="#000">';


echo '';


?>
</td></tr>
<tr><td colspan="31"><img src="img/25x1spacer.png" width="800" height="1"></td></tr>
<?php
//$loc = 0;
	$sql = "SELECT * FROM mineloc INNER JOIN users ON mineloc.m_owner = users.u_id LEFT JOIN minetype ON mineloc.m_type = minetype.t_id WHERE mineloc.m_world = '$world' AND mineloc.m_dem = '$dem' AND mineloc.m_public = 0";
	//echo $sql;
	if ($result = mysqli_query($link, $sql)){
		$records = mysqli_num_rows($result);	
		//echo '<tr><td colspan="50">Records '.$records.'</td></tr>';
	}

for ($i = 1; $i <= 31; $i++){
	echo '<tr>';

	for ($e = 1; $e <= 31; $e++){
		echo '<td width="20" height="20" border="1" cellpadding=0>';
		if (0 == $x AND 0 == $z AND $dem == 0){
		echo '<img src="img/map/spawn.png" border="0" width="25" height="25" title="Spawn Area 0,0">';
		}
		if ($result = mysqli_query($link, $sql)){
			$records = mysqli_num_rows($result);	
			for ($k = 0; $k < $records; $k++){
				$row = mysqli_fetch_array($result);
				$rx = round($row['m_x']/$div);
				$rz = round($row['m_z']/$div);
				if ($rx == $x AND $rz == $z){
					$name = str_replace("&gay", "'", $row['m_name']);
					//$title = '';// work this to show multi locals
					if (!isset($tag)){// if more then 2 places are close enough its only going to show one of them need to do something about that
						$tag = 1;
						if ($row['t_img'] != NULL){
						echo '<a href="index.php?mainaction=minecraft&option=update&sid='.$row['m_id'].'" ><img src="img/map/'.$row['t_img'].'" border="0" width="25" height="25" title="'.$name.' '.$row['m_x'].' '.$row['m_z'].'" style=”float: right; padding: 0px 0px 0px 0px;” class="i"></a>';
						}
						else {
						echo '<a href="index.php?mainaction=minecraft&option=update&sid='.$row['m_id'].'" ><img src="img/map/other.png" border="0" width="25" height="25" title="'.$name.' '.$row['m_x'].' '.$row['m_z'].'"  style=”float: right; padding: 0px 0px 0px 0px;” class="i"></a>';
						}
						
					}
					//echo 'x';
				}
			}
			unset($tag);
		}
		//echo ''.$x.''.$z.'';
		echo '</td>';
		$x++;
		if ($x == $xend){// reset the cords at end of each row
			$x = $sx;
		}
		
	}
	$z++;
	if ($z == $zend){// reset the cords at end of each row
		$z = -15;
	}
	echo '</tr>';
}
echo '</tr>
</table></td>';

// --------------------------- Navagation Area -------------------------------------
echo'
<td valign="top">
	<table><tr><td align="center"> <b class="b4">~ Side Panel ~</b></td></tr>
<tr><td align="center" border="1"> <b class="12">NAVAGATION</b></td></tr>
<tr><td align="center"><table><tr><td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.($div/2).'&sx='.$sx.'&sz='.$sz.'&world='.$world.'" class="blue">IN</a> </td>
<td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.($div*2).'&sx='.$sx.'&sz='.$sz.'&world='.$world.'" class="blue">OUT</a> </td></tr></table></td></tr>
<tr><td align="center">
	<table><tr><td></td><td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.$div. '&sx='.$sx.'&sz='.($sz-15).'&world='.$world.'" class="blue3">&uarr;<br>N</a></td><td></td></tr>
	<tr><td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.$div. '&sx='.($sx-15).'&sz='.$sz.'&world='.$world.'" class="blue3">&larr; W</a></td><td></td>
<td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.$div. '&sx='.($sx+15).'&sz='.$sz.'&world='.$world.'" class="blue3">E &rarr;</a></td></tr>
	<tr><td></td><td><a href="index.php?mainaction=mcmap&dem='.$dem.'&div='.$div. '&sx='.$sx.'&sz='.($sz+15).'&world='.$world.'" class="blue3">S<br>&darr;</a></td><td></td></tr>
<tr><td colspan="2"><a href="index.php?mainaction=mcmap&dem='.$dem.'&world='.$world.'&div=800" class="blue">&nbsp;&nbsp;&nbsp; RESET</a></td><td>
<form method="post" action="process.php" name="settings"><input type="hidden" name="action" value="mc_settings">
<input type="hidden" name="id" value="'.$mc_set_id.'">
<input type="hidden" name="owner" value="'.$uid.'"><input type="hidden" name="world" value="'.$world.'">
<input type="hidden" name="dem" value="'.$dem.'"><input type="hidden" name="res" value="'.$div.'"><input type="hidden" name="sx" value="'.$sx.'"><input type="hidden" name="sz" value="'.$sz.'">
<input type="submit" value=" SAVE "></form>
</td></tr></table>
</td></tr>';
// -------------------------- Note area ------------------------------------
echo '<tr><td align="center"><b class="12"> Quick Reference </b></td></tr>';
$uid = $_SESSION['u_id'];
$sql = "SELECT * FROM mc_notes WHERE mc_note_owner = '$uid'";
if ($result = mysqli_query($link, $sql)){
	$value = mysqli_num_rows($result);
	if ($value == 1){
	$note = mysqli_fetch_array($result);
	echo '<form method="post" action="process.php" name="Note"><input type="hidden" name="action" value="unote"><input type="hidden" name="owner" value="'.$uid.'">
	<tr><td align="center"><b class="green"><textarea rows="20" cols="20" name="info" tabindex="2">'.$note['mc_note_info'].'</textarea></b></td></tr>
	<tr><td align="center"><b class="green"><input type="submit" value="UPDATE"></b></td></tr>
	</form>';
	}
	else {
	echo '<form method="post" action="process.php" name="Note"><input type="hidden" name="action" value="inote"><input type="hidden" name="owner" value="'.$uid.'">
	<tr><td align="center"><b class="green"><textarea rows="20" cols="20" name="info" tabindex="2"></textarea></b></td></tr>
	<tr><td align="center"><b class="green"><input type="submit" value="ADD NOTE"></b></td></tr>
	</form>';
	}
}

// --------------------------- Tips Area --------------------------------
$sql = "SELECT * FROM mc_tips LEFT JOIN users ON mc_tips.mc_tip_owner = users.u_id WHERE  mc_tips.mc_tip_cat = 0 ORDER BY RAND() LIMIT 1";
if ($result = mysqli_query($link, $sql)){
$tip = mysqli_fetch_array($result);
echo '
<tr><td align="center"><b class="12">1.18 Tips and Changes</b></td></tr>
<tr><td align="center"><b class="green">'.$tip['mc_tip_info'].'</b></td></tr>';
}
?>
</table></td></tr></table>










