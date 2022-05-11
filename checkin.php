<?php 	$short_date = date('Y-m-d'); ?>
<div class="container">
    <div class="fancy-header">
    Check In
    </div>
</div>
<div class="container">
    <div class="card">
        <div class="top"><h2>Navagation</h2></div>
    <table width="235" id="check-nav">
        <tr><td align="center"><a href="index.php?mainaction=rules"><button class="slider">Rules</button></a></td></tr>
        <tr><td align="center"><a href="index.php?mainaction=lewt&lewtaction=lewtchest"><button class="slider">Exploration</button></a></td></tr>
        <tr><td align="center"><a href="index.php?mainaction=lewt&lewtaction=pick"><button class="slider" id="pick">Looting</button></a></td></tr>
        <tr><td align="center"><a href="index.php?mainaction=qlog"><button class="slider">Quest Log</button></a></td></tr>
        <tr><td align="center"><button class="slider" id="open-button" alt="Smack Talk">Smack Talk</button></td></tr>
    </table><br>
    <div class="top"><h2>SEASON 2 Leader board</h2></div> <!-- <img src="img/chest.png" alt="Lewt Chest!" id="chest"> -->
    
        <?php 
        $sql = "SELECT u_id, u_name, u_rank, u_kingdom, u_coin, u_exp, r_name FROM users INNER JOIN ranks ON users.u_rank = ranks.r_id WHERE u_coin > 0 ORDER BY u_coin DESC LIMIT 15 ";
        $query = mysqli_query($link, $sql);
        $count = mysqli_num_rows($query);
        for ($i = 0; $i < $count; $i++){
            $row = mysqli_fetch_array($query);
            echo '<a href="index.php?mainaction=profile&sid='.$row['u_id'].'" class="cool">'.$row['r_name'].' '.$row['u_name'].'</a> <span class="gcolor">'.$row['u_coin'].'g</span><BR>';
            echo $row['u_kingdom'].'  <span class="gcolor">'.$row['u_exp'].'exp</span><br>';
        }
        ?>
    </div>
	<div class="card">
    <?php 
    $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.t_init_user = users.u_id WHERE 
    t_type = 0 AND t_season = 2 ORDER BY t_id DESC LIMIT 15";
    $result = mysqli_query($link, $sql);
        echo '<div class="top"><h2>Exploration Events</h2></div>';
	    echo '<table><tr><td width="125" class="colHead">User</td><td width="50" class="colHead">Gold</td><td width="100" class="colHead">Roll</td>
        <td width="150" class="colHead">Scenario</td><td width="50" class="colHead">EXP</td><td class="colHead">Time since</td></tr>';
	    for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		    $row = mysqli_fetch_array($result);
		    echo '<tr><td>'.$row['u_name'].'</td>
            <td>'.$row['t_amount'].' g</td>';
            if ($row['t_scenario'] == 0) {
                echo '<td id="dieDetails">-<span class="dieInfo">'.$row['t_dice'].'</span></td>';
                echo '<td>-</td>';
            }
            else {
                $sql = "SELECT * FROM game_events WHERE ge_id = ".$row['t_scenario']." ";
                $info = mysqli_query($link,$sql);
                $scene = mysqli_fetch_array($info);
                if ($row['t_roll'] == 2){
                    $t_roll = 'Doubles';
                }
                elseif ($row['t_roll'] == 3){
                    $t_roll = 'Triples';
                }
                elseif ($row['t_roll'] == 4){
                    $t_roll = 'Quadruples';
                }
                elseif ($row['t_roll'] == 5){
                    $t_roll = 'Quintuples';
                }
                elseif ($row['t_roll'] == 6){
                    $t_roll = 'Sextuples';
                }
                elseif ($row['t_roll'] == 7){
                    $t_roll = 'Septuples';
                }
                $fdesc = str_replace("&ap", "'", $scene['ge_desc']);
                echo '<td id="dieDetails">'.$t_roll.'<span class="dieInfo">'.$row['t_dice'].'</span></td>';
                echo '<td '.($row['t_success'] == 1 ? 'class="fail"':'').' id="desc">'.substr(replace($fdesc),0,15).'<span class="descinfo">'.$scene['ge_desc'].'</span></td>';
                //
            }
            echo '<td>'.$row['t_exp'].'</td>';
            echo '<td width="200">'.time_since(strtotime($row['t_stamp'])).'</td></tr>';
	    }
	echo '</table>';
    
