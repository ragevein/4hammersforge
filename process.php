<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_name('4hammers');
session_start();
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
$secure = 'index.php';
$unsecure = 'index.php';
extract($_POST);
$now = date('Y-m-d H:i:s');
/*
if ($_POST['action'] == 'delete' AND $_SESSION['sec'] >= 2){
	// deletes all replies to thread start
	if ($type == 'forum'){
		if ($_SESSION['u_id'] == 99999){
			$query = "DELETE FROM forum WHERE f_id = '".$id."' OR f_parent = '".$id."' " ;
			$result = mysqli_query($link, $query);
			header( 'Location: index.php?mainaction=forum' ) ;
		}
		else {
			$query = "UPDATE forum 
			SET f_arch= 1,
			WHERE f_id = '".$id."'";
			$result = mysqli_query($query);
			header( 'Location: index.php?mainaction=forum' ) ;
		}
	}

}
// --------------------- remove item ----------------------------------

elseif ($_POST['action'] == 'remove'){
}
*/

// --------------------- add to mineloc ------------------------------
if ($_POST['action'] == 'mineloc'){
	$desc = str_replace("'", "&gay", $_POST['desc']);
	$name = str_replace("'", "&gay", $_POST['name']);
	
	// insert into database
		if ($_POST['desc'] == 'Description'){
			$_POST['desc'] = '';
		}
		if ($_POST['y'] == ''){
			$_POST['y'] = '0';
		}
		if ($_POST['option'] == 'add'){
			$query = "INSERT INTO mineloc (m_type, m_name, m_owner, m_map, m_x, m_y, m_z, m_desc, m_dem, m_rel, m_public, m_date)
			VALUES
			( '".$_POST['type']."', '".$name."', '".$_POST['owner']."', '".$_POST['map']."', '".$_POST['x']."',  '".$_POST['y']."', '".$_POST['z']."', '".$desc."', '".$_POST['dem']."', '".$_POST['rel']."', '".$_POST['public']."', '".date('Y-m-d')."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed mineloc'.mysqli_error($link));
		}
		else {
			$query = "UPDATE mineloc SET m_type = '".$_POST['type']."', m_name = '".$name."', m_owner = '".$_POST['owner']."', m_map = '".$_POST['map']."', 
			m_x = '".$_POST['x']."', m_y = '".$_POST['y']."', m_z = '".$_POST['z']."', m_desc = '".$desc."', m_dem = '".$_POST['dem']."', m_rel = '".$_POST['rel']."', m_public = '".$_POST['public']."' WHERE m_id = '".$_POST['id']."'";
			$result = mysqli_query($link, $query) or die ('Error Query Failed mineloc'.mysqli_error($link));
		}
		if ($_POST['loc'] == 'mine'){
		header( 'Location: '.$secure.'?mainaction=minecraft'  ) ;
		}
}

// ------------------------ New game leader board ---------------------------------
elseif ($_POST['action'] == 'leaderboard'){
	$initials = $one.$two.$three;
	if ($_POST['missed'] == 0){
		$query = "SELECT * FROM game_leader WHERE g_uid = '".$_SESSION['u_id']."' AND G_loss = 0 ";
		$result = mysqli_query($link,$query);
		$record = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		if ($record == 1){
			if ($_POST['gold'] > $row['g_score']){
				$query = "UPDATE game_leader SET g_score = ".$_POST['gold'].", g_loss =  ".$_POST['missed'].", g_initials =  '".$initials."' WHERE g_uid = ".$_SESSION['u_id']." AND G_loss = 0 ";
			}
		}
		else {
			$query = "INSERT INTO game_leader (g_uid, g_game, g_score, g_loss, g_initials)
			VALUES ('".$_SESSION['u_id']."', '".$_POST['game']."','".$_POST['gold']."', '".$_POST['missed']."', '".$initials."')";
		}
	}
	else {
		$query = "SELECT * FROM game_leader WHERE g_uid = '".$_SESSION['u_id']."' AND G_loss != 0 ";
		$result = mysqli_query($link,$query);
		$record = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		if ($record == 1){
			if ($_POST['gold'] > $row['g_score']){
				$query = "UPDATE game_leader SET g_score = ".$_POST['gold'].", g_loss =  ".$_POST['missed'].", g_initials =  '".$initials."' WHERE g_uid = ".$_SESSION['u_id']." AND G_loss != 0 ";
				echo 'update new high <br>';
				echo $query;
			}
		}
		else {
			$query = "INSERT INTO game_leader (g_uid, g_game, g_score, g_loss, g_initials)
			VALUES (".$_SESSION['u_id'].", ".$_POST['game'].",".$_POST['gold'].", ".$_POST['missed'].", '".$initials."')";
		}
	}
	

	$result = mysqli_query($link, $query) or die ('Error Query Failed game_leader insert'.mysqli_error($link));
	header( 'Location: index.php?mainaction=tchest') ;/*
*/
}


// ------------------------ New Note section ---------------------------------
elseif ($_POST['action'] == 'inote'){
	$query = "INSERT INTO mc_notes (mc_note_owner, mc_note_info, mc_note_date)
	VALUES ('".$_SESSION['u_id']."', '".$_POST['info']."', '".date('Y-m-d')."')";
	$result = mysqli_query($link, $query) or die ('Error Query Failed motd insert'.mysqli_error($link));
	header( 'Location: index.php?mainaction=mcmap') ;
}
elseif ($_POST['action'] == 'unote'){
	//echo 'you made it the the update note section data section lets look at the vars before we go ham <br>';
	//echo $_POST['owner'].$_POST['info'].'<br>';
	$query = "UPDATE mc_notes SET mc_note_info =  '".$_POST['info']."', mc_note_date = '".date('Y-m-d')."'";
		$result = mysqli_query($link, $query) or die ('Error Query Failed motd insert'.mysqli_error());
		header( 'Location: index.php?mainaction=mcmap') ;
}

