<?php
if(!isset($subaction)){
$subaction = NULL;
}
if (!isset($_SESSION['login'])){
echo 'Please log to continue.';
}
else {
$sql = "SELECT * FROM Games WHERE g_type = 0 ORDER BY g_name";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query);
$numrows = mysqli_num_rows($result);

?>
<table cellpadding="5" cellspacing="1">
  <tr>
    <td valign="top">
	  <table cellpadding="5" cellspacing="1">
	    <tr>
		  <td colspan="7"><img src="img/header/spacer.gif" width="928" height="2"></td>
		</tr>
		<tr bgcolor="#1A2431">
		  <td><b>Game:</b></td>
		  <td><b>Developer:</b></td>	
		  <td><b>Genre:</b></td>
		  <td><b>Launch Date:</b></td>
		  <td><b>Platform:</b></td>
		  <td><b>Played:</b></td>
		  <td><b>Rating:</b></td>
		</tr>
	  	<?php
	    for($i = 0; $i < $numrows; $i++) {
	    	$rating = 0;
		    $row = mysqli_fetch_array($result); //get a row from our result set
		  	$sql = "SELECT gu_id, gu_score FROM user_games WHERE gu_gameid = ".$row['g_id']."";
		  	if($result2 = mysqli_query($link, $sql)){}
			//$result2 = mysql_query($query2);
		  	$bdt = mysqli_num_rows($result2);
		    for($g = 0; $g < $bdt; $g++){
				$urow = mysqli_fetch_array($result2);
			    $rating = $rating + $urow['gu_score'];
			}
			$rating = $rating / $bdt;
			if($i % 2) { //this means if there is a remainder
        		echo '<TR bgcolor="#1A2431">';
    		}
			else { //if there isn't a remainder we will do the else
        		echo '<TR bgcolor="#111111">';
    		}
			echo '  
		  <td><a href="index.php?mainaction=game&sid='.$row["g_id"].'" class="nav">'.$row['g_name'].'</a></td>
		  <td>'.$row['g_company'].'</td>
		  <td>'.$row['g_genre'].'</td>
		  <td>'.date("M jS Y", strtotime($row['g_ldate'])).'</td>
		  <td>'.$row['g_platform'].'</td>
		  <td align="right">'.$bdt.'</td>
		  <td align="right">'.round($rating, 1).'</td>
		</tr>'; 
		}
		if ($_SESSION['sec'] >= 2 ){

		echo '
		<tr bgcolor="#1A2431">
		  <td colspan="7">
			<table>
			  <tr>
			    <td colspan="7"><b>Add a new game:</b></td>
			  </tr>';
				echo '
			  <tr><form action="process.php" method="post">
				<input type="Hidden" name="action" value="addgame">
				<input type="Hidden" name="sub" value="user">
				<input type="Hidden" name="loc" value="games">
				<td><b>Name:</b><br><input type="text" name="name" size="20"></td>
				<td><b>Developer:</b><br><input type="text" name="company" size="20"></td>
				<td><b>Genre:</b><br>
				  <select name="genre">
					<option value="MMORPG">MMORPG</option>
					<option value="RPG">RPG</option>
					<option value="MOBA">MOBA</option>
					<option value="FPS">FPS</option>
					<option value="RTS">RTS</option>
					<option value="SANDBOX">SANDBOX</option>
					<option value="TABLE TOP">TABLE TOP</option>
				  </select>
				</td>
				<td colspan="4"><b>Launch Date:</b><br>';
					echo 'M <select name="month" size="1">';
					$phpdate = strtotime( date('Y-m-d H:i:s') );
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
						for ($y = $by; $y >= 1985; $y--){
  						echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';
					echo '
				</td>
			  </tr>
			  <tr>
				<td colspan="2"><b>Core Game: <input type="Radio" name="type" value="0"> or Expansion:</b><input type="Radio" name="type" value="1"></td>
				<td colspan="2"><b>Image: </b><input type="text" name="img" size="15"></td>
				<td colspan="2"><b>Platform:</b> 
				  <select name="platform">
					<option value="PC">PC</option>
					<option value="Console">Console</option>
					<option value="Multi Platform">Multi Platform</option>
					<option value="Table Top">Table Top</option>
					<option value="Other">Other</option>
				  </select>
				</td>
			  </tr>
			  <tr>
			    <td valign="TOP" colspan="4"><b>Description:</b><br><textarea name="desc" cols="65" rows="5"></textarea></td>
				<td colspan="2" align="center"><input type="submit"></td>
			  </tr>
	  	    </table>	
		  </td>
	    </tr>';
		}
			  ?>
	    
	  
	</td>
  </tr>

  <tr>
    <td align="center" colspan="2"></td>
  </tr>
</table>
<?php
}
?>