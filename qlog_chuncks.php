// Group quests -------------------------------------------
	?>
		<script src="script.js"></script> 

	<?php 
		echo '<div class="container">
		<div class="card">
		<div class="space">
		<div class="head">Group Quests<span class="eight"> (Under construction)</span></div>';
		$sql = "SELECT * FROM goal LEFT JOIN users ON goal.g_user = users.u_id WHERE goal.g_user != '".$_SESSION['u_id']."' AND goal.g_group = 1";
		if($result = mysqli_query($link, $sql)){}
		$numrows = mysqli_num_rows($result);
		$ydone = 0;
		$ytotal = $numrows;// makes a var for total quests
		for($c = 0; $c < $numrows; $c++) { 
		$row = mysqli_fetch_array($result);
			$g_name = str_replace("&gay", "'", $row['g_name']);
			$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
			// need to query your current goals hat match the type and add hidden inputs for that data
			// group_parent, group_date, group_type, group_user, group_owner, group_name
			echo '
			<form type="multipart" method="post" name="goal" action="process.php">
			<input type="hidden" name="action" value="g_link">
			<input type="hidden" name="g_joinie" value="'.$row['g_id'].'">
			<input type="hidden" name="group_parent" value="'.$row['g_id'].'">
			<input type="hidden" name="group_date" value="'.date('Y-m-d h:m:s').'">
			<input type="hidden" name="group_user" value="'.$_SESSION['u_id'].'">
			<input type="hidden" name="group_owner" value="'.$row['g_user'].'">
			<input type="hidden" name="group_name" value="'.$row['g_name'].'">
			<input type="hidden" name="g_parent" value="'.$row['g_parent'].'">
			
			<div class="data"><a href="#" class="blue">'.$ttrunc.'</a> by '.$row['u_name'].'
			<input type="hidden" name="g_id" value="'.$row['g_id'].'"></div><br>
			<div class="data">';
			//check to see you are already linked to group
			$query = "SELECT * FROM goal WHERE g_user = ".$_SESSION['u_id']." AND g_type = ".$row['g_type']." AND g_parent = ".$row['g_parent']." AND g_cat = ".$row['g_cat']." ";
			$result1 = mysqli_query($link, $query) or die ('Error Query Failed goal upate '.mysqli_error($link));
			$info = mysqli_fetch_array($result1);
			if ($info['g_parent'] == $row['g_parent']){
				$g_name = str_replace("&gay", "'", $info['g_name']);
				$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
				echo 'Linked to '. $ttrunc; 
			}
			else {
				// gather info from own goals data
				$sql2 = "SELECT * FROM goal WHERE g_user = ".$_SESSION['u_id']." AND g_type = ".$row['g_type']." AND g_parent = 0 AND g_cat = ".$row['g_cat']." ";
				if($result2 = mysqli_query($link, $sql2)){}
				$numrows2 = mysqli_num_rows($result2);
				echo '<select name="g_joiner">';
				for($i = 0; $i < $numrows2; $i++){
					$row2 = mysqli_fetch_array($result2);
					echo '<option value="'.$row2['g_id'].'">'.$row2['g_name'].'</option>';
				}
			echo '</select><input type="submit" value="Join">';
			}
			//echo $info['g_parent'].$row['g_parent'];
				echo '</div></form>';
		}//"index.php?mainaction=qlog&link='.$row['g_id'].'"      <b class="peep">'.$sql2.'</b>
		echo '</div></div>
		
		<div class="card">
		<div class="space">
		<div class="head">Group Quests<span class="eight"> (Under construction)</span></div>';
		$sql = "SELECT * FROM goal LEFT JOIN users ON goal.g_user = users.u_id WHERE goal.g_user != '".$_SESSION['u_id']."' AND goal.g_group = 1";
		if($result = mysqli_query($link, $sql)){}
		$numrows = mysqli_num_rows($result);
		$ydone = 0;
		$ytotal = $numrows;// makes a var for total quests
		for($c = 0; $c < $numrows; $c++) { 
		$row = mysqli_fetch_array($result);
			$g_name = str_replace("&gay", "'", $row['g_name']);
			$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
			// need to query your current goals hat match the type and add hidden inputs for that data
			// group_parent, group_date, group_type, group_user, group_owner, group_name
			echo '
			<form type="multipart" method="post" name="goal" action="process.php">
			<input type="hidden" name="action" value="g_link">
			<input type="hidden" name="g_joinie" value="'.$row['g_id'].'">
			<input type="hidden" name="group_parent" value="'.$row['g_id'].'">
			<input type="hidden" name="group_date" value="'.date('Y-m-d h:m:s').'">
			<input type="hidden" name="group_user" value="'.$_SESSION['u_id'].'">
			<input type="hidden" name="group_owner" value="'.$row['g_user'].'">
			<input type="hidden" name="group_name" value="'.$row['g_name'].'">
			<input type="hidden" name="g_parent" value="'.$row['g_parent'].'">
			
			<div class="data"><a href="#" class="blue">'.$ttrunc.'</a> by '.$row['u_name'].'
			<input type="hidden" name="g_id" value="'.$row['g_id'].'"></div><br>
			<div class="data">';
			//check to see you are already linked to group
			$query = "SELECT * FROM goal WHERE g_user = ".$_SESSION['u_id']." AND g_type = ".$row['g_type']." AND g_parent = ".$row['g_parent']." AND g_cat = ".$row['g_cat']." ";
			$result1 = mysqli_query($link, $query) or die ('Error Query Failed goal upate '.mysqli_error($link));
			$info = mysqli_fetch_array($result1);
			if ($info['g_parent'] == $row['g_parent']){
				$g_name = str_replace("&gay", "'", $info['g_name']);
				$ttrunc = (strlen($g_name) > 16) ? substr($g_name, 0, 16) . '...' : $g_name; // truncate thread text	
				echo 'Linked to '. $ttrunc; 
			}
			else {
				// gather info from own goals data
				$sql2 = "SELECT * FROM goal WHERE g_user = ".$_SESSION['u_id']." AND g_type = ".$row['g_type']." AND g_parent = 0 AND g_cat = ".$row['g_cat']." ";
				if($result2 = mysqli_query($link, $sql2)){}
				$numrows2 = mysqli_num_rows($result2);
				echo '<select name="g_joiner">';
				for($i = 0; $i < $numrows2; $i++){
					$row2 = mysqli_fetch_array($result2);
					echo '<option value="'.$row2['g_id'].'">'.$row2['g_name'].'</option>';
				}
			echo '</select><input type="submit" value="Join">';
			}
			//echo $info['g_parent'].$row['g_parent'];
				echo '</div></form>';
		}//"index.php?mainaction=qlog&link='.$row['g_id'].'"      <b class="peep">'.$sql2.'</b><svg class="svg"> <circle cx="70" cy="70" r="70"></circle><circle cx="70" cy="70" r="70"></circle></svg>
			 
		echo '
        <div class="number" data-val="90">
          <h2> <span class="eight"></span></h2>
        </div>
  <div>Total: '.$ytotal.'</div></div></div>
  </div>';

  	//----------------  Group graph -----------------------------------------------------------------------------------------------------
	echo '<h2>Group Tracker</h2>';
    //------------------ fancy Group graph----------------------------------------------------------------------------------------------------
        $kday = $theday - $dayofweek;
        $gparent = 1;
        $w_start = date('Y-m-d', mktime(0,0,0, $thismonth,$kday,$curyear));
        $w_end = date('Y-m-d', mktime(0,0,0, $thismonth,$kday+6,$curyear));
        echo '<table valign="top" align="left" bgcolor="#000000" border="0" cellpadding="3" cellspacing="1" width="500">
        <tr>
          <td colspan="7">Weekly progress: '.$w_start.' through '.$w_end.'</td>
        </tr>
        <tr bgcolor="#1A2431">';
    for ($i=1; $i <= 7; $i++){// show the days of the week and date
        if (!isset($ll)){
        $ll = 1;
        }
        $block = mktime(0,0,0, $thismonth,$kday+$ll-1,$curyear);
        $vday = date('D jS', $block);
        echo '<td align="center" width=50>'.$vday.'</td>';
        $ll++;
    }
        echo '</tr><tr>';
    for ($i=1; $i <= 7; $i++){//$sql = "SELECT * FROM goal LEFT JOIN users ON goal.g_user = users.u_id WHERE goal.g_user != '".$_SESSION['u_id']."' AND goal.g_group = 1";
        if (!isset($dd)){
        $dd = 1;
        }
        $block = mktime(0,0,0, $thismonth,$kday+$dd-1,$curyear);
        $dd++;
        $dday = date('Y-m-d', $block);
        $vday = date('j', $block);
        $sql = "SELECT * FROM goal_data INNER JOIN goal ON goal_data.g_parent = goal.g_id WHERE goal_data.g_date = '".$dday."' AND goal_data.g_user = '".$_SESSION['u_id']."' AND goal_data.g_type = 0 AND goal.g_group = 1 AND goal.g_parent = '".$gparent."'";
        if($result = mysqli_query($link, $sql)){}
        $row = mysqli_fetch_array($result);
        $numrows = mysqli_num_rows($result);
        echo '<td align="center">';
        $daybar = $numrows;
        $blkbar = 100 - $daybar;
        //echo round($daybar);
        for($c = 0; $c < $numrows; $c++) { 
        echo '
        <div>
            '.$row['g_user'].'
        </div>';
        }
        
        echo '</td>';
    }
        echo'</tr></table>';

    //---------------- End graph---------------------------------------------------------------------------------------------------------

    if (isset($progress)) {
        $sql = "SELECT * FROM goal WHERE g_user = '".$_SESSION['u_id']."' AND g_id = ".$id." ";
        if($result = mysqli_query($link, $sql)){
        
        }
        $data = mysqli_fetch_array($result);// g_type 0 = daily 1 = weekly 2 = monthly 3 = yearly
        echo '<BR>
        Viewing goal '.$data['g_name'].' ( '.$data['g_desc'].' )<BR> <BR>';
        if ($data['g_type'] == 0){// viewing weekly progress
            // setting date vars to 
        
        
        
        //echo 'The day '.$theday.' dayofweek '.$dayofweek.' Negday '.$negday.' Sday '.$sday.' This month '.$thismonth.' Current Year '.$curyear.'<br>';
        
        //$startday = mktime(0,0,0, $thismonth,1-$sday,$curyear);
        //$c = 1;
        $sql = "SELECT * FROM goal_data WHERE g_parent = ".$id." ";//sql statment '.$sql.' '.date('d F, Y (l)').
        $gdata = mysqli_fetch_array($sql);
        $records = mysqli_num_rows($sql);
            echo'
            <table valign="top" align="center" bgcolor="#000000" cellpadding="3" cellspacing="1">
                <tr>
                  <td colspan="7">This weeks progress thedayvar = '.$theday.' Records '.$records.' ID '.$id.' </td>
                </tr>
                <tr bgcolor="#1A2431">
                  <td align="center" width=100>Sun</td>
                  <td align="center" width=100>Mon</td>
                  <td align="center" width=100>Tues</td>
                  <td align="center" width=100>Wed</td>
                  <td align="center" width=100>Thur</td>
                  <td align="center" width=100>Fri</td>
                  <td align="center" width=100>Sat</td>
                </tr>
                <tr>';
    
                echo '<form enctype="multipart/form-data" action="process.php" method="post" name="gdata">';
                $stuff = array();// building array for my process page
                    $ent = 1;
                    for ($i = 0; $i < 7; $i++){
                        
                        $block = mktime(0,0,0, $thismonth,$kday+$i,$curyear);
                        $dday = date('Y-m-d', $block);
                        $vday = date('j', $block);
                        echo '<td>';
                        echo $vday;
                        echo '<input type="hidden" name="action" value="gdata">';
                        echo '<input type="hidden" name="g_date" value="'.$dday.'">';
                        echo '<input type="hidden" name="parent_id" value="'.$id.'">';
                        $sql = "SELECT g_parent, g_id, g_date, g_type FROM goal_data WHERE g_date = '$dday' AND  g_parent = $id ";
                        if($result = mysqli_query($link, $sql)){
                            $goalinfo = mysqli_fetch_array($result);
                            echo '<input type="checkbox" '.($dday == $goalinfo['g_date'] ? 'checked' : '').' name="box" value="yes">';
                            echo '<input type="hidden" name="g_id" value="'.$goalinfo['g_id'].'">';
                            echo '<input type="hidden" name="g_type" value="'.$goalinfo['g_type'].'">';
                            echo $dday.' block var '.$block;
                        }
                        else {
                            echo '<input type="checkbox" name="box" value="yes">';
                            echo '<input type="hidden" name="g_id" value="">';
                            echo '<input type="hidden" name="g_type" value="0">';
                            echo $dday.' block var '.$block;
                        }
                        //array_push($stuff, $dday);
                            //do your array entries here
                        echo '</td>';
                    $ent++;
                    }
                //print_r($stuff);
                  echo '
                </tr>
                <tr><td colspan="7">'.$sql.'</td></tr>
                <tr>
                  <td colspan="7"><input type="Submit" Value="Update"></td>
                </tr></form>
                <tr>
                 <td colspan="7">';
                
                    echo'
                 </td>
                </tr>
            </table>';
            
            
        }
    }
    else{
    // <a href="index.php?mainaction=thread&cat=1151" class="green">here</a>

    .svg {
        position: relative;
        width: 175px;
        height: 175px;
    }
    
    .svg circle {
        width: 95%;
        height: 95%;
        stroke-width: 10;
        fill: none;
        stroke:rgba(255, 255, 255, 0.05);
        stroke-linecap: round;
        transform: translate(5px,5px);
    
    }
    
    .svg circle:nth-child(2) {
        stroke-dasharray: 440px;
        stroke-dashoffset: 0px;
        stroke: #ffffff;
    }
    
    .card:nth-child(1) .svg circle:nth-child(2){
        stroke-dashoffset: var(--graph1);
    }
        
    .card:nth-child(1):hover .svg circle:nth-child(2){
            animation: animate-circle 1s linear forwards
        }
        @keyframes animate-circle{
            0% {
                stroke-dashoffset: 440px;
            }
    
            100% {
                stroke-dashoffset: calc(440px - (440px * 90) / 100);
            }
    }
    
    .card:nth-child(2) .svg circle:nth-child(2) {
        stroke-dashoffset: calc(440px - (440px * 90) / 100);
    }
    
    .card:nth-child(2):hover .svg circle:nth-child(2){
            animation: animate-circle 1s linear forwards
        }
        @keyframes animate-circle{
            0% {
                stroke-dashoffset: 440px;
            }
    
            100% {
                stroke-dashoffset: calc(440px - (440px * 90) / 100);
            }
    }
    
        .number {
            position: absolute;
            left: 83px;
            bottom: 65px;
            justify-content: center;
        }
    
    .number h2 {
        color: #ffffff;
        font-weight: 700;
        font-size: 50px;
    }
    
div.animation {
    width: 100px;
    height: 100px;
    background-color: red;
    position: relative;
    animation-name: example;
    animation-duration: 4s;
    animation-delay: 2s;
}

@keyframes example {
    0% {
        background-color: red;
        left: 0px;
        top: 0px;
    }

    25% {
        background-color: yellow;
        left: 200px;
        top: 0px;
    }

    50% {
        background-color: blue;
        left: 200px;
        top: 100px;
    }

    75% {
        background-color: green;
        left: 0px;
        top: 100px;
    }

    100% {
        background-color: red;
        left: 0px;
        top: 0px;
    }
}    