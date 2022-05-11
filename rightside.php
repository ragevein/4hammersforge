
<?php
$tdate= date("l F jS");
$time = date("H:i:s A");

$date = date("Y-m-d h:i:s");
$query = "SELECT * FROM poll WHERE p_end > '".$date."'"; // is there an active poll?
$result = mysqli_query($link, $query);
$rdata = mysqli_fetch_array($result);
$rcount = mysqli_num_rows($result);
if($rcount > 0){
	$query = "SELECT * FROM poll_data WHERE pd_pollid = ".$rdata['p_id'].""; // has user voted yet?
	$result = mysqli_query($link, $query);
	$rcount = mysqli_num_rows($result);
	$vote = $rcount;
	if ($vote == 0){
		echo '<span id="notice_me"><a href="#poll"><button class="slider">NEW POLL!</button></a></span>';
	}

}

?>
<table width="250" cellpadding="5" cellspacing="4">
<?php
		// ---------------------------------------- right side
		echo '<tr><td align="center"><br><h3>'.$tdate.'<br>'.$time.'</h3><br>
			  <tr><td><h3>Developers MOTD</h3><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
			  //------------------------------------ Motd
		$sql = "SELECT * FROM motd INNER JOIN users ON motd.m_auth = users.u_id Order By m_id DESC";
		if($result = mysqli_query($link, $sql)){
		}
		//$motd = mysql_query($qmotd) or die ("guery motd failed:". mysql_error());
		$rmotd = mysqli_fetch_array($result);
		$fixed = str_replace("&ap", "'", $rmotd['m_body']);
		echo nl2br($fixed).'<br> Posted by <a href="index.php?mainaction=profile&sub=user&sid='.$rmotd['u_id'].'" class="blue"> '.$rmotd['u_name'].'</a>';
		if ($_SESSION['sec'] == 3){
			echo ' <a href="'.$unsecure.'?mainaction=motd&sid='.$rmotd['m_id'].'" class="green">Edit</a>';
		}
		echo '</td></tr>';
	if (isset($_SESSION['login'])) {
	//----------------------- Server info
		echo '<tr>
		  		<td><h3>Server Info</h3><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
		echo'	Minecraft Forever<br> 162.221.117.40:25565<br>
				Survival Valheim<br> 162.221.117.40:2456<br>
				Creative Valheim<br> 162.221.117.40:2458';
		echo '</td></tr>';
		//----------------------- Recent Posts
		echo '<tr>
		  		<td><h3>Recent Posts</h3><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
				// not sure HOW this works, but it grabs the most recent post for each forum category 
				$sql = "SELECT * FROM forum f WHERE f_date = (SELECT MAX(f_date) FROM forum WHERE f_cat = f.f_cat) AND f_dark = 0 AND f_cat != 1 ORDER BY f.f_date DESC";
				if($result = mysqli_query($link, $sql)){}
				//$result = mysql_query($query) or die('Failure bro: '.$query. '<br>'. mysql_error());
				for ($i = 0; $i < 3; $i++) {
					$row = mysqli_fetch_array($result);
					//this is necessary because thread-creating posts have a parent of 0
					if ($row['f_parent'] == "0"){
						
						$newID = $row['f_id'];
						$sub = $row['f_sub'];
					}
					else
					{
						$newID = $row['f_parent'];
						
						$sql4 = "SELECT * FROM forum WHERE f_id='".$row['f_parent']."'";
						if($result = mysqli_query($link, $sql4)){}
						//$presult = mysql_query($pquery) or die('Failure bro: '.$pquery. '<br>'. mysql_error());
						$prow = mysqli_fetch_array($result);
						$sub = $prow['f_sub'];
						$sub = str_replace("&gay", "'", $sub);
					}
					$body = $row['f_body'];
					$body = str_replace("&gay", "'", $body);
					$newCat = $row['f_cat'];
					
					$ttrunc = (strlen($sub) > 25) ? substr($sub, 0, 25) . '...' : $sub; // truncate thread text
					$btext = trim(strip_tags($body));
					//$ptrunc = (strlen($body) > 23) ? substr($body, 0, 23) . '...' : $body; // truncate post text
					$ptrunc = (strlen($btext) > 23) ? substr($btext, 0, 23) . '...' : $btext; // truncate post text
					$dquote = '"';
					echo '<a href="index.php?mainaction=vthread&id='.$newID.'&cat='.$newCat.'" class="blue">'.$ttrunc.'</a><br>';
					if ( strlen($ptrunc) > 0 )
					{
						echo $dquote.$ptrunc.$dquote.'<br>';
					}
				}
		echo '</td></tr>';
		//----------------------- Top Games
		/*echo '<tr>
		  		<td><b>Games we are Playing</b><br><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
				 // the sql statement arranges by game, averages its score, and adds up how many people are currently playing and sorts by most played 
				$query = 'SELECT gu_gameid, g_name, g_id, COUNT(*) As played, AVG(gu_score) AS gu_score FROM user_games INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE user_games.gu_status || 0 GROUP BY g_name ORDER BY played DESC, g_name';
				$result = mysql_query($query) or die('Failure bro: '.$query. '<br>'. mysql_error());
				for ($i = 0; $i < 3; $i++) {
					$row = mysql_fetch_array($result);
					echo '<a href="index.php?mainaction=game&sid='.$row["g_id"].'"  class="blue">'.$row['g_name'].'</a><br>';
					echo '<b>'.$row['played'].'</b> currently playing [Rating: <b>'.round($row['gu_score'], 1).'</b>]<br>';
				}
		echo '</td></tr>';
		*/
		// Birthdate notifier
		/*
		echo '<tr>
		  		<td><b>Birthdays in next 30 days</b><br><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
		if ($_SESSION['u_id'] == 1){
			for($i = 0; $i < $numofrows1; $i++) {
				$row1 = mysqli_fetch_array($result1);
				$phpdate1 = strtotime( $row1['b_day'] );
				$bdate3 = date("Y").'-'.date("m-d", $phpdate1);// to set it the birth year to this year for fast calculation
				$bdate2 = date( 'M dS', $phpdate1);
				//$bdate3 = date( 'Y-m-d', $phpdate1);
				$today2 = date("Y-m-d");
				$nowish = strtotime($today2);  // converts todays date into seconds
				$thenish = strtotime($bdate3); // converts subs Bday into seconds
				if (($nowish - $thenish) > -2592000 && $nowish <= $thenish){ // so -2592000 is the amount of seconds in 30 days Debuging whats going on here .$nowish.' - '.$thenish.' > -2592000 AND '.$nowish.' <= '.$thenish.'<br>'
					echo '<a href="'.$PHP_SELF.'?mainaction=calendar" class="blue">'.$row1['f_name'].' '.$bdate2.'</a><br>';
				}
			}
		}
		$nobday = 0;
		for($i = 0; $i < $numofrows2; $i++) {
			$row2 = mysqli_fetch_array($result2);
			$phpdate1 = strtotime( $row2['u_bdate'] );
			$bdate2 = date( 'M dS', $phpdate1);
			$bdate3 = date("Y").'-'.date("m-d", $phpdate1);// to set it the birth year to this year for fast calculation
			//$bdate3 = date( 'Y-m-d', $phpdate1);
			$today2 = date("Y-m-d");
			$nowish = strtotime($today2);
			$thenish = strtotime($bdate3);
			if (($nowish - $thenish) > -2592000 && $nowish <= $thenish){
				$nobday = 1;
			echo '<a href="'.$PHP_SELF.'?mainaction=calendar" class="blue">'.ucfirst($row2['u_fname']).' '.$bdate2.'</a><br>';
			}
		}
		echo '</td></tr><tr>
		  		<td><b>Events in next 30 days</b><br><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
		$sql5 = "SELECT e_date, e_id, e_sub, e_vis, e_auth FROM events";
		if($result = mysqli_query($link, $sql5)){}
		//$result3 = mysql_query($query3) or die ("Sweet query dieded!!!!");
		$numofrows3 = mysqli_num_rows($result);
			for($c = 0; $c < $numofrows3; $c++) { // 
				$row3 = mysqli_fetch_array($result);
				// new stuff
				$phpdate1 = strtotime( $row3['e_date'] );
				$edate2 = date( 'M dS', $phpdate1);
				$edate3 = date( 'Y-m-d', $phpdate1);
				$nowish = strtotime($today2);
				$thenish = strtotime($edate3);
				if ($row3['e_vis'] == 0 && $row3['e_auth'] != $_SESSION['u_id']){
				// only lets the author view the event
				}
				else { // everyone can see it
					if (($nowish - $thenish) > -2592000 && $nowish <= $thenish){
					$noeday = 1;
					echo '<a href="index.php?mainaction=event&sid='.$row3['e_id'].'" class="blue">'.substr($row3['e_sub'],0,10.).'...'.' '.$edate2.'</a><br>';
					}
				}
			}
		echo '</td></tr>';
		
		echo '<tr><td><b>Reviews</b><br><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>';
	$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id WHERE f_cat = 566 AND f_parent = 0 ORDER BY f_id DESC LIMIT 3";
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die (mysql_error());
		for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		echo '<a href="index.php?mainaction=vthread&id='.$row['f_id'].'&cat='.$row['f_cat'].'" class="blue">'.$row['f_sub'].'</a><br>';
		echo '<b class="bop">by</b> <a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="blue">'.$row['u_name'].' </a> 
		<b class="bop">'.date("M jS", strtotime($row['f_date'])).'</b><br>';
		}
		echo '</td></tr>';
		*/
		echo '
		<tr><td align="center"><h3>Countdowns</h3><img src="img/header/gray.jpg" width="230" height="1" alt=""><br>
			';
?>
<script type="text/javascript">
//######################################################################################
// Author: ricocheting.com
// Version: v2.0
// Date: 2011-03-31
// Description: displays the amount of time until the "dateFuture" entered below.

// NOTE: the month entered must be one less than current month. ie; 0=January, 11=December
// NOTE: the hour is in 24 hour format. 0=12am, 15=3pm etc
// format: dateFuture1 = new Date(year,month-1,day,hour,min,sec)
// example: dateFuture1 = new Date(2003,03,26,14,15,00) = April 26, 2003 - 2:15:00 pm

dateFuture1 = new Date(2022,09,02,0,0,0);
dateFuture2 = new Date(2022,03,15,0,0,0);

//###################################
//nothing beyond this point
function GetCount(ddate,iid){

	dateNow = new Date();	//grab current date
	amount = ddate.getTime() - dateNow.getTime();	//calc milliseconds between dates
	delete dateNow;

	// if time is already past
	if(amount < 0){
		document.getElementById(iid).innerHTML="Now!";
	}
	// else date is still good
	else{
		days=0;hours=0;mins=0;secs=0;out="";

		amount = Math.floor(amount/1000);//kill the "milliseconds" so just secs

		days=Math.floor(amount/86400);//days
		amount=amount%86400;

		hours=Math.floor(amount/3600);//hours
		amount=amount%3600;

		mins=Math.floor(amount/60);//minutes
		amount=amount%60;

		secs=Math.floor(amount);//seconds

		if(days != 0){out += days +" "+((days==1)?"d":"ds")+", ";}
		if(hours != 0){out += hours +" "+((hours==1)?"hr":"hrs")+", ";}
		out += mins +" "+((mins==1)?"m":"m")+", ";
		out += secs +" "+((secs==1)?"s":"s")+", ";
		out = out.substr(0,out.length-2);
		document.getElementById(iid).innerHTML=out;

		setTimeout(function(){GetCount(ddate,iid)}, 1000);
	}
}

window.onload=function(){
	GetCount(dateFuture1, 'countbox1');
	GetCount(dateFuture2, 'countbox2');
	//you can add additional countdowns here (just make sure you create dateFuture2 and countbox2 etc for each)
};
</script>

<?php
    //(via: http://www.code-sucks.com/code/php/template.php?tutorial=use-php-to-resize-an-image.php )
    
    $src_path = 'img/ropower.jpg'; //     <---- PUT COUNTDOWN IMAGE PATH HERE - automatically resizes
    $src_path2 = 'img/news/logo/logo37165.jpg';
    
    $src_img = imagecreatefromjpeg($src_path);
    $src_img2 = imagecreatefromjpeg($src_path2);
    
    $srcsize = getimagesize($src_path);
    $dest_x = 230;
    $dest_y = (230 / $srcsize[0]) * $srcsize[1];
    $dst_img = imagecreatetruecolor($dest_x, $dest_y);
    
    $srcsize2 = getimagesize($src_path2);
    $dest_x2 = 230;
    $dest_y2 = (230 / $srcsize2[0]) * $srcsize2[1];
    $dst_img2 = imagecreatetruecolor($dest_x2, $dest_y2);
    
    //Resize image
    imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dest_x, $dest_y, $srcsize[0], $srcsize[1]);
    imagecopyresampled($dst_img2, $src_img2, 0, 0, 0, 0, $dest_x2, $dest_y2, $srcsize2[0], $srcsize2[1]);
    
    // Save the image
    imagejpeg($dst_img, 'img/countdown_img.jpg');
    imagejpeg($dst_img2, 'img/countdown_img2.jpg');
     
    // Deletes temporary images
    imagedestroy($src_img);
    imagedestroy($dst_img);
    imagedestroy($src_img2);
    imagedestroy($dst_img2);