?>
    </div>
    <div class="card">
    <?php
    $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.t_init_user = users.u_id WHERE t_type > 0 AND t_season = 2
     ORDER BY t_id DESC LIMIT 10";
    $result = mysqli_query($link, $sql);
        echo '<div class="top"><h2>PVP Events</h2></div>';
	    echo '<table><tr><td width="80" class="colHead">Attacker</td><td width="80" class="colHead">Defender</td><td width="30" class="colHead">Roll</td>
        <td width="75" class="colHead">Stolen</td><td class="colHead">Scenario</td><td width="30" class="colHead">EXP</td><td width="160" class="colHead">Time since</td></tr>';
	    for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		    $row = mysqli_fetch_array($result);
		    echo '<tr><td>'.$row['u_name'].'</td>';
           
            $asql = "SELECT u_name FROM users WHERE u_id = ".$row['t_affect_user']."";
            $affect = mysqli_query($link, $asql);
            $affect = mysqli_fetch_array($affect);
           
            echo '<td>'.$affect['u_name'].'</td>';
            
            $sql2 = "SELECT * FROM game_events WHERE ge_id = ".$row['t_scenario']." ";
            $info = mysqli_query($link,$sql2);
            $scene = mysqli_fetch_array($info);
            $fdesc = str_replace("&ap", "'", $scene['ge_desc']);
            echo '<td id="dieDetails">'.$row['t_roll'].'<span class="dieInfo">'.$row['t_dice'].'</span></td>';
            echo '<td>'.$row['t_amount'].' g</td>';
            echo '<td '.($row['t_success'] == 1 ? 'class="fail"':'').' id="desc">'.substr(replace($fdesc),0,15).'<span class="descinfo">'.$scene['ge_desc'].'</span></td>';
            echo '<td>'.$row['t_exp'].'</td>';
            echo '<td>'.time_since(strtotime($row['t_stamp'])).'</td></tr>';
	    }
	echo '</table>';
    ?>
        <div class="top"><h2>Goals Completed Today</h2></div>
        <?php
    $sql = "SELECT * FROM goal_data INNER JOIN users ON goal_data.g_user = users.u_id WHERE g_date = '".$short_date."' ORDER BY g_id DESC LIMIT 10";
    $result = mysqli_query($link, $sql);
	    echo '<table><tr><td width="80" class="colHead">User</td><td width="80" class="colHead">Goal Type</td><td width="30" class="colHead">Gold</td></tr>';
	    for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		    $row = mysqli_fetch_array($result);
		    echo '<tr><td>'.$row['u_name'].'</td>';
            if ($row['g_type'] == 0){
                $gtype = 'Daily';
            }
            if ($row['g_type'] == 1){
                $gtype = 'Weekly';
            }
            if ($row['g_type'] == 2){
                $gtype = 'Monthly';
            }
            if ($row['g_type'] == 3){
                $gtype = 'Yearly';
            }
            echo '<td>'.$gtype.'</td>';
            echo '<td>'.$row['g_coin'].'</td>';
	    }
	echo '</table>';
    ?>

    </div>
    <div class="card" id="smack">
        <div class="top"><h2>Smack Talk</h2></div>
        <?php
            $sql = "SELECT * FROM messages INNER JOIN users ON messages.m_sender = users.u_id WHERE m_target = 0 ORDER BY messages.m_date DESC LIMIT 10" ;
            $query = mysqli_query($link,$sql);
            $count = mysqli_num_rows($query);
            for ($i = 0; $i < $count; $i++){
                echo '<div class="item">';
                $row = mysqli_fetch_array($query);
                $body = str_replace("&ap", "'", $row['m_body']);
                echo $body.'<br>by '.$row['u_name']. '</div>';
            }
        ?>
    </div>
</div>

<dialog class="modal" id="modal">
<div><form action="process.php" method="post" name="smack">
<input type="hidden" name="action" value="msg">
<input type="hidden" name="location" value="checkin">
<?php
echo '<input type="Hidden" name="id" value="'.$SESSION_['u_id'].'">';
echo '<input type="Hidden" name="target" value="0">';
?>Message to all: (currently no edit or delete options)<br>
<textarea rows="9" cols="77" name="body" tabindex="2"></textarea><br>
<input type="Submit" value="SEND"></form><button class="slider" id="close-button">Cancel</button>
</dialog>

<script src="checkin.js"></script>