// ------------------------- mc settings section ------------------------
elseif ($_POST['action'] == 'mc_settings'){
	$query = "SELECT * FROM mc_settings WHERE mc_u_id = '".$_POST['owner']."' AND mc_world = '".$_POST['world']."' ";
	$result = mysqli_query($link, $query) or die ('Error Query Failed Select From Settings '.mysqli_error($link));

	$mcount = mysqli_num_rows($result);
	
	if ($mcount == 1){
		$query = "UPDATE mc_settings SET mc_res = '".$_POST['res']."', mc_sx =  '".$_POST['sx']."', mc_sz =  '".$_POST['sz']."' WHERE mc_u_id = '".$_POST['owner']."' AND mc_id = '".$_POST['id']."' ";
		$result = mysqli_query($link, $query) or die ('Error Query Failed settings update'.mysqli_error($link));
	}
	else {
		$query = "INSERT INTO mc_settings (mc_u_id, mc_world, mc_dem, mc_res, mc_sx, mc_sz)
		VALUES ('".$_SESSION['u_id']."', '".$_POST['world']."', '".$_POST['dem']."', '".$_POST['res']."', '".$_POST['sx']."', '".$_POST['sz']."')";
		$result = mysqli_query($link, $query) or die ('Error Query Failed settings insert '.mysqli_error($link));
	}
	header( 'Location: index.php?mainaction=mcmap&world='.$_POST['world'].'&dem='.$_POST['dem'].'sx='.$_POST['sx'].'&sz='.$_POST['sz']) ;
	
}
// --------------------- add to usergame ------------------------------
elseif ($_POST['action'] == 'uaddgame'){
	if ($_POST['game'] == NULL){
	echo' redirect no game data entered';
	}
	else {
	// insert into database
		$query = "INSERT INTO user_games (gu_userid, gu_gameid, gu_status, gu_edate, gu_user_name, gu_server, gu_faction, gu_time, gu_score, gu_review)
		VALUES
		('".$_SESSION['u_id']."', '".$_POST['game']."',  '".$_POST['gu_status']."', '".date('Y-m-d H:i:s')."', '".$_POST['username']."', '".$_POST['server']."', '".$_POST['faction']."', '".$_POST['gu_time']."', '".$_POST['score']."', '".$_POST['gu_review']."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed User Games'.mysqli_error($link));
		if ($_POST['loc'] == 'game'){
		header( 'Location: '.$secure.'?mainaction=game&sid='.$_POST['game'].''  ) ;
		}
		else {
		header( 'Location: '.$unsecure.'?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].''  ) ;
		}
	}
}

// ------------------------ Pillage Qlog game------------------------------------------
elseif ($_POST['action'] == 'pillage'){
	$date = date("Y-m-d");
	$yesterday = date("Y-m-d", strtotime('-24 hours', time()));
	$roll = rand(1, 20);
	$gold = rand(5,15);
	$exp = 5;

	$sql = "SELECT * FROM goal_data WHERE g_user = ".$_POST['target']." AND g_type = 0 AND g_date = '".$yesterday."' ";
	$gquery = mysqli_query($link, $sql);		
	$gdcount = mysqli_num_rows($gquery);

	
	
	$sql = "SELECT * FROM goal WHERE g_user = ".$_POST['target']." AND g_type = 0 ";
	$gquery = mysqli_query($link, $sql);
	$gcount = mysqli_num_rows($gquery);
	$dratio = round(($gdcount/$gcount)*100, 0, PHP_ROUND_HALF_UP);
	//round($gdcount/$gcount, 0)*100;
	if ($dratio < $_POST['a_ratio']){
		$gap = round(($_POST['a_ratio']-$dratio)/10, 0);
		$froll = $roll+$gap;
	}
	else {
		$gap = round(($dratio-$_POST['a_ratio'])/10, 0);
		$froll = $roll-$gap;
		$gap = -$gap;
	}
/*
	echo 'attack specs your total goals '.$_POST['a_goals'].' completed goals '.$_POST['a_gcompleted'].' percent '.$_POST['a_ratio'].' your victums id '.$_POST['target'].' total goals '.$gcount.' completed goals: '.$gdcount.' goal percent '.$dratio;
	echo '<br> ('.$dratio.'  '.$_POST['a_ratio'].') / 10 and round up = '.$gap. ' + bonus from items = 0<br>' ;
	echo ' roll 10 or higher to succeed: Roll '.$roll.'  + goal gap '.$gap. ' total roll '.$froll;
	// testing

	
	$mine = 65;
	$dratio = round((5/6)*100, 0, PHP_ROUND_HALF_UP);
	$gap = round(($mine-$dratio)/10, 0);
	echo '<br>Testing maths<br>';
	$froll = $roll+$gap;

	echo 'attack specs your goal percent '.$mine.' your victums id '.$_POST['target'].' goal percent '.$dratio;
	echo '<br> ('.$mine.' - '.$dratio.'  ) / 10 and round up = '.$gap. ' + bonus from items = 0<br>' ;
	echo ' roll 15 or higher to succeed: Roll '.$roll.' + goal gap '.$gap. ' total roll '.$froll;
	*/

	if ($froll >= 10) {
		echo '<br>Roll Succeeded! <br>';
		$sql = "INSERT INTO transactions (t_type, t_init_user, t_affect_user, t_amount, t_items, t_scenario, t_date, t_roll, t_exp, t_dice) 
		VALUES ('".$_POST['type']."', '".$_POST['attacker']."', '".$_POST['target']."', '".$gold."', '".$_POST['items']."', '".$_POST['event']."', '".$date."', '".$froll."', '".$exp."', '".$roll.','.$gap."')";
		$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
		echo '<br>'.$sql.'<br>';
		$sql = "UPDATE users SET u_coin = u_coin - ".$gold." WHERE u_id = ".$_POST['target']."";
		$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
		echo $sql.'<br>';
		$sql = "UPDATE users SET u_coin = u_coin + ".$gold.", u_exp = u_exp + ".$exp." WHERE u_id = ".$_POST['attacker']."";
		$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
		header('Location: index.php?mainaction=lewt&lewtaction=pick&results=1');
		echo $sql.'<br>';
	}
	else {
		if ($froll < 2){
			echo '<br>Critical Fail roll<br>';
			$sql = "INSERT INTO transactions (t_type, t_init_user, t_affect_user, t_amount, t_items, t_scenario, t_date, t_roll, t_success, t_dice) 
			VALUES ('".$_POST['type']."', '".$_POST['attacker']."', '".$_POST['target']."', '".$gold."', '".$_POST['items']."', '".$_POST['event']."', '".$date."', '".$froll."', 2, '".$roll.','.$gap."')";
			$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
			echo '<br>'.$sql.'<br>';
			$sql = "UPDATE users SET u_coin = u_coin + ".$gold." WHERE u_id = ".$_POST['target']."";
			$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
			echo $sql.'<br>';
			$sql = "UPDATE users SET u_coin = u_coin - ".$gold." WHERE u_id = ".$_POST['attacker']."";
			$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
			header('Location: index.php?mainaction=lewt&lewtaction=pick&results=3');
			echo $sql.'<br>';
		}
		else {
			echo '<br>Roll Failed! <br>';
			$sql = "INSERT INTO transactions (t_type, t_init_user, t_affect_user, t_amount, t_items, t_scenario, t_date, t_roll, t_success, t_exp, t_dice) 
			VALUES ('".$_POST['type']."', '".$_POST['attacker']."', '".$_POST['target']."', 0, '".$_POST['items']."', '".$_POST['event']."', '".$date."', '".$froll."', 1, '".$exp."', '".$roll.','.$gap."')";
			$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
			echo '<br>'.$sql.'<br>';
			header('Location: index.php?mainaction=lewt&lewtaction=pick&results=2');
		}
	}
	
}


// ------------------------ Game add events Qlog game ------------------------------------------
elseif ($_POST['action'] == 'game_add_event'){
	$fbody = str_replace("'", "&ap", $_POST['ge_body']);
	$fsuccess = str_replace("'", "&ap", $_POST['ge_success']);
	$ffail = str_replace("'", "&ap", $_POST['ge_fail']);
	$fdesc = str_replace("'", "&ap", $_POST['ge_desc']);

	if ($_POST['update'] == 'true'){
		$sql = "UPDATE game_events SET ge_type = '".$_POST['ge_type']."', ge_desc = '".$fdesc."', ge_body = '".$fbody."', ge_success = '".$fsuccess."', ge_fail = '".$ffail."', ge_level =  '".$_POST['ge_level']."', ge_dice = '".$_POST['ge_dice']."' WHERE ge_id = '".$_POST['ge_id']."'";
		$result = mysqli_query($link, $sql) or die ('Error Query Failed update game event '.mysqli_error($link));
		header('Location: index.php?mainaction=admin');
	}
	else {
		$sql = "INSERT INTO game_events (ge_type, ge_desc, ge_body, ge_success, ge_fail, ge_level, ge_uid, ge_dice) 
		VALUES ('".$_POST['ge_type']."', '".$fdesc."', '".$fbody."', '".$fsuccess."', '".$ffail."', '".$_POST['ge_level']."', '".$_POST['ge_uid']."', '".$_POST['ge_dice']."')";
		$result = mysqli_query($link, $sql) or die ('Error Query Failed add game event '.mysqli_error($link));
		header('Location: index.php?mainaction=admin');
	}
	
	
}

// ------------------------ New Goals section ---------------------------------
elseif ($_POST['action'] == 'goal'){
	if (isset($_POST['update'])){
		//echo 'Update location';
		//echo ' ID: '.$_POST['g_id'].' parent id: '.$_POST['g_parent'].' goal type '.$_POST['g_type'].' Name '.$_POST['g_name'].' Desc '.$_POST['g_desc'];
		
		$query = "UPDATE goal SET g_name = '".$_POST['g_name']."', g_desc = '".$_POST['g_desc']."', g_type = '".$_POST['g_type']."', g_update = '".$_POST['g_update']."', g_vis = '".$_POST['g_vis']."', g_group = '".$_POST['g_group']."', g_repeat = '".$_POST['g_repeat']."', g_cat = '".$_POST['g_cat']."'
			WHERE g_id = '".$_POST['g_id']."'";
			$result = mysqli_query($link, $query) or die ('Error Query Failed goal update Query: '.$query.'<br>'.mysqli_error($link));
		
			header('Location: index.php?mainaction=qlog');
	}
	else {
		$query = "INSERT INTO goal (g_user, g_type, g_name, g_desc, g_vis, g_group, g_repeat, g_cat)
			VALUES
			('".$_SESSION['u_id']."', '".$_POST['g_type']."', '".$_POST['g_name']."', '".$_POST['g_desc']."', '".$_POST['g_vis']."', '".$_POST['g_group']."', '".$_POST['g_repeat']."', '".$_POST['g_cat']."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed goal insert '.mysqli_error($link));
		header('Location: index.php?mainaction=qlog');
	}
}

elseif ($_POST['action'] == 'g_data'){
	if ($_POST['g_type'] == 0){
	$gold = rand(1, 25);
	$exp = 5;
	}
	elseif ($_POST['g_type'] == 1){
	$gold = rand(80, 120);
	$exp = 25;
	}
	elseif ($_POST['g_type'] == 2){
	$gold = rand(300, 400);
	$exp = 95;
	}
	elseif ($_POST['g_type'] == 3){
	$gold = rand(3000, 4000);
	$exp = 1000;
	}
	$query = "INSERT INTO goal_data (g_parent, g_user, g_type, g_date, g_info, g_coin)
	VALUES
	('".$_POST['g_parent']."', '".$_POST['g_user']."', '".$_POST['g_type']."', '".$_POST['g_date']."', '".$_POST['g_info']."', '".$gold."')";
	$result = mysqli_query($link, $query) or die ('Error Query Failed goal_data insert '.mysqli_error($link));
	$sql = "UPDATE users SET u_coin = u_coin + '".$gold."', u_exp = u_exp + '".$exp."' WHERE u_id = '".$_SESSION['u_id']."' ";
	$result = mysqli_query($link, $sql) or die ('Error Query Failed update gold '.mysqli_error($link));
	header('Location: index.php?mainaction=qlog');
}

elseif ($_POST['action'] == 'g_w_data'){
	echo 'you made it the the goal data section lets look at the vars before we go ham <br>';
	echo $_POST['parent_id'].$_POST['g_date'].$_POST['g_type'].'<br>';
	for ($i = 0; $i < 7; $i++){
		echo 'Row '.$i.' ID: '.$_POST['g_id'].' parent id:  '.$_POST['parent_id'].' goal type '.$_POST['g_type'].' <br>';
	}
}

elseif ($_POST['action'] == 'g_link'){
	echo 'you made it the the goal group section lets validate the vars before do anything<br>';
	echo 'g_id '.$_POST['g_id'].' group_name '.$_POST['group_name'].' group_user '.$_POST['group_user'].' group_type '.$_POST['group_type'].'<br>';
	if ($_POST['g_parent'] == 0){// if no group has been created, make a group inset and then update the coresponding goals
		$sql = "INSERT INTO group_goal (group_parent, group_date, group_user, group_owner, group_name)
			VALUES
			('".$_POST['group_parent']."', '".$_POST['group_date']."', '".$_POST['group_user']."', '".$_POST['group_owner']."', '".$_POST['group_name']."')";
		mysqli_query($link, $sql) or die ('Error Query Failed insert group_goal '.mysqli_error($link));
		$id = mysqli_insert_id($link);
		$sql = "UPDATE goal SET g_parent = '".$id."', g_group = 1 WHERE g_id IN ('".$_POST['g_joinie']."','".$_POST['g_joiner']."')"; 
		mysqli_query($link, $sql) or die ('Error Query Failed goal upate '.mysqli_error($link));
	}
	else {// just update the goal with the proper parent ID to join the group
		$sql = "UPDATE goal SET g_parent = '".$_POST['g_parent']."', g_group = 1 WHERE g_id IN ('".$_POST['g_joinie']."','".$_POST['g_joiner']."')"; 
		mysqli_query($link, $sql) or die ('Error Query Failed goal upate '.mysqli_error($link));
	}
	header('Location: index.php?mainaction=qlog');
}

// --------------------- motd ------------------------------
elseif ($_POST['action'] == 'motd'){
		// update motd
		
		if (isset($_POST['update'])){
			$fixed = str_replace("'", "&ap", $body);
			$query = "UPDATE motd SET m_body = '".$fixed."'
			WHERE m_id = ".$sid."";
			$result = mysqli_query($link, $query) or die ('Error Query Failed motd update'.mysqli_error($link));
			header( 'Location: index.php'  ) ;
		}
		else {
		// insert into motd
			$fixed = str_replace("'", "&ap", $_POST['body']);
			$query = "INSERT INTO motd (m_body, m_auth)
			VALUES
			( '".$fixed."', '".$_SESSION['u_id']."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed motd insert'.mysqli_error($link));
			header( 'Location: index.php'  ) ;
		}
}
// --------------------- update usergame ------------------------------

elseif ($_POST['action'] == 'ueditgame'){  
	// Update DB
		$query = "UPDATE user_games SET gu_status = '".$_POST['gu_status']."', gu_user_name = '".$_POST['username']."', gu_server = '".$_POST['server']."',
		 gu_faction =  '".$_POST['faction']."', gu_score = '".$_POST['score']."', gu_time = '".$_POST['gu_time']."', gu_review = '".$_POST['review']."' WHERE gu_id = ".$_POST['sid']."";
			$result = mysqli_query($link, $query) or die ('Error Query Failed User Games'.mysqli_error($link));
		if ($_POST['loc'] == 'game'){
		header( 'Location: '.$secure.'?mainaction=game&sid='.$_POST['gsid'].''  ) ;	
		} else {
		header( 'Location: '.$unsecure.'?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].''  ) ;
		}
}

// --------------------- add a game to game database ------------------------------
elseif ($_POST['action'] == 'addgame'){
	if ($_POST['name'] == NULL){
	echo' redirect no game name entered to add game section';
	}
	else {
	// insert into database
		$ldate = $year.'-'.$month.'-'.$day;
		$query = "INSERT INTO Games (g_name, g_desc, g_genre, g_edate, g_auth, g_ldate, g_type, g_company, g_platform, g_img, g_img_type)
		VALUES
		('".$_POST['name']."', '".$_POST['desc']."', '".$_POST['genre']."', '".date('Y-m-d')."', '".$_SESSION['u_id']."', 
		'".$ldate."',  '".$_POST['type']."', '".$_POST['company']."', '".$_POST['platform']."', '".$_POST['img']."', 0)";
			$result = mysqli_query($link, $query);
		if ($_POST['loc'] == 'games'){
		  header( 'Location: '.$secure.'?mainaction=gamelist'  ) ;
		 // echo $query.'<br>'.$result;
		}
		else {
		  header( 'Location: '.$secure.'?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].''  ) ;
		}
	}
}

// --------------------- update game info ------------------------------
elseif ($_POST['action'] == 'editgame'){
	if ($_POST['sid'] == NULL){
	echo' redirect no game id entered can not continue';
	}
	else {
	// gets id so we can name the file
	$query = "SELECT g_id, g_img_type FROM Games WHERE g_id = ".$_POST['sid']."";
	$result = mysqli_query($link, $query) or die ('Error Query Failed User Games check image exists'.mysqli_error($link));
	$row = mysqli_fetch_array($result);
		if ($_FILES['userfile']['error'] > 0){
			switch ($_FILES['userfile']['error']){
				case 1: echo 'File exceeded upload_max_filesize'; break; exit;
				case 2: echo 'File exceeded max_file_size'; break; exit;
				case 3: echo 'File only partially uploaded'; break; exit;
				//case 4: echo 'No file uploaded'; break;
			}
		}
			
		if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
			// does the file have the right MIME type?
			$badfile = 0;
			if ($_FILES['userfile']['type'] == 'image/jpeg'){
				$badfile = 1;
			}
			elseif ($_FILES['userfile']['type'] == 'image/jpg'){
				$badfile = 1;
			}
			elseif ($_FILES['userfile']['type'] == 'image/gif'){
				$badfile = 1;	
			}
			elseif ($_FILES['userfile']['type'] == 'image/pjpeg'){
				$badfile = 1;	
			}
			if ($badfile == 0){
				echo 'Problem: file is not a jpeg or a gif image.<br>';
				echo $_FILES['userfile']['type'];
				exit;
			}
			// put the file where we'd like it
			$upfile = $_FILES['userfile']['name'];
			//--- my additions
			$file_basename = substr($upfile, 0, strripos($upfile, '.')); // strip extention
			$file_ext = substr($upfile, strripos($upfile, '.')); // strip name
			$ldate = $year.'-'.$month.'-'.$day;
			$dfile = 'img0'. $row['g_id'] . $file_ext;			
			//-------------------------------------------- resize to 128 128 for larger images ---------------------------------
			list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
			if ($width > 200){
				$uploadedfile = $_FILES['userfile']['tmp_name'];
				$fwidth = 200;
				$nheight = ( $height / $width * $fwidth);
				$newwidth = $fwidth;
				$newheight = $nheight;
				//$file_ext = strtolower($file_ext);
				// Load
				$tmp = imagecreatetruecolor($newwidth, $newheight);
				if ($_FILES['userfile']['type'] == 'image/gif'){
					$src = imagecreatefromgif($uploadedfile);
				}
				else {
					$src = imagecreatefromjpeg($uploadedfile);
				}	
				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
				$filename = "img/games/". $dfile;
				// Resize and put into directory
				imagejpeg($tmp,$filename,100);
				imagedestroy($src);
				imagedestroy($tmp);
			}
			else {
				if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/games/'.$dfile)){
					echo 'Problem: Could not move file to destination directory!';
					exit;
				}
			}
			$query = "UPDATE Games SET g_name = '".$_POST['name']."', g_desc = '".$_POST['desc']."', g_ldate = '".$ldate."',
		 	g_type =  '".$_POST['type']."', g_company = '".$_POST['company']."', g_platform = '".$_POST['platform']."', g_img = 'img/games/".$dfile."', g_img_type = 1 WHERE g_id = ".$_POST['sid']."";
			$result = mysqli_query($link, $query) or die ('Error Query Failed User Games'.mysqli_error($link));
		}
		else {

			$ldate = $year.'-'.$month.'-'.$day; // need to fix this if an update happens after a local image has been uploaded escape the img update
			$query = "UPDATE Games SET g_name = '".$_POST['name']."', g_desc = '".$_POST['desc']."', g_ldate = '".$ldate."',
		 	g_type =  '".$_POST['type']."', g_company = '".$_POST['company']."', g_platform = '".$_POST['platform']."'";
			if (mysqli_num_rows($result) >= 1){
				// we already have an image, lets write over top of current one so we don't get a bunch of useless images on the site.
				$query .= " WHERE g_id = ".$_POST['sid']."";	
			}
			else {
				$query .= ", g_img = '".$_POST['img']."' WHERE g_id = ".$_POST['sid']."";
			}
			//  i need to add an option to delete local file when some updates game file with an offsite image 			 
			$result = mysqli_query($link, $query) or die ('Error Query Failed User Games'.mysqli_error($link));
		}
		header( 'Location: '.$unsecure.'?mainaction=game&sid='.$_POST['sid'].''  ) ;
	}
	echo 'stopped';
}

// ---------------------- message submition ---------------------------

elseif ($_POST['action'] == 'msg'){
	$body = str_replace("'", "&ap", $body);
	if ($target == 0) {
		if ($location == "checkin"){
			$query = "INSERT INTO messages (m_body, m_target, m_sender, m_date)
			VALUES
			('".$body."', '".$target."',  '".$_SESSION['u_id']."', '".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed'.mysqli_error($link));
			header( 'Location: '.$secure.'?mainaction=checkin'  ) ;
		}
		else {
			$error = 1;
			header( 'Location: '.$secure.'?mainaction=msg&error=1'  ) ;
		}

	}
	else {
		$query = "INSERT INTO messages (m_body, m_target, m_sender, m_date)
		VALUES
		('".$body."', '".$target."',  '".$_SESSION['u_id']."', '".date('Y-m-d H:i:s')."')";
			$result = mysqli_query($link, $query) or die ('Error Query Failed'.mysqli_error($link));
		header( 'Location: '.$secure.'?mainaction=msg'  ) ;
	}

}

// ------------------------- Insert Comment ------------------------------------
elseif ($_POST['action'] == 'comment'){
	if ($subaction == 'update'){
	$query = "UPDATE comment SET com_body = '".$body."'
		WHERE com_id = ".$com_id.""; //nl2br should add <br /> where newlines are detected in $body
		$result = mysqli_query($link, $query);
	}
	else {
	$query = "INSERT INTO comment (com_body, com_date, com_auth, com_npost)
		VALUES
		('".$body."',  '".date('Y-m-d H:i:s')."', '".$auth."', '".$n_id."')";
		$result = mysqli_query($link, $query);	
	}
	header( 'Location: '.$secure.'?mainaction=story&id='.$n_id.''  ) ;
}

// --------------------- password recovery area ---------------------------------------
elseif ($_POST['action'] == 'forgot'){

$query = "SELECT u_email, u_name, u_id FROM users WHERE u_name = '".$_POST['u_name']."'";
$result = mysqli_query($link, $query);

//echo $query;
	if (mysqli_num_rows($result) < 1){
	header( 'Location: '.$secure.'?mainaction=forgot&action=Error'  ) ;
	}
	else {
		require('functions.php');
		$ip = getenv('REMOTE_ADDR');
		$data = mysqli_fetch_array($result);
		$hash = hash('sha256', generatePassword()); /// creates a 64 char for the password, one way encryption
		$query ="INSERT INTO temp (t_user, t_pass, t_u_id, t_ip) 
		VALUES ('".$data['u_name']."', '".$hash."', '".$data['u_id']."', '".$ip."')";
		$result = mysqli_query($link, $query); //or die ('query failed'.$query);
		echo $query;
	// ----------------------- email for password recovery ---------------------------------
		
		$to =  $data['u_email'];
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: 4 Hammers Forge Support <support@4hammersforge.com>'. "\r\n".
			'Reply-To: <support@4hammersforge.com>' . "\r\n";
			//'X-Mailer: PHP/'
		$headers .= 'Bcc: support@4hammersforge.com' . "\r\n";
		$mesg = '<html><head><title>Password recovery for 4hammersforge.com</title></head><body bgcolor="#808080"><table><tr><td>You have been sent this email to recover your password for 
		www.4hammersforge.com</td></tr><tr><td> Click the <a href="https://www.4hammersforge.com/index.php?mainaction=reset&key='.$hash.'">Here</a> to reset your password,</td></tr>
		<tr><td>or copy and paste this link into your browser.</td></tr>
		<tr><td>https://www.4hammersforge.com/index.php?mainaction=reset&key='.$hash.'</td></tr></table></body></html>';
		mail($to, 'Password recovery', $mesg, $headers);
		
		header( 'Location: '.$secure.'?mainaction=forgot&action=Success'  ) ;
	}
}

// --------------------------- password reset section ----------------------------------------

elseif ($_POST['action'] == 'reset'){
	if ( trim($pass1) !=  trim($pass2)){
		header( 'Location: '.$secure.'?mainaction=reset&error=1'  ) ;
		
	}
	elseif(strlen($pass1) < 6){
		header( 'Location: '.$secure.'?mainaction=reset&error=2'  ) ;
		//break;
	}
	else {
	$hash = hash('sha256', trim($pass1));
	$query = "UPDATE users 
				SET 
				u_pass= '".$hash."'
				WHERE u_id = ".$id."";
	$result = mysqli_query($link, $query); // or die ('Error Query Failed'.mysqli_error($link));
	//echo $query.'<br>';
	$query = "UPDATE temp
				Set t_done = 1
				WHERE t_pass = '".$key."'";
	$result = mysqli_query($link, $query); // or die ('Error Query Failed'.mysqli_error($link));
	//echo 'Here 2<br>';
	//echo $query;
		header( 'Location: '.$secure.'?mainaction=login'  ) ;
	}
}

elseif ($_POST['action'] == 'figgy')
{
	$gism = 'img/avatars/'.$file;
	unlink ( $gism );
	//echo $gism;
	$query = "DELETE FROM avatar WHERE i_src = '".$file."' LIMIT 1";
	$result = mysqli_query($link, $query) or die (mysqli_error($link));
	header( 'Location: '.$secure.'?mainaction=test&filename='.$file);

}

// Update User section  -----------------------------------------------------------------------------
if ($_POST['action'] == 'user'){
require('functions.php');
	if (isset($update_pass)){
	$hash = hash('sha256', trim($old_pass)); /// creates a 64 char for the password, one way encryption
	$query = "SELECT u_id, u_pass, u_name FROM users WHERE u_id = '".$u_id."' AND u_pass = '".$hash."'";
	$result = mysqli_query($link, $query); // or die ("Query failed, table users");
	$record = mysqli_num_rows($result);
		
		if ($record == 1) {
			if (trim($pass1) != trim($pass2)){
				header( 'Location: index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'&sub_action=pass&error=2'  ) ;
			}
			elseif(strlen($pass1) < 6){
				header( 'Location: index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'&sub_action=pass&error=3'  ) ;
			}
			else {
				$hash = hash('sha256', trim($pass1)); /// creates a 64 char for the password, one way encryption
				$query = "UPDATE users 
				SET u_pass='".$hash."'
				WHERE u_id = ".$u_id."";
				$result = mysqli_query($link, $query);
				//echo $query;
				header( 'Location: index.php?mainaction=profile' ) ;
			}
		}
		else {
			header( 'Location: index.php?mainaction=profile&sub_action=pass&error=1' ) ;
		}
		
	}
	else {
	
	// strips the ' from the string cause it pisses off the sql server
	$ffname = str_replace("'", "&gay", $u_fname);
	$flname = str_replace("'", "&gay", $u_lname);
	$fbio = str_replace("'", "&gay", $u_bio);
	$fsig = str_replace("'", "&gay", $u_sig);
	$fpc = str_replace("'", "&gay", $u_pc);
	$u_kingdom = str_replace("'", "&gay", $u_kingdom);
	
	if ($_POST['sub_action'] == 'update'){
		
	  	if ($_POST['loc'] == 'profile'){
	  		// ----- handles image upload --------------------------------------------------------------------------------------
	  		if ($_FILES['userfile']['error'] > 0){
				switch ($_FILES['userfile']['error']){
				case 1: echo 'File exceeded upload_max_filesize'; break; exit;
				case 2: echo 'File exceeded max_file_size'; break; exit;
				case 3: echo 'File only partially uploaded'; break; exit;
				//case 4: echo 'No file uploaded'; break;
				}
			}
			
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
				echo 'file upload place';
				// does the file have the right MIME type?
				$badfile = 0;
					if ($_FILES['userfile']['type'] == 'image/jpeg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/jpg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/gif'){
						$badfile = 1;	
					}
					elseif ($_FILES['userfile']['type'] == 'image/pjpeg'){
						$badfile = 1;	
					}
					if ($badfile == 0){
								echo 'Problem: file is not a jpeg or a gif image.<br>';
								echo $_FILES['userfile']['type'];
								exit;
					}
				
				// put the file where we'd like it
				$upfile = $_FILES['userfile']['name'];
				//--- my additions
				$file_basename = substr($upfile, 0, strripos($upfile, '.')); // strip extention
				$file_ext = substr($upfile, strripos($upfile, '.')); // strip name

				
				// enter a record into avatar database
				$dfile = 'userpic'.$_SESSION['u_id'] . $file_ext;
				$query = "SELECT * FROM avatar WHERE i_auth = ".$_SESSION['u_id']."";
				$result = mysqli_query($link, $query) or die (mysqli_error($link));
				$record = mysqli_num_rows($result);
				//echo $dfile;
				if ($record < 1){
					$query = "INSERT INTO avatar (i_name, i_src, i_date, i_auth)
					VALUES
					('".$i_name."', '".$dfile."', '".date('Y-m-d')."', '".$_SESSION['u_id']."')";
					$result = mysqli_query($link, $query);
				}
				else {
					$query = "UPDATE avatar SET i_src = '".$dfile."', i_name = '".$i_name."' WHERE i_auth = ".$_SESSION['u_id']."";
					$result  = mysqli_query($link, $query);
				}
				//-------------------------------------------- resize to 128 128 for larger images ---------------------------------
				list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
				if ($width > 128 || $height > 128){
				
					$uploadedfile = $_FILES['userfile']['tmp_name'];
					$newwidth = 128;
					$newheight = 128;
					//$file_ext = strtolower($file_ext);
					// Load
					$tmp = imagecreatetruecolor($newwidth, $newheight);
					if ($_FILES['userfile']['type'] == 'image/gif'){
					$src = imagecreatefromgif($uploadedfile);
					}
					else {
					$src = imagecreatefromjpeg($uploadedfile);
					}
					
					imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					$filename = "img/avatars/". $dfile;
					
					// Resize and put into directory
					imagejpeg($tmp,$filename,100);
					imagedestroy($src);
					imagedestroy($tmp);
				}
				else {
					if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/avatars/'.$dfile)){
					echo 'Problem: Could not move file to destination directory!';
					exit;
					}
				}
			}

	  		// if they uploaded their own image
			
	  		if ($_FILES['userfile']['error'] != 4 && $update_pass != 'yes'){ // the 4 means it didn't throw the no file uploaded error
					$tube =  strripos($u_utube, '/');
					if ($tube === false) {
					}
					else {
   						$u_utube = substr($u_utube, strripos($u_utube, '/')+1);
					}
	    		$mdate = $year.'-'.$month.'-'.$day;
				$query = "UPDATE users 
				SET 
				u_fname='".$ffname."',
				u_lname='".$flname."',
				u_email='".$u_email."',
				u_bdate='".$mdate."',
				u_bio='".$fbio."',
				u_sig='".$fsig."',
				u_privacy='".$u_privacy."',
				u_utube='".$u_utube."',
				u_avatar= '".$dfile."',
				u_fbook='".$u_fbook."',
				u_steam='".$u_steam."',
				u_btag='".$u_btag."',
				u_pc='".$fpc."',
				u_sex='".$u_sex."',
				u_kingdom='".$u_kingdom."',
				u_update='".$now."'
				WHERE u_id = '".$u_id."'";
			}
			
			// normal update without an image  
			else {
					$tube =  strripos($u_utube, '/');
					if ($tube ===  false) {
					}
					else {
   						$u_utube = substr($u_utube, strripos($u_utube, '/')+1);
					}
					$fbook =  strripos($u_fbook, '/');
					if ($fbook ===  false) {
					}
					else {
   						$u_fbook = substr($u_fbook, strripos($u_fbook, '/')+1);
					}
				$mdate = $year.'-'.$month.'-'.$day;
				$query = "UPDATE users 
				SET 
				u_fname='".$ffname."',
				u_lname='".$flname."',
				u_email='".$u_email."',
				u_bdate='".$mdate."',
				u_bio='".$fbio."',
				u_sig='".$fsig."',
				u_privacy='".$u_privacy."',
				u_utube='".$u_utube."',
				u_fbook='".$u_fbook."',
				u_steam='".$u_steam."',
				u_btag='".$u_btag."',
				u_pc='".$fpc."',
				u_sex='".$u_sex."',
				u_kingdom='".$u_kingdom."',
				u_update='".$now."'
				WHERE u_id = '".$u_id."'";

			}
		}
		
		// admin update to change security levels  u_ref='".$u_ref."',
	 	elseif ($_SESSION['u_id'] == 1) {
	 		$query = "UPDATE users 
			SET 
				u_dark='".$u_dark."',
				u_sec='".$u_sec."'
			WHERE u_id = '".$u_id."'";
	  	}
		$result = mysqli_query($link, $query);
		if (!$result) {
   		 	die('Invalid query: ' . mysqli_error($link));
		}
		if ($_POST['loc'] == 'profile'){
			if ($update_pass == 'yes'){
			header( 'Location: index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'].'&update=success' ) ;
			}
			else {
			header( 'Location: index.php?mainaction=profile' ) ;
			}
		}
       	else {
			header( 'Location: index.php?mainaction=members' ) ;
		}
	}
	}
}