?>
<!-- if second countdown wanted, put here:
<img src="img/news/logo/logo37165.jpg" title="D3 Season 26"><br>
<div id="countbox2" class="twelve"></div> -->

<!-- put countdown image path in the php area above!! -->
<img src="img/countdown_img.jpg" title="Rings of Power"><br>
<div id="countbox1" class="twelve"></div>

</td></tr>
<?php 

			  // ------------------------------ poll section ---------------------------------
			  
			  echo '<tr><td><h3>Polls</h3><img src="img/header/gray.jpg" width="230" height="1" alt=""><br> ';
			   $sql = "SELECT * FROM poll WHERE p_closed = 0 AND p_end > '".date('Y-m-d H:i:s')."'";//p_end >= '".$date('Y-m-d H:i:s')."' &&            p_id = 2 
				
			  if($result = mysqli_query($link, $sql)){}
			   //$r_poll = mysql_query($q_poll) or die ("Poll query failed");
			   $count = mysqli_num_rows($result);
				if ($count == 0){
					echo 'No current polls<br>';
				}
				else {
			   for ($p = 0; $p < $count; $p++){ 
			   $row_poll = mysqli_fetch_array($result);	
			   $sql = "SELECT * FROM poll_data WHERE pd_pollid = '".$row_poll['p_id']."'";
			   if($result = mysqli_query($link, $sql)){}
			   $p_result = mysqli_query($link, $sql);
			   $votes = mysqli_num_rows($p_result);
			   		$v_opt1 = 0;
					$v_opt2 = 0;
					$v_opt3 = 0;
					$v_opt4 = 0;
					$v_opt5 = 0;
					$v_opt6 = 0;
					$v_opt7 = 0;
					$voted = 'no';
			   		for ($l = 0; $l < $votes; $l++){
						$r_votes = mysqli_fetch_array($p_result);
							if ($r_votes['pd_vote'] == 1){$v_opt1 = $v_opt1+1; }
							if ($r_votes['pd_vote'] == 2){$v_opt2 = $v_opt2+1; }
							if ($r_votes['pd_vote'] == 3){$v_opt3 = $v_opt3+1; }
							if ($r_votes['pd_vote'] == 4){$v_opt4 = $v_opt4+1; }
							if ($r_votes['pd_vote'] == 5){$v_opt5 = $v_opt5+1; }
							if ($r_votes['pd_vote'] == 6){$v_opt6 = $v_opt6+1; }
							if ($r_votes['pd_vote'] == 7){$v_opt7 = $v_opt7+1; }
							if ($r_votes['pd_userid'] == $_SESSION['u_id']){ 
							$voted = 'yes';
							}
					}

			   echo '<b>'.$row_poll['p_question'].'</b><br><b class="eight">';
			   echo '<form action="process.php" method="post" name="poll">
			   <input type="Hidden" name="action" value="poll">
			   <input type="Hidden" name="subaction" value="vote">
			   <input type="Hidden" name="p_id" value="'.$row_poll['p_id'].'">';
			   	if ($row_poll['p_opt1'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt1 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt1 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="1">'.ucfirst($row_poll['p_opt1']).' <br>';
						}
						else {
							echo $row_poll['p_opt1'].' <br>';
						}		
						echo $v_opt1.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="1">'.ucfirst($row_poll['p_opt1']).' <br>';
						}
						else {
							echo $row_poll['p_opt1'].' <br>';
						}
						echo $v_opt1.' votes<br><br>';	
					}
				} 
				if ($row_poll['p_opt2'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt2 * $multy;
					$width = ($percent / 100) * 200 ;

					if ($v_opt2 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="2">'.ucfirst($row_poll['p_opt2']).' <br>';
						}
						else {
							echo $row_poll['p_opt2'].' <br>';
						}		
						echo $v_opt2.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="2">'.ucfirst($row_poll['p_opt2']).' <br>';
						}
						else {
							echo $row_poll['p_opt2'].' <br>';
						}
						echo $v_opt2.' votes<br><br>';	
					}
		
				}
				if ($row_poll['p_opt3'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt3 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt3 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="3">'.ucfirst($row_poll['p_opt3']).' <br>';
						}
						else {
							echo $row_poll['p_opt3'].' <br>';
						}		
						echo $v_opt3.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="3">'.ucfirst($row_poll['p_opt3']).' <br>';
						}
						else {
							echo $row_poll['p_opt3'].' <br>';
						}
						echo $v_opt3.' votes<br><br>';	
					}
		
				}
				if ($row_poll['p_opt4'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt4 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt4 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="4">'.ucfirst($row_poll['p_opt4']).' <br>';
						}
						else {
							echo $row_poll['p_opt4'].' <br>';
						}		
						echo $v_opt4.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="4">'.ucfirst($row_poll['p_opt4']).' <br>';
						}
						else {
							echo $row_poll['p_opt4'].' <br>';
						}
						echo $v_opt4.' votes<br><br>';	
					}
		
				}
				if ($row_poll['p_opt5'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt5 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt5 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="5">'.ucfirst($row_poll['p_opt5']).' <br>';
						}
						else {
							echo $row_poll['p_opt5'].' <br>';
						}		
						echo $v_opt5.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="5">'.ucfirst($row_poll['p_opt5']).' <br>';
						}
						else {
							echo $row_poll['p_opt5'].' <br>';
						}
						echo $v_opt5.' votes<br><br>';	
					}
		
				}
				if ($row_poll['p_opt6'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt6 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt6 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="6">'.ucfirst($row_poll['p_opt6']).' <br>';
						}
						else {
							echo $row_poll['p_opt6'].' <br>';
						}		
						echo $v_opt6.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="6">'.ucfirst($row_poll['p_opt6']).' <br>';
						}
						else {
							echo $row_poll['p_opt6'].' <br>';
						}
						echo $v_opt6.' votes<br><br>';	
					}
		
				}
				if ($row_poll['p_opt7'] != ""){
			   		$multy = 100 / $votes;
					$percent = $v_opt7 * $multy;
					$width = ($percent / 100) * 200 ;
					if ($v_opt7 == 0){
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="7">'.ucfirst($row_poll['p_opt7']).' <br>';
						}
						else {
							echo $row_poll['p_opt7'].' <br>';
						}		
						echo $v_opt7.' votes<br><br>';
					}
					else {
						if ($voted != 'yes'){
							echo '<input type="Radio" name="p_opt" value="7">'.ucfirst($row_poll['p_opt7']).' <br>';
						}
						else {
							echo $row_poll['p_opt7'].' <br>';
						}
						echo $v_opt7.' votes<br><br>';	
					}
		
				}
			   echo '
			   '.(isset($_SESSION['login']) ? ($voted != 'yes' ? '<input type="Submit">' : 'You have already voted.<br>' ) : 'You must login to vote!<br>').'Total votes = '.$votes;
			   echo '<br>';
			   }
				}
			   echo (isset($_SESSION['login']) ? '<a href="index.php?mainaction=polls" class="blue">View All Polls</a></form>' : '').'
			   </td></tr>';
	}
?>

<tr><td><h3>Links</h3>
<img src="img/header/gray.jpg" width="230" height="1" alt=""><br>
<a href="http://mordpendium.herokuapp.com/index.php" target="_blank" class="blue">Mordpendium</a><br>

</td></tr>
</td></tr></table><span id="poll"></span>

