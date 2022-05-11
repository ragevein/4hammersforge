<div class="container">
	<div class="card">
<?php // ---------------------- lewtchest ---------------------------------	
$yesterday = date("Y-m-d", strtotime('-24 hours', time()));
$y24 = date("Y-m-d H:m:s", strtotime('-24 hours', time()));
if ($lewtaction == 'lewtchest'){
	echo '<div class="content">';
	//$24hr_ago = strtotime(date('Y-m-j h:m:s'));
	//$date = (new \DateTime())->modify('-24 hours');
	
	//$date = new DateTime('Y-m-d H:m:s');
	//$date->modify('+1 day');
	//$ago24 = $date->format('Y-m-d H:m:s');


	//$yesterday = 1;
	$date = date("Y-m-d");
	//$today = date('Y-m-j h:m:s');// you need to fix this
	$sql = "SELECT * FROM transactions WHERE t_init_user = '".$_SESSION['u_id']."' AND t_date = '".$date."' AND t_type = 0 AND t_limbo = 0";
	echo '<h2>Exploration:</h2>';
	$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
	$records = mysqli_num_rows($result);
	if ($records == 1){
		$lewted = 1;
	}
	if ($lewted == 1){
		$message = 'You have already lewted today. Go find something else to do.';
	}
	else {				
		// find random treasurechest scenario from dbase
		

		$gold = rand(2, 26);
		//echo 'Redoing this section, I will make it more interactive but for now all rolls/math are done server side.<br>';
		if ($roll == 1){

			$dice_array = array();

			$sql = "SELECT * FROM goal_data WHERE g_user = '".$_SESSION['u_id']."' AND g_date = '".$date."' ";
			$query = mysqli_query($link, $sql);
			$recordcount = mysqli_num_rows($query);
			$total = ($recordcount+1);
			for ($i =1; $i <= $total; $i++){
				$roll = rand(1, 6);
				//echo 'dice '.$i.' rolled: '.$roll.'<br>';
				$d_total = ($d_total+$roll);
				$dice_array[] = $roll;
				$t_dice .= $roll.',';
			}
			$t_dice = rtrim($t_dice, ", ");  //removes the last comma in the array

			$sql = "SELECT * FROM game_events WHERE ge_type = 0 ORDER BY RAND() LIMIT 1 ";
			$query = mysqli_query($link, $sql);
			$scenario = mysqli_fetch_array($query);

			$body = str_replace("&pro", $_SESSION['pro'], $scenario['ge_body']);
			echo 'Your explorations net you '.$d_total.' total gold. <br>';

			foreach ($dice_array as &$value){
				for ($i = 1; $i < 7; $i++){ // loop through the 6 dice
					if ($value == $i){
						echo '<img src="img/dice'.$i.'.png" class="die">';
					}
				}
			}
			unset($value);

			$unique = array_unique($dice_array);
			$duplicates = array_diff_assoc($dice_array, $unique);
			//print_r($duplicates);
			$dupe_count = count($duplicates);
			$exp = 5;
			//echo '<br> '.$d_total.' coins have been added to your treasury.<br>';
			if ($dupe_count > 0) {
				echo '<br>You got lucky and rolled ';
				if ($dupe_count == 1) {
				echo 'Doubles';
				$dupe = 2;
				}
				elseif ($dupe_count == 2) {
				echo 'Triplets';
				$dupe = 3;
				}
				elseif ($dupe_count == 3) {
				echo 'Quadruplets';
				$dupe = 4;
				}
				elseif ($dupe_count == 4) {
				echo '5';
				$dupe = 5;
				}
				elseif ($dupe_count == 5) {
				echo '6';
				$dupe = 6;
				}
				echo ' <br>click the dice below to start a rare scenario ';
				//

				$sql = "UPDATE users SET u_coin = u_coin + ".$d_total.", u_exp = u_exp + ".$exp." WHERE u_id = ".$_SESSION['u_id']." ";
				$result = mysqli_query($link, $sql) or die ('Error Query Failed update gold '.mysqli_error($link));
				//update transactions
				$query = "INSERT INTO transactions (t_init_user, t_type, t_items, t_date, t_amount, t_exp, t_limbo, t_dice) VALUES ('".$_SESSION['u_id']."', 0, 0, '".$date."', '".$d_total."', '".$exp."', 1, '".$t_dice."')";
				
				$result = mysqli_query($link, $query) or die ('Error Query Failed transactions insert '.mysqli_error($link));
				
			echo ' <div id="dice"><a href="index.php?mainaction=lewt&lewtaction=lewtchest&roll=2&dupe='.$dupe.'">	  
			<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" id="d-6"><defs><style>.c{fill:#fcee21;}</style></defs><g id="a"><g><rect class="c" x=".5" y=".5" width="29" height="29" rx="2.5" ry="2.5"/><path d="M27,1c1.1,0,2,.89,2,2V27c0,1.1-.89,2-2,2H3c-1.1,0-2-.89-2-2V3c0-1.1,.89-2,2-2H27m0-1H3C1.34,0,0,1.34,0,3V27c0,1.65,1.34,3,3,3H27c1.65,0,3-1.34,3-3V3c0-1.65-1.34-3-3-3h0Z"/></g></g><g id="b"><g><circle cx="7.5" cy="6.5" r="2"/><path d="M7.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="14.5" r="2"/><path d="M7.5,13c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="23.5" r="2"/><path d="M7.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="23.5" r="2"/><path d="M22.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="14.5" r="2"/><path d="M22.5,13c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="6.5" r="2"/><path d="M22.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g></g></svg>';
			echo '<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" id="d-5"><defs><style>.c{fill:#fcee21;}</style></defs><g id="a"><g><rect class="c" x=".5" y=".5" width="29" height="29" rx="2.5" ry="2.5"/><path d="M27,1c1.1,0,2,.89,2,2V27c0,1.1-.89,2-2,2H3c-1.1,0-2-.89-2-2V3c0-1.1,.89-2,2-2H27m0-1H3C1.34,0,0,1.34,0,3V27c0,1.65,1.34,3,3,3H27c1.65,0,3-1.34,3-3V3c0-1.65-1.34-3-3-3h0Z"/></g></g><g id="b"><g><circle cx="7.5" cy="6.5" r="2"/><path d="M7.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="15" cy="15.5" r="2"/><path d="M15,14c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="23.5" r="2"/><path d="M7.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="23.5" r="2"/><path d="M22.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="6.5" r="2"/><path d="M22.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g></g></svg></a><br>';  
			echo '</a></div>';
			}
			else {// no scenario just input the gold

				$sql = "UPDATE users SET u_coin = u_coin + ".$d_total.", u_exp = u_exp + ".$exp." WHERE u_id = ".$_SESSION['u_id']." ";
				$result = mysqli_query($link, $sql) or die ('Error Query Failed update gold '.mysqli_error($link));
				//update transactions
				$query = "INSERT INTO transactions (t_init_user, t_type, t_items, t_date, t_amount, t_exp, t_dice) VALUES ('".$_SESSION['u_id']."', 0, 0, '".$date."', '".$d_total."', '".$exp."', '".$t_dice."')";
				$result = mysqli_query($link, $query) or die ('Error Query Failed transactions insert '.mysqli_error($link));
			}
			echo '<br><br>';	
			echo '<br><br>';
			echo '<br>';
		}
		elseif ($roll == 2){
			$sql = "SELECT * FROM game_events WHERE ge_type = 0 AND ge_dice = $dupe ORDER BY RAND() LIMIT 1 ";
			$query = mysqli_query($link, $sql);
			$scenario = mysqli_fetch_array($query);
			$roll1 = rand(1, 20);
			$gold = rand(5, 15);
			$body = str_replace("&pro", $_SESSION['pro'], $scenario['ge_body']);
			echo replace($body).'<br><br>';
			if ($roll1 <=8 ){

				$fail = str_replace("&g", $gold, $scenario['ge_fail']);
				$fail = str_replace("&pro", $_SESSION['pro'], $fail);
				echo 'You rolled a '.$roll1.'<br>';
				echo replace($fail).'<br>';
				$sql = "UPDATE users SET u_coin = u_coin - '".$gold."' WHERE u_id = '".$_SESSION['u_id']."' ";
				$result = mysqli_query($link, $sql) or die ('Error Query Failed update gold '.mysqli_error($link));
				$message = ''.$gold.' coins have been removed from your treasury. Better luck next time, you should inspire your friends to play by mugging them.';
				//update transactions
				$query = "UPDATE transactions SET t_amount = t_amount + $gold, t_limbo = 0, t_scenario = '".$scenario['ge_id']."', t_roll = ".$dupe." WHERE t_init_user = '".$_SESSION['u_id']."' AND t_date = '".$date."' AND t_affect_user = 0 ";
				$result = mysqli_query($link, $query) or die ('Error Query Failed transactions insert '.mysqli_error($link));
			}
			else {		
				$gold = rand(5, 15);
				if ($dupe == 2){
					$gold = $gold+10;
				}	
				elseif ($dupe == 3){
					$gold = $gold+15;
				}
				elseif ($dupe == 4){
					$gold = $gold+20;
				}
				elseif ($dupe == 5){
					$gold = $gold+25;
				}
				elseif ($dupe == 6){
					$gold = $gold+30;
				}
				$success = str_replace("&g", $gold, $scenario['ge_success']);
				$success = str_replace("&pro", $_SESSION['pro'], $success);	
				if ($roll1 == 20){
					$gold = $gold+10;
					echo 'You rolled a natural 20! You get 10 extra gold.<br>';
				}
					echo 'You rolled a '.$roll1.'<br>';
					echo replace($success).'<br>';
				
					echo 'Try exploring again tomorrow.';
					// update your gold
					$sql = "UPDATE users SET u_coin = u_coin + ".$gold." WHERE u_id = '".$_SESSION['u_id']."' ";
					$result = mysqli_query($link, $sql) or die ('Error Query Failed update gold '.mysqli_error($link));
					$message = ''.$gold.' coins have been added to your treasury, you should inspire your friends to play by mugging them.';
					//update transactions
					$query = "UPDATE transactions SET t_amount = t_amount + ".$gold.", t_limbo = 0, t_scenario = '".$scenario['ge_id']."', t_roll = ".$dupe." WHERE t_init_user = '".$_SESSION['u_id']."' AND t_date = '".$date."' AND t_affect_user = 0 ";
					$result = mysqli_query($link, $query) or die ('Error Query Failed transactions insert '.mysqli_error($link));
			}
		}
		else {
			echo 'You get a dice roll for every goal you complete so run this at the end of your day<br>';
			
			$sql = "SELECT * FROM goal_data WHERE g_user = '".$_SESSION['u_id']."' AND g_date = '".$date."' ";
			$query = mysqli_query($link, $sql);
			$recordcount = mysqli_num_rows($query);
			
			for ($i = 1; $i <= $recordcount; $i++){
				$row = mysqli_fetch_array($query);
				//echo 'Completed quests: Dice '.$i.':<br>';	
			}

			echo '1 Dice for logging in plus '.$recordcount.' completed quests = '.($recordcount+1).' D6';
			echo '<div id="dice"><a href="index.php?mainaction=lewt&lewtaction=lewtchest&roll=1"> ';
			echo '<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" id="d-6"><defs><style>.c{fill:#fcee21;}</style></defs><g id="a"><g><rect class="c" x=".5" y=".5" width="29" height="29" rx="2.5" ry="2.5"/><path d="M27,1c1.1,0,2,.89,2,2V27c0,1.1-.89,2-2,2H3c-1.1,0-2-.89-2-2V3c0-1.1,.89-2,2-2H27m0-1H3C1.34,0,0,1.34,0,3V27c0,1.65,1.34,3,3,3H27c1.65,0,3-1.34,3-3V3c0-1.65-1.34-3-3-3h0Z"/></g></g><g id="b"><g><circle cx="7.5" cy="6.5" r="2"/><path d="M7.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="14.5" r="2"/><path d="M7.5,13c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="23.5" r="2"/><path d="M7.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="23.5" r="2"/><path d="M22.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="14.5" r="2"/><path d="M22.5,13c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="6.5" r="2"/><path d="M22.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g></g></svg>';
			echo '<?xml version="1.0" encoding="UTF-8"?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30" id="d-5"><defs><style>.c{fill:#fcee21;}</style></defs><g id="a"><g><rect class="c" x=".5" y=".5" width="29" height="29" rx="2.5" ry="2.5"/><path d="M27,1c1.1,0,2,.89,2,2V27c0,1.1-.89,2-2,2H3c-1.1,0-2-.89-2-2V3c0-1.1,.89-2,2-2H27m0-1H3C1.34,0,0,1.34,0,3V27c0,1.65,1.34,3,3,3H27c1.65,0,3-1.34,3-3V3c0-1.65-1.34-3-3-3h0Z"/></g></g><g id="b"><g><circle cx="7.5" cy="6.5" r="2"/><path d="M7.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="15" cy="15.5" r="2"/><path d="M15,14c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="7.5" cy="23.5" r="2"/><path d="M7.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="23.5" r="2"/><path d="M22.5,22c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g><g><circle cx="22.5" cy="6.5" r="2"/><path d="M22.5,5c.83,0,1.5,.67,1.5,1.5s-.67,1.5-1.5,1.5-1.5-.67-1.5-1.5,.67-1.5,1.5-1.5m0-1c-1.38,0-2.5,1.12-2.5,2.5s1.12,2.5,2.5,2.5,2.5-1.12,2.5-2.5-1.12-2.5-2.5-2.5h0Z"/></g></g></svg>';
			echo '</a></div>';
		}
	}

	echo '<p>'.$message.'</p></div>';
	if ($roll == 1){
		if ($scenario['ge_img'] == ""){
			echo '<img src="img/warsilo.png" alt="" id="silo">';
		}
		else {
			// img from 
		}

	}
	else {
		if ($_SESSION['pro'] == 'his'){
			echo '<img src="img/warsilo.png" alt="Male Warrior" id="silo">';
		}
		elseif ($_SESSION['pro'] == 'her'){
			echo '<img src="img/femalesilo.png" alt="Female Warrior" id="silo">';
		}
		else {
			echo '<img src="img/golem.png" alt="Golem" id="silo">';
		}	
	}
	

}
elseif ($lewtaction == 'pick') {
	$sql = "SELECT * FROM transactions INNER JOIN game_events ON transactions.t_scenario = game_events.ge_id WHERE t_type > 0 ORDER BY t_id DESC";
    $result = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($result);

	$body = str_replace("&g", $gold, $row['ge_body']);
	$body = str_replace("&pro", $_SESSION['pro'], $body);	
	$body = replace($body);

	$success = str_replace("&g", $gold, $row['ge_success']);
	$success = str_replace("&pro", $_SESSION['pro'], $success);	
	$success = replace($success);

	$fail = str_replace("&g", $gold, $row['ge_fail']);
	$fail = str_replace("&pro", $_SESSION['pro'], $fail);	
	$fail = replace($fail);

	echo '<div class="content">';
	//echo $sql.'<br>';
	if ($results == 1){
		echo '<h2>Successfull loot </h2><p>You Rolled a '.$row['t_roll'].'</p><p>'.$body.'</p><p>2.'.$success.'</p>';
	}
	elseif ($results == 2){
		echo '<h2>Failed.  Better luck next time</h2><p>You Rolled a '.$row['t_roll'].'</p><p>'.$body.'</p><p>'.$fail.'</p>';		
	}
	elseif ($results == 3){
		echo '<h2>Critical Fail.  You lost x money to defender</h2><p>You Rolled a '.$row['t_roll'].'</p><p>'.$body.'</p><p>'.$fail.'</p>';		
	}
	else {
	$sql = "SELECT * FROM users WHERE u_id = ".$_SESSION['u_id']."";
	$query = mysqli_query($link, $sql);
	$urow = mysqli_fetch_array($query);

	echo '<form action="process.php" method="post" name="muggin">
	<input type="hidden" name="attacker" value="'.$_SESSION['u_id'].'">
	<input type="hidden" name="roll" id="roll" value="1">
	<input type="hidden" name="attacker_coin" value="'.$urow['u_coin'].'">
	<input type="hidden" name="type" value="1">
	<input type="hidden" name="action" value="pillage">
	<input type="hidden" name="amount" id="gold_stolen" value="">
	<input type="hidden" name="items" id="items" value="0">';
	$duder = mktime(date("H"),date("m"),date("s"),date("m"),date("d"),date("Y"));
	$wayold = mktime(date("H"),date("m"),date("s"),date("m"),date("d")-30,date("Y"));
	$olddate = date('Y-m-d H:m:s', $duder);
	$wayold = date('Y-m-d H:m:s', $wayold);
	$today = date('Y-m-d H:m:s');

	$sql = "SELECT * FROM users WHERE u_coin > 0 AND u_id != '".$_SESSION['u_id']."' ";
	$result = mysqli_query($link, $sql) or die ('Error Query Failed find transactions '.mysqli_error($link));
	$records = mysqli_num_rows($result);
	
	echo "<h1>Let's Go Muggin</h1>";
	
	echo "Choose your victim:";
	echo '<table><tr><td>';
	echo '<select name="target">';
	for ($i = 1; $i <= $records; $i++){ 
		$row = mysqli_fetch_array($result);		
		// defenders info and ratio

		$sql = "SELECT * FROM transactions WHERE t_affect_user = ".$row['u_id']." AND t_stamp > '".$y24."' ";
		$gquery = mysqli_query($link, $sql);		
		$tcount = mysqli_num_rows($gquery);

		if ($tcount == 1){

		}
		else {

		$sql = "SELECT * FROM goal_data WHERE g_user = ".$row['u_id']." AND g_type = 0 AND g_date = '".$yesterday."' ";
		$gquery = mysqli_query($link, $sql);		
		$gdcount = mysqli_num_rows($gquery);
		
		$sql = "SELECT * FROM goal WHERE g_user = ".$row['u_id']." AND g_type = 0 ";
		$gquery = mysqli_query($link, $sql);
		$gcount = mysqli_num_rows($gquery);
		$ratio = round($gdcount/$gcount, 0)*100;
		//ratio not sure if i want this known or not
		echo '<option value="'.$row['u_id'].'">'.$row['u_name'].' Kingdom of '.$row['u_kingdom'].'</option>';
		}	
	}
	echo '</select>';
	echo '</td>';
	echo '</tr></table>';
	// get attackers ratio
	$sql = "SELECT * FROM goal_data WHERE g_user = ".$_SESSION['u_id']." AND g_type = 0 AND g_date = '".$yesterday."' ";
	$gquery = mysqli_query($link, $sql);		
	$gdcount = mysqli_num_rows($gquery);
	
	$sql = "SELECT * FROM goal WHERE g_user = ".$_SESSION['u_id']." AND g_type = 0 ";
	$gquery = mysqli_query($link, $sql);
	$gcount = mysqli_num_rows($gquery);
	//$ratio = round($gdcount/$gcount, 0)*100;
	$aratio = round(($gdcount/$gcount)*100, 0, PHP_ROUND_HALF_UP);
	echo '<input type="hidden" name="a_goals" value="'.$gcount.'">';
	echo '<input type="hidden" name="a_gcompleted" value="'.$gdcount.'">';
	echo '<input type="hidden" name="a_ratio" value="'.$aratio.'">';

	echo '<br>Choose your attack method:';
	$sql = "SELECT * FROM game_events WHERE ge_type = 1 AND ge_level <= ".$urow['u_rank']." ";
	$query = mysqli_query($link, $sql);
	$result = mysqli_num_rows($query);
		echo '<select name="event">';
		for ($i = 1; $i <= $result; $i++){ 
			$row = mysqli_fetch_array($query);
			echo '<option value="'.$row['ge_id'].'">'.$row['ge_desc'].'</option>';
		}
		echo '</select>';
	echo '<br><br><input type="submit" value="ATTACK" class="slider">';
	echo '<br></form>';
	}
echo '</div>';

// ----------------------- end ---------------------------------------
		if ($_SESSION['pro'] == 'his'){
			echo '<img src="img/warsilo.png" alt="Male Warrior" id="silo">';
		}
		elseif ($_SESSION['pro'] == 'her'){
			echo '<img src="img/femalesilo.png" alt="Female Warrior" id="silo">';
		}
		else {
			echo '<img src="img/golem.png" alt="Golem" id="silo">';
		}	 
}
else {
echo 'hmm....';
}
?>
	</div>		
</div>
