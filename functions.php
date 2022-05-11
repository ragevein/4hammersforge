<?php
function getAge( $p_strDate ) {
    list($Y,$m,$d)    = explode("-",$p_strDate);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function replace($fstring){
    $fstring = str_replace("&ut", $_SESSION['login'], $fstring);
    $fstring = str_replace("&ak", "Attackers Kingdom", $fstring);
    $fstring = str_replace("&dk", "Defenders Kingdom", $fstring);
    $fstring = str_replace("&ap", "'", $fstring);
    return $fstring;
}

function logged(){
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
global $PHP_SELF;
echo '<table cellpadding="0" cellspacing="0" width="%100"><tr><td align="center">
<form action="'.$PHP_SELF.'" method="post" name="logout">
<input type="Hidden" name="action" value="logout">
Welcome '.ucfirst($_SESSION['login']).'
<input type="Submit" class="slider" value="Log Out"></form></td></tr>';
				$sql = "SELECT * FROM messages WHERE m_date > '".$_SESSION['old_date']."' && m_view = 0 && m_target = '".$_SESSION['u_id']."'";
				if($result = mysqli_query($link, $sql)){}
				//$result = mysqli_query($wtf) or die(mysqli_error(). 'Admin Function');
					$numrows = mysqli_num_rows($result);
					if ($numrows > 0){
					$_SESSION['msg'] = 1;
					echo '<tr><td align="right"><a href="index.php?mainaction=msg" class="blue">'.$numrows.' New messages</a></td></tr>';
					}
                    else { 
                        $sql = "SELECT u_coin, u_kingdom FROM users WHERE u_id = '".$_SESSION['u_id']."' ";
		                $result = mysqli_query($link, $sql);
			            $info = mysqli_fetch_array($result);
                        echo '<tr><td align="center">Kingdom of '.$info['u_kingdom'].'</td></tr>';
			            echo '<tr><td align="center">'.$info['u_coin'].' gold</td></tr>';
                        echo '<tr><td align="center"><a href="index.php?mainaction=checkin"><button class="slider" alt="hello">Check In</button></a></td></tr>';
                    }
echo '</table>';
//$sql = "Update users SET u_time = '".date('Y-m-d H:i:s')."' Where u_id = '".$_SESSION['u_id']."'";
//$time_log = mysqli_query("Update users SET u_time = '".date('Y-m-d H:i:s')."' Where u_id = '".$_SESSION['u_id']."'") or die (mysqli_error()."user time update query failed");
	if($result = mysqli_query($link, $sql)){
		//echo 'true';
	}
	else {
		//echo $sql.''; I think this is broken
	}
}

function login(){
global $PHP_SELF;

echo '<a href="https://www.4hammersforge.com/index.php?mainaction=signup" class="nav2">SIGNUP</a>&nbsp;&nbsp;or &nbsp;<a href="https://www.4hammersforge.com/index.php?mainaction=login" class="nav2">LOGIN</a>';
}

function process(){
global $PHP_SELF;
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
extract($_REQUEST);
$hash = hash('sha256', $u_pass); /// creates a 64 char for the password, one way encryption
$sql = "select * from users where u_name = '".$u_name."' and u_pass = '".$hash."'";
//echo $sql;
	if($result = mysqli_query($link, $sql)){}
	if (mysqli_num_rows($result) == 1){
		$row = mysqli_fetch_array($result);
		$_SESSION['login'] = $u_name;
		$_SESSION['sec'] = $row['u_sec'];
		$_SESSION['u_id'] = $row['u_id'];
		$_SESSION['u_pass'] = $row['u_pass'];
		$_SESSION['old_date'] = $row['u_time'];
		$_SESSION['stay'] = 0;
		$_SESSION['guest'] = 0;
        if ($row['u_sex'] == 1){
            $_SESSION['pro'] = 'his';
        }
        elseif ($row['u_sex'] == 2) {
            $_SESSION['pro'] = 'her';
        }
        else {
            $_SESSION['pro'] = 'it';
        }
		$_SESSION['kingdom'] = $row['u_kingdom'];
		$sql = "UPDATE users SET u_ip = '".getenv('REMOTE_ADDR')."' WHERE u_id = ".$row['u_id'];
		if($result = mysqli_query($link, $sql)){}
			if ($remember == 'yes'){
			$sql = "UPDATE users 
			SET u_logged = 1
			WHERE u_id = ".$row['u_id'];
			if($result = mysqli_query($link, $sql)){}
			$_SESSION['stay'] = 1;
			}
		logged();
	}
	else {
		echo '<br>Your username and or password was invalid!  ';
		echo '<a href="'.$PHP_SELF.'?action=login">GO Back</a>';
	}
	
}

function time_since($original) {
    // array of time period chunks
    $chunks = array(
        array(60 * 60 * 24 * 365 , 'year'),
        array(60 * 60 * 24 * 30 , 'month'),
        array(60 * 60 * 24 * 7, 'week'),
        array(60 * 60 * 24 , 'day'),
        array(60 * 60 , 'hr'),
        array(60 , 'min'),
    );
    
    $today = time(); /* Current unix time  */
    $since = $today - $original;
    
    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
        
        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];
        
        // finding the biggest chunk (if the chunk fits, break)
        if (($count = floor($since / $seconds)) != 0) {
            // DEBUG print "<!-- It's $name -->\n";
            break;
        }
    }
    
    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
    
    if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];
        
        // add second item if it's greater than 0
        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
    }
    return $print;
}

function generatePassword ($length = 12)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }

function create_thumbnail($image_type, $image_width, $image_height, $temp_dir, $thumb_path, $thumb_width, $thumb_height){
    switch($image_type){
        case 'image/jpeg';
            $img =      imagecreatefromjpeg($temp_dir);
            $thumb =    imagecreatetruecolor($thumb_width, $thumb_height);
                        imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height);
                        imagejpeg($thumb, $thumb_path, 100);


        break;
        case 'image/png';
            $img =      imagecreatefrompng($temp_dir);
            $thumb =    imagecreatetruecolor($thumb_width, $thumb_height);
                        imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height );
                        imagepng($thumb, $thumb_path, 100);

        break;
        case 'image/gif';
            $img =      imagecreatefromgif($temp_dir);
            $thumb =    imagecreatetruecolor($thumb_width, $thumb_height);
                        imagecopyresized($thumb, $img, 0, 0, 0, 0, $thumb_width, $thumb_height, $image_width, $image_height );
                        imagegif($thumb, $thumb_path, 100);

        break;
    }

}
// update peoples rank when they level up
function rankcheck($rank,$exp,$sid){
    $srank = floor($exp/100+1);
    if ($rank < $srank){ // if current rank is less then exp /100 then update rank to appropriate level
        $level_up = ++$rank;
        $link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
        $sql = "UPDATE users SET u_rank = ".$level_up." WHERE u_id = ".$sid."";
        //return $sql;
        if($result = mysqli_query($link, $sql)){
            $print = '<br>Congrats! You leveled up to Rank '.$level_up;
            return $print;
        }
    } 
}
?>