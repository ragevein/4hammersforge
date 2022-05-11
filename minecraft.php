<table>
<tr bgcolor="#1A2431"><td><br>
<h1>The New Minecraft Project Page!</h1> <p class="green">Things have come a long way.  You can now add a note and save your zoomed in area - almost working.</p></td></tr>
<?php
$sql = "SELECT m_id FROM mineloc ";
if ($result = mysqli_query($link, $sql)){
	$mk = mysqli_num_rows($result);
}
$sql = "SELECT m_id FROM mineloc WHERE m_dem = 0";
if ($result = mysqli_query($link, $sql)){
	$mo = mysqli_num_rows($result);
}
$sql = "SELECT m_id FROM mineloc  WHERE m_dem = 1";
if ($result = mysqli_query($link, $sql)){
	$mn = mysqli_num_rows($result);
}
$sql = "SELECT m_id FROM mineloc  WHERE m_dem = 2";
if ($result = mysqli_query($link, $sql)){
	$me = mysqli_num_rows($result);
}
if (isset($option)){// sets if we are adding a new location or updating 
	if ($option == 'update'){// Update vars
		$sql = "SELECT * FROM mineloc WHERE m_id = '$sid'";
		if ($result = mysqli_query($link, $sql)){
			$data = mysqli_fetch_array($result);
		}
	}
}
else{
	$option = 'view';
}

echo '<tr bgcolor="#1A2431"><td colspan="2">';
if (!isset($world)){
	$world = '1';
}

	if ($option == 'view'){
		echo 'Add a new world: (coming soon, it can be a single player map or Hardcore and any world really)';

	}
	elseif ($option == 'update'){
		echo 'Updating:';
	}
	else {
		echo 'Inserting a new place of interest:';
	}