// Event update --------------------------------------
elseif($_POST['action'] == 'event'){
	if ($_POST['subaction'] == 'edit') {
	$mdate = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';
	$query = "UPDATE events 
		SET e_sub='".$sub."',
	   	e_body='".$body."',
		e_date='".$mdate."',
		e_cat='".$cat."',
		e_vis='".$vis."'
		WHERE e_id = '".$e_id."'";
		$result = mysqli_query($link, $query);
	header( 'Location: index.php?mainaction=event&sid='.$e_id.'');
	}
	// Insert Event ------------------------------------------------
	else {
	$mdate = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';
	$query = "INSERT INTO events (e_sub, e_date, e_body, e_auth, e_cat, e_vis)
		VALUES
		('".$sub."','".$mdate."','".$body."', '".$_SESSION['u_id']."', '".$cat."', '".$vis."')";
		$result = mysqli_query($link, $query);
		if (!$result) {
   		 die('Invalid query: ' . mysqli_error($link));
		}
	header( 'Location: index.php?mainaction=calendar');
	}
}

// -------------------------------  Signup process ------------------------------------------
elseif($_POST['action'] == 'signup'){
	if ( rtrim($u_pass1) !=  rtrim($u_pass2)){
		header( 'Location: index.php?mainaction=signup&subaction=error' ) ;
	}
	elseif(strlen($u_pass1) < 6){
		header( 'Location: index.php?mainaction=signup&subaction=error3' ) ;
	}
	elseif(strlen($u_name) > 30){
		header( 'Location: index.php?mainaction=signup&subaction=error4' ) ;
	}
	else {
		$query = "SELECT * FROM secure_img WHERE s_id = ".$s_id.""; // bot spam images
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_array($result);
		if ($row['s_value'] == strtolower(trim($s_img))) {
			$query = "SELECT u_name FROM users WHERE u_name = '".$u_name."'";
			$result = mysqli_query($link, $query);
			$record = mysqli_num_rows($result);
			if ($record != 1) {
				$mdate = $year.'-'.$month.'-'.$day;
				$hash = hash('sha256',  rtrim($u_pass1)); /// creates a 64 char for the password, one way encryption
				$username = $_POST['u_name']; // prevents sql injection ... // mysqli_real_escape_string( )wants another paramater that i don't know
				$query = "INSERT INTO users (u_fname, u_lname, u_name, u_pass, u_email, u_sec, u_bdate, u_dday)
				VALUES
				('".$u_fname."','".$u_lname."','". rtrim($username)."', '".$hash."', '".$u_email."', 1, '".$mdate."', '".date('Y-m-d H:i:s')."')";
				
				echo $query;
				if ($result = mysqli_query($link, $query)){
				//	echo 'you are here';
				
				// logs user in and sends to welcome page
				$query = "select * from users where u_name = '".$u_name."' and u_pass = '".$hash."'";
				$result = mysqli_query($link, $query) or die ("wtf");
					if (mysqli_num_rows($result) == 1){
						$row = mysqli_fetch_array($result);
						$_SESSION['login'] = $u_name;
						$_SESSION['sec'] = $row['u_sec'];
						$_SESSION['u_id'] = $row['u_id'];
						$_SESSION['old_date'] = $row['u_time'];
    				// ---------------- inserts record into temp ----------------
						$ip = getenv('REMOTE_ADDR');
						require('admin/functions.php');
						$hash = hash('sha256', generatePassword()); 
						$query = "INSERT INTO temp (t_user, t_pass, t_u_id, t_ip, t_type) VALUES ('".$row['u_name']."', '".$hash."', '".$row['u_id']."', '".$ip."', 1)";
						$result = mysqli_query($link, $query) or die ('query failed');	
					
					// ----------------------- email for welcome ---------------------------------
						$to = $row['u_email'];
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$headers .= 'From: 4 Hammers Forge Support <admin@4hammersforge.com>'. "\r\n". 'Reply-To: <admin@4hammersforge.com>' . "\r\n";
						$headers .= 'Bcc: admin@4hammersforge.com' . "\r\n";
						$mesg = '<html><head><title>Welcome from 4 Hammers Forge</title></head><body bgcolor="#808080"><table><tr>
						<td>Welcome and thanks for joining us at www.4hammersforge.com.</td></tr>
						<tr><td>Please verify your email by clicking on this 
						link <a href="www.4hammersforge.com/index.php?mainaction=verify&key='.$hash.'">HERE</a> or by copy and pasting the link into your browser.</td></tr>
						<tr><td>www.4hammersforge.com/index.php?mainaction=verify&key='.$hash.'</td></tr></table></body></html>';
						mail($to, 'Welcome', $mesg, $headers);
					
						header( 'Location: index.php?mainaction=welcome' ) ;
					}
				   		 			
				}				
			}
			else {
			header( 'Location: index.php?mainaction=signup&subaction=error2' ) ;
			}
		}
		else {
		header( 'Location: index.php?mainaction=signup&subaction=error5' ) ;
		}
	}
}

