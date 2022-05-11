
<div class="fancy-header">New Admin page</div>
<div class="container">

<h1>Events</h1><button class="open-button">Add Event</button><BR>
<?php
    $sql = "SELECT * FROM game_events";
	$query = mysqli_query($link, $sql);
	$result = mysqli_num_rows($query);
		for ($i = 1; $i <= $result; $i++){ 
			$row = mysqli_fetch_array($query);
            $fbody = str_replace("&ap", "'", $row['ge_body']);
            $fsuccess = str_replace("&ap", "'", $row['ge_success']);
            $ffail = str_replace("&ap", "'", $row['ge_fail']);
            $fdesc = str_replace("&ap", "'", $row['ge_desc']);

            $types = array('Treasure Chest','Aggressive','Diplomatic','Trade');
            $item = 0;
            for ($inc=0; $inc < count($types); $inc++){
                if ($row['ge_type'] == $item){
                    $type = $types[$item];
                }
                $item = $item+1;         
            }
            // function replace() to swap out the code in string to proper persons
			echo '<div class="card"> <a href="index.php?mainaction=admin&edit=true&sid='.$row['ge_id'].'">Description: '.$fdesc.'</a> <br>Type: '.$type.'<br> Body: '.substr(replace($fbody),0,45.).'... 
            <br> Success MSG: '.substr(replace($fsuccess),0,45.).'... <br> Fail MSG: '.substr(replace($ffail),0,45.).'... <br><br></div>';
		}   
?>
<!---------------------add form -------------------------------------->
<dialog class="modal" id="modal"><div><form enctype="multipart/form-data" action="process.php" method="post" name="events">
<input type="hidden" name="action" value="game_events">
<input type="Hidden" name="MAX_FILE_SIZE" value="5000000">
<input type="hidden" name="action" value="game_add_event">
<?php
//------------------- update vars ---------------------------------------
if ($edit == 'true') {
    $sql = "SELECT * FROM game_events WHERE ge_id = ".$sid."";
	$query = mysqli_query($link, $sql);
    $focus = mysqli_fetch_array($query);
    echo '<input type="hidden" name="update" value="true">';
    echo '<input type="hidden" name="ge_id" value="'.$sid.'">';
    $fbody = str_replace("&ap", "'", $focus['ge_body']);
	$fsuccess = str_replace("&ap", "'", $focus['ge_success']);
	$ffail = str_replace("&ap", "'", $focus['ge_fail']);
	$fdesc = str_replace("&ap", "'", $focus['ge_desc']);
    $enter = 'UPDATE';
}
else {
    $enter = 'ADD';
}
    echo '<input type="hidden" name="ge_uid" value="'.$_SESSION['u_id'].'">';
    echo '<br>Description: <input type="Text" name="ge_desc" value="'.$fdesc.'">';
    echo ' Level value: <select name="ge_level">';
    for ($m = 1; $m <= 10; $m++){
        echo '<option value="'.$m.'" '.($m == $focus['ge_level'] ? 'selected' : '').'>'.$m.'</option>';
    }
    echo '</select> Type: <select name="ge_type">';
    $types = array('Treasure Chest','Aggressive','Diplomatic','Trade');
    $item = 0;
    for ($inc=0; $inc < count($types); $inc++){
        if ($row['ge_type'] == $item){
            $type = $types[$item];
        }
        echo '<option value="'.$item.'" '.($item == $focus['ge_type'] ? 'selected' : '').'>'.$types[$item].'</option>';
        $item = $item+1;         
    }
    echo '
    </select>
    <select name="ge_dice">
        <option value="2"'.(2 == $focus['ge_dice'] ? 'selected' : '').'>2 of a kind</option>
        <option value="3"'.(3 == $focus['ge_dice'] ? 'selected' : '').'>3 of a kind</option>
        <option value="4"'.(4 == $focus['ge_dice'] ? 'selected' : '').'>4 of a kind</option>
        <option value="5"'.(5 == $focus['ge_dice'] ? 'selected' : '').'>5 of a kind</option>
        <option value="6"'.(6 == $focus['ge_dice'] ? 'selected' : '').'>6 of a kind</option>
    </select>';
    echo "<br> &ut = YOU &ak = 'attackers kingdom' &dk = 'defenders kingdom' &g = x gold &pro = his/her <br> will automatically set the proper stuff when pulled up<br>";


echo '<h3>Body:</h3>';
echo '<textarea name="ge_body" cols="80" rows="10">'.$fbody.'</textarea><br>';
echo '<h3>Success:</h3>';
echo '<textarea name="ge_success" cols="80" rows="10">'.$fsuccess.'</textarea><br>';
echo '<h3>Fail:</h3>';
echo '<textarea name="ge_fail" cols="80" rows="10">'.$ffail.'</textarea><br>';
echo '<input type="submit" value="'.$enter.'">';
?>
</form><button class="close-button">Cancel</button></div></dialog>

</div>
<!---------------------add form -------------------------------------->
<dialog class="modal" id="modal2"><div>
<form enctype="multipart/form-data" action="process.php" method="post" name="events">
<input type="hidden" name="action" value="game_events">
<input type="Hidden" name="MAX_FILE_SIZE" value="5000000">
<input type="hidden" name="action" value="game_add_event">
<?php
    echo '<input type="hidden" name="ge_uid" value="'.$_SESSION['u_id'].'">';
    echo '<br>Description: <input type="Text" name="ge_desc">';
    echo ' Level value: <select name="ge_level">';
    for ($m = 1; $m <= 10; $m++){
        echo '<option value="'.$m.'">'.$m.'</option>';
    }
    echo '</select> Type: <select name="ge_type">';
    $types = array('Treasure Chest','Aggressive','Diplomatic','Trade');
    $item = 0;
    for ($inc=0; $inc < count($types); $inc++){
        if ($row['ge_type'] == $item){
            $type = $types[$item];
        }
        echo '<option value="'.$item.'">'.$types[$item].'</option>';
        $item = $item+1;         
    }
    ?>
    </select>
    <select name="ge_dice">
        <option value="2">2 of a kind</option>
        <option value="3">3 of a kind</option>
        <option value="4">4 of a kind</option>
        <option value="5">5 of a kind</option>
        <option value="6">6 of a kind</option>
    </select>
       <br> &ut = YOU &ak = 'attackers kingdom' &dk = 'defenders kingdom' &g = x gold &pro = his/her <br> will automatically set the proper stuff when pulled up<br>
    <?php

echo '<h3>Body:</h3>';
echo '<textarea name="ge_body" cols="80" rows="10"></textarea><br>';
echo '<h3>Success:</h3>';
echo '<textarea name="ge_success" cols="80" rows="10"></textarea><br>';
echo '<h3>Fail:</h3>';
echo '<textarea name="ge_fail" cols="80" rows="10"></textarea><br>';
?>
<input type="submit" value="ADD"></form><button class="close-button">Cancel</button></div></dialog>


<script src="admin.js"></script>