echo '';
if ($option == 'view'){

}
//-------------------------------------- Insert or Update form area ---------------------------------------------------------------------------
else {
	echo '<form action="process.php" method="post" name="mineloc">';
		echo '<br><br>';
		echo '<input type="Hidden" name="action" value="mineloc">';
		echo '<input type="Hidden" name="loc" value="mine">';
		if ($option == 'update'){ 
			// --------------------------update variables---------------------------------------------------------------------------------------
			echo '<input type="Hidden" name="option" value="update">';
			echo '<input type="Hidden" name="id" value="'.$sid.'">';
			$desc = str_replace("&gay", "'", $data['m_desc']); // removes &gay and puts in ''
			$name = str_replace("&gay", "'", $data['m_name']);
		}
		else { 
			// ------------------------- adding a new location --------------------------------------------------------------------------------
			echo '<input type="Hidden" name="option" value="add">';
		}
		echo '<input type="Hidden" name="owner" value="'.$_SESSION['u_id'].'">';
		// ----------------------------- Dimension infor --------------------------------------------------------------------------------------
		echo ' Name of this location: <input name="name" type="text" size="25" maxlength="50" '.($option == 'update'  ? 'value="'.$name.'"' : '').' required> Demension: 
		<select name="dem" id="dem">
		<option value="0" '.($data['m_dem'] == 0 ? 'selected' : '').'>Overworld</option>
		<option value="1" '.($data['m_dem'] == 1 ? 'selected' : '').' >Nether</option>
		<option value="2" '.($data['m_dem'] == 2 ? 'selected' : '').'>End</option></select>
		<br><br>Select Map <select name="map" id="map">';//
		// ----------------------------- pull up the different maps from minemap table --------------------------------------------------------
		$sql = "SELECT m_id, m_name, m_desc FROM minemap ";
		if ($result = mysqli_query($link, $sql)){
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result);
				echo '<option value="'.$row['m_name'].'" title="'.$row['m_desc'].'">'.$row['m_name'].'</option>';
			}
		}
		echo '</select> (Just the one for now, I may add options for single player or other maps)<br><br>';
		echo '<select name="type" id="type">';
		// ----------------------------- pull up the location types from minetype table -------------------------------------------------------
		$sql = "SELECT t_id, t_name FROM minetype ORDER BY t_name";
		if ($result = mysqli_query($link, $sql)){
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result);
				echo '<option value="'.$row['t_id'].'" '.($data['m_type'] == $row['t_id'] ? 'selected' : '').'>'.$row['t_name'].'</option>';
			}
		}
		echo '<option value="0">Other</option>';
		echo '</select> (Select the type of location ) Importance: 3 being high 0 being low <select name="rel" id="rel">
		<option value="0" '.($data['m_rel'] == 0 ? 'selected' : '').'>0</option>
		<option value="1" '.($data['m_rel'] == 1 ? 'selected' : '').'>1</option>
		<option value="2" '.($data['m_rel'] == 2 ? 'selected' : '').'>2</option>
		<option value="3" '.($data['m_rel'] == 3 ? 'selected' : '').'>3</option></select>
		<br><br>
		<input type="radio" id="0" name="public" value="0" '.($option == 'view' ? 'checked' : '').($data['m_public'] == 0 ? 'checked' : '').'><label for="0">Public:</label> 
		<input type="radio" id="1" name="public" value="1" '.($data['m_public'] == 1 ? 'checked' : '').'><label for="1">Private:</label> SCREENSHOT (coming soon perhaps)<br><br>';
		$desc = str_replace("&gay", "'", $data['m_desc']);//-------- replaces the '' -------------------
		$name = str_replace("&gay", "'", $data['m_name']);//-------- replaces the '' -------------------
		echo 'X <input type="text" name="x" size="6" value="'.$data['m_x'].'" required> Y (optional) <input type="text" name="y" size="6" value="'.$data['m_y'].'"> Z <input type="text" name="z" size="6" value="'.$data['m_z'].'" required><br><br>
		<textarea rows="5" cols="95" name="desc" tabindex="2">'.($option == 'update' ? $desc : 'Description').'</textarea>';
		echo '<br><input type="Submit" tabindex="3" '.($option == 'update' ? 'value="UPDATE"' : 'value="INSERT"').'></form>';
		echo '</td></tr> ';
}
		echo '<tr bgcolor="#1A2431"><td colspan="3" height="2"><img src="img/header/spacer.gif" width="938" height="2"></td></tr>';
		echo '<tr bgcolor="#1A2431"><td></td><td></td><td></td></tr>';
		//  -----------------------------------------------------------------------------------------------------------------------------
		//----------------------------  pull up location entrys need to add inner join for map type to display ----------------------------
		//  -----------------------------------------------------------------------------------------------------------------------------

		if (!isset($dem)){// brings up overworld locations by default
			$dem = 0;
		}
		echo '<tr><td colspan="2"><table width=100% cellpadding="5" cellspacing="2"><tr bgcolor="#1A2431"><td colspan="8">
		<table><tr><td colspan="4">Minecraft Forever Server (cliffs1 seed)IP:162.221.117.40:25565 running last backup 12/4/2021 </td></tr>
		<tr><td colspan="4">View Maps <a href="index.php?mainaction=mcmap&dem=0&world='.$world.'" class="blue2">The Overworld</a> - <a href="index.php?mainaction=mcmap&dem=1&world='.$world.'" class="blue2">The Nether</a>- <a href="index.php?mainaction=mcmap&dem=2&world='.$world.'" class="blue2">The End</a>
		- <a href="index.php?mainaction=minecraft&option=add" class="blue2">Add</a> a new place of interest to Cliffs1</td></tr>
		<tr><td '.($dem == 0 ? 'bgcolor="black"' : '').'><a href="index.php?mainaction=minecraft&dem=0" '.($dem == 0 ? 'class="green2"' : 'class="blue2"').'>Overworld</a></td>
		<td '.($dem == 1 ? 'bgcolor="black"' : '').'><a href="index.php?mainaction=minecraft&dem=1" '.($dem == 1 ? 'class="green2"' : 'class="blue2"').'>Nether</a></td>
		<td '.($dem == 2 ? 'bgcolor="black"' : '').'><a href="index.php?mainaction=minecraft&dem=2" '.($dem == 2 ? 'class="green2"' : 'class="blue2"').'>End</a></td>
		<td>'.$mk.' total records '.$mo.' in the overworld '.$mn.' in the nether '.$me.' in the end</td></tr></table>';
			
			echo '</td></tr><tr bgcolor="#1A2431"><td> Name</td><td>Type</td><td>X</td><td>Y</td><td> Z</td><td> Description:</td><td>Submitted By</td></tr>';
			$sql = "SELECT * FROM mineloc INNER JOIN users ON mineloc.m_owner = users.u_id LEFT JOIN minetype ON mineloc.m_type = minetype.t_id WHERE mineloc.m_dem = ".$dem." AND mineloc.m_public = 0";
			if ($result = mysqli_query($link, $sql)){
			for ($i = 0; $i < mysqli_num_rows($result); $i++){
				$row = mysqli_fetch_array($result);
					if($i % 2) { // alternates row color
       					 echo '<tr bgcolor="#1A2431">';
   	 				} else {
       	 				echo '<tr bgcolor="#111111">';
    				}	
				$desc = str_replace("&gay", "'", $row['m_desc']);
				$name = str_replace("&gay", "'", $row['m_name']);
				$phpdate = strtotime($row['m_date']);
				$date = date( 'M jS', $phpdate);//<td nowrap>'.$date.'</td>
				echo '<td nowrap><a href="index.php?mainaction=minecraft&option=update&sid='.$row['m_id'].'" class="green">'.$name.'</a></td><td>'.$row['t_name'].'</td>
				<td>'.$row['m_x'].'</td><td>'.$row['m_y'].'</td><td>'.$row['m_z'].'</td>';
				$ttrunc = (strlen($desc) > 40) ? substr($desc, 0, 40) . '...' : $desc; // truncate thread text so column doesn't get dumb
				echo '<td>'.$ttrunc.'</td><td>'.$row['u_name'].'</td>';
				echo '</tr>';
			}
		}
		echo '</table></td></tr></table>';

?>