// add a post or thread -----------------------------------------------------------------------------
elseif ($_POST['action'] == 'forum'){
	$urlloc = 'Location: index.php?'.($mainaction == 'post' ? 'mainaction=forum' : 'mainaction='.$mainaction).'&views=0'.(isset($cat) ? '&cat='.$cat : '').(isset($sid) ? '&id='.$sid : '&id='.$id);
	$fixed = str_replace("'", "&gay", $body);
	if (!isset($_POST['sub_action'])){
	$_POST['sub_action'] = 'none';
	}
	$tag = 'none';
	// If update
	if ($_POST['sub_action'] == 'update'){
		if ($tag == 1 ){
			$query = "UPDATE forum 
			SET f_sub='".$sub."',
	   		f_body='".$fixed."',
			f_order='".$order."'
			WHERE f_id = '".$id."'";
			$result = mysqli_query($link, $query);
			if (!$result) {
    			die('Invalid query: ' . mysqli_error($link));
			}
			$urlloc = 'Location: index.php?mainaction=forum';
       	header( $urlloc ) ;
		}
		else {
		// ----- handles image upload --------------------------------------------------------------------------------------
	  		if ($_FILES['userfile']['error'] > 0){
				switch ($_FILES['userfile']['error']){
				case 1: echo 'File exceeded upload_max_filesize'; break; exit;
				case 2: echo 'File exceeded max_file_size'; break; exit;
				case 3: echo 'File only partially uploaded'; break; exit;
				//case 4: echo 'No file uploaded'; break;
				}
			}
			if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
				// does the file have the right MIME type?
				$badfile = 0;
					if ($_FILES['userfile']['type'] == 'image/jpeg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/jpg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/gif'){
						$badfile = 1;	
					}
					elseif ($_FILES['userfile']['type'] == 'image/pjpeg'){
						$badfile = 1;	
					}
					if ($badfile == 0){
								echo 'Problem: file is not a jpeg or a gif image.<br>';
								echo $_FILES['userfile']['type'];
								exit;
					}
				// put the file where we'd like it
				$upfile = $_FILES['userfile']['name'];
				//--- my additions
				$file_basename = substr($upfile, 0, strripos($upfile, '.')); // strip extention
				$file_ext = substr($upfile, strripos($upfile, '.')); // strip name
				
				// create a thumbnail image -----------------------------------------------------------------------------------------------------------
				list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
					if (!isset($fwidth)) { 
						$fwidth = 400; 
					}
					if ($fwidth == 0){
						if ($width <= 400){
						$thumb = 0;
						}
						else {
						$fwidth = 400;
						}
						
					}
					if ($width > $fwidth AND $fwidth != 0){
						$thumb = 1;
						$nheight = ( $height / $width * $fwidth);
						$uploadedfile = $_FILES['userfile']['tmp_name'];
						$newwidth = $fwidth;
						$newheight = $nheight;
						$tmp = imagecreatetruecolor($newwidth, $newheight);
						if ($_FILES['userfile']['type'] == 'image/gif'){
							$src = imagecreatefromgif($uploadedfile);
						}
						else {
							$src = imagecreatefromjpeg($uploadedfile);
						}
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					}
				// enter a record into avatar database
				//
				$query = "INSERT INTO f_img (d_name, d_src, d_date, d_auth, d_thumb)
				VALUES
				('".$i_name."', '".$_FILES['userfile']['name']."', '".date('Y-m-d')."', '".$_SESSION['u_id']."', 'yes')";
				$result = mysqli_query($link, $query);
				
				if (file_exists("img/f_img/" . $upfile)) {
					// grabs last record from database to get an id for new file name
					$query = "SELECT * FROM f_img WHERE d_auth = ".$_SESSION['u_id']." ORDER BY d_id DESC";
					$result = mysqli_query($link, $query);
					$data = mysqli_fetch_array($result);
					$upfile = 'f_img'.$_SESSION['u_id'].$data[0] . $file_ext;
					// Resize and put into directory
					$filename = "img/f_img/thumb/". $upfile;
					imagejpeg($tmp,$filename,100);
					imagedestroy($src);
					imagedestroy($tmp);
					// --------
					$query = "UPDATE f_img SET d_src = '".$upfile."' WHERE d_id = ".$data[0]."";
					$result  = mysqli_query($query);
				}
				else {
				$filename = "img/f_img/thumb/". $upfile;
					imagejpeg($tmp,$filename,100);
					imagedestroy($src);
					imagedestroy($tmp);
				}
				if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/f_img/'.$upfile)){
					echo 'Problem: Could not move file to destination directory!';
					exit;
				}
			}
			if ($_FILES['userfile']['error'] != 4){ // the 4 means it didn't throw the no file uploaded error
				$query = "UPDATE forum 
				SET f_sub='".$sub."',
	   			f_body='".$fixed;
				if ($thumb == 0) {
					$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/'.$upfile.'"></a>';
				}
				else {
					$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/thumb/'.$upfile.'"></a>';
				}
				$query .= "', f_order='".$order."'
				WHERE f_id = '".$id."'";
				$result = mysqli_query($link, $query);
				if (!$result) {
    				die('Invalid query: ' . mysqli_error($link));
				}
				if ($reply == "yes"){
					$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$sid : '').(isset($sid) ? '&sid='.$id : '');
				}
				else {
					$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$id : '').(isset($sid) ? '&sid='.$sid : '');
       			}
				header( $urlloc ) ;
			}
			else {
				$query = "UPDATE forum 
				SET f_sub='".$sub."',
	   			f_body='".$fixed."'
				WHERE f_id = '".$id."'";// removed f order for now ,	f_order='".$order."'
				$result = mysqli_query($link, $query);
				if (!$result) {
    				die('Invalid forum update query: ' . mysqli_error($link));
				}
       			header( $urlloc ) ;
			}
		}
	}
	// If Insert
	else {
		// to prevent posts more then once a min or so anti spam
		$query = "SELECT * FROM spam WHERE s_auth = '".$_SESSION['u_id']."'";
		$result = mysqli_query($link, $query) or die('Invalid query: ' . mysqli_error($link)) ;
		$count = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
		$legwound = strtotime($row['s_time']) -  strtotime(date('H:i:s'));
			if ($count > 0 && $legwound > -30 && $legwound < 0){
				header ('Location: index.php?mainaction=error&id=2');
			}
			else {
				if ($count == 0){	 // or insert new record if non exists
					$query = "INSERT INTO spam (s_auth, s_time)
					VALUES
					('".$_SESSION['u_id']."', '".date('H:i:s')."')";
					$result = mysqli_query($link, $query) or die('Invalid query: ' . mysqli_error($link)) ;
				}
				else {
					$query = "UPDATE spam SET s_time = '".date('H:i:s')."' WHERE s_auth = '".$_SESSION['u_id']."'";
					$result = mysqli_query($link, $query) or die('Invalid query: ' . mysqli_error($link)) ;
				}
				
			if ($tag == 1 ){
				// don't do the image shit tyvm its a forum and doesn't need a pic
				$query = "INSERT INTO forum (f_sub, f_body, f_auth, f_cat, f_parent, f_date, f_rdate)
				VALUES  
				('".$sub."', '".$body."', '".$_SESSION['u_id']."', '".$cat."', '".$parent."', '".$f_date."','".date('Y-m-d H:i:s')."')";
				$result = mysqli_query($link, $query) or die('Invalid query: ' . mysqli_error($link)) ;
				$urlloc = 'Location: index.php?mainaction=forum';
				header( $urlloc ) ;
			}
			else {
				// do the image shit cause your not adding a category thanks
	
				// ----- handles image upload --------------------------------------------------------------------------------------
	  			if ($_FILES['userfile']['error'] > 0){
					switch ($_FILES['userfile']['error']){
					case 1: echo 'File exceeded upload_max_filesize'; break; exit;
					case 2: echo 'File exceeded max_file_size'; break; exit;
					case 3: echo 'File only partially uploaded'; break; exit;
					//case 4: echo 'No file uploaded'; break;
					}
				}
				if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
					// does the file have the right MIME type?
					$badfile = 0;
					if ($_FILES['userfile']['type'] == 'image/jpeg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/jpg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile']['type'] == 'image/gif'){
						$badfile = 1;	
					}
					elseif ($_FILES['userfile']['type'] == 'image/pjpeg'){
						$badfile = 1;	
					}
					if ($badfile == 0){
								echo 'Problem: file is not a jpeg or a gif image.<br>';
								echo $_FILES['userfile']['type'];
								exit;
					}
					// put the file where we'd like it
					$upfile = $_FILES['userfile']['name'];
					//--- my additions
					$file_basename = substr($upfile, 0, strripos($upfile, '.')); // strip extention
					$file_ext = substr($upfile, strripos($upfile, '.')); // strip name
					// create a thumbnail image -----------------------------------------------------------------------------------------------------------
					list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
					if (!isset($fwidth)) { 
						$fwidth = 400; 
					}
					if ($fwidth == 0){
						if ($width <= 400){
						$thumb = 0;
						}
						else {
						$fwidth = 400;
						}
						
					}
					if ($width > $fwidth AND $fwidth != 0){
						$thumb = 1;
						$nheight = ( $height / $width * $fwidth);
						$uploadedfile = $_FILES['userfile']['tmp_name'];
						$newwidth = $fwidth;
						$newheight = $nheight;
						$tmp = imagecreatetruecolor($newwidth, $newheight);
						if ($_FILES['userfile']['type'] == 'image/gif'){
							$src = imagecreatefromgif($uploadedfile);
						}
						else {
							$src = imagecreatefromjpeg($uploadedfile);
						}
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					}
									// enter a record into avatar database
				
					$query = "INSERT INTO f_img (d_name, d_src, d_date, d_auth, d_thumb)
					VALUES
					('".$i_name."', '".$_FILES['userfile']['name']."', '".date('Y-m-d')."', '".$_SESSION['u_id']."', 'yes')";
					$result = mysqli_query($link, $query);
				
					if (file_exists("img/f_img/" . $upfile)) {
						// grabs last record from database to get an id for new file name
						$query = "SELECT * FROM f_img WHERE d_auth = ".$_SESSION['u_id']." ORDER BY d_id DESC";
						$result = mysqli_query($link, $query);
						$data = mysqli_fetch_array($result);
						$upfile = 'f_img'.$_SESSION['u_id'].$data[0] . $file_ext;
						// Resize and put into directory
						$filename = "img/f_img/thumb/". $upfile;
						imagejpeg($tmp,$filename,100);
						imagedestroy($src);
						imagedestroy($tmp);
						// --------
						$query = "UPDATE f_img SET d_src = '".$upfile."' WHERE d_id = ".$data[0]."";
						$result  = mysqli_query($link, $query);
					}
					else {
						$filename = "img/f_img/thumb/". $upfile;
						imagejpeg($tmp,$filename,100);
						imagedestroy($src);
						imagedestroy($tmp);
					}
					if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/f_img/'.$upfile)){
						echo 'Problem: Could not move file to destination directory!';
						exit;
					}
				}
				if ($_FILES['userfile']['error'] != 4){ // the 4 means it didn't throw the no file uploaded error
					//---- if its the first image you've added create the post else update the post
					$query = "INSERT INTO forum (f_sub, f_auth, f_cat, f_parent, f_date, f_rdate, f_body)
					VALUES 
					('".$sub."', '".$_SESSION['u_id']."', '".$cat."', '".$parent."', '".$f_date."','".date('Y-m-d H:i:s')."'," ;
					$query .= "'".$body;
					if ($thumb == 0) {
						$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/'.$upfile.'"></a>';
					}
					else {
						$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/thumb/'.$upfile.'"></a>';
					}
					$query .= "')";
					$result = mysqli_query($link, $query);
					if (!$result) {
    					die('Invalid query: ' . mysqli_error($link));
					}
					
					if ($reply == "yes"){
						$sid = mysqli_insert_id();
						$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$id : '').(isset($sid) ? '&sid='.$sid : '');
						//echo $urlloc;
					}
					else {
						$id = mysqli_insert_id();
						$sid = mysqli_insert_id();
						$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$id : '').(isset($sid) ? '&sid='.$sid : '');
       				}
					header( $urlloc ) ;
				}
				else {
					//----------------------
					$fixed = str_replace("'", "&gay", $body);
					$query = "INSERT INTO forum (f_sub, f_body, f_auth, f_cat, f_parent, f_date, f_rdate)
					VALUES  
					('".$sub."', '".$fixed."', '".$_SESSION['u_id']."', '".$cat."', '".$parent."', '".$f_date."','".date('Y-m-d H:i:s')."')";
					$result = mysqli_query($link, $query) or die('Invalid forum insert query: ' . mysqli_error($link)) ;
					//echo $query;
					if ($parent != 0){
						$wtf = "UPDATE forum SET f_reply = 1, f_rdate = '".date('Y-m-d H:i:s')."' WHERE f_id = '".$parent."'";
						$result = mysqli_query($link, $wtf) or die('Invalid forum update query: ' . mysqli_error($link)) ;
					}
					header( $urlloc ) ;
				}
			}
		}
	}
}
// New Poll insert ---------------------------------------------------------------------------------------
elseif ($_POST['action'] == 'poll'){
	if ($_POST['subaction'] != 'vote'){
	$mdate = $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':00';
	$query = "INSERT INTO poll ( p_question, p_end, p_date, p_auth, p_opt1, p_opt2, p_opt3, p_opt4, p_opt5, p_opt6, p_opt7)
		VALUES
		('".$p_question."','".$mdate."', '".$p_date."', '".$p_auth."', '".$p_opt1."', '".$p_opt2."','".$p_opt3."','".$p_opt4."','".$p_opt5."','".$p_opt6."','".$p_opt7."')";
		$result = mysqli_query($link, $query);
		if (!$result) {
   		 echo $query.'<br>';
		 //die('Invalid query: ' . mysqli_error("Insert failed:"));
		}
		else {
		  header( 'Location: index.php' ) ;
		}
	}
	// Poll Vote insert 
	else {
		$query = "SELECT pd_userid FROM poll_data WHERE pd_userid = '".$_SESSION['u_id']."' AND p_id = '".$p_id."'";
		$result = mysqli_query($link, $query);
		$count = mysqli_num_rows($result);
		if ($count == 1){
			echo 'Sorry only one vote allowed per account.';
		}
		else {
		$query = "INSERT INTO poll_data (pd_pollid, pd_userid, pd_vote)
			VALUES
			('".$p_id."','".$_SESSION['u_id']."','".$p_opt."')";
			$result = mysqli_query($link, $query);
			if (!$result) {
   				die('Invalid query: ' . mysqli_error($link));
			}
		}
    header( 'Location: index.php' ) ;
	}
}

?>
