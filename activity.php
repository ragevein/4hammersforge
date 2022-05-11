 <?php 
 echo '		<tr>
		  		<td><b class="12">Activity since last login</b><br><img src="img/header/gray.jpg" width="187" height="1" alt=""><br>
				<b class="bop">';
				
				$sql = "SELECT * FROM forum WHERE f_date > '".$_SESSION['old_date']."' AND f_auth != '".$_SESSION['u_id']."' ".($_SESSION['dark'] == 1 ? "" : "AND f_cat != 421 ");
				if($result = mysqli_query($link, $sql)){
					//$result = mysql_query($wtf) or die(mysql_error(). 'activity query failed.');
					$reply = 0;
					$post = 0;
					$numrows = mysqli_num_rows($result);
					for ($i = 0; $i < $numrows; $i++){
						$row = mysqli_fetch_array($result);
						if ($row['f_parent'] == 0){
							$post = $post+1;
							echo 'New Post - '.$row['f_sub'].' by '.$row['f_auth'].' <br>';
						}
						else {
							$reply = $reply+1;
							echo 'Reply by '.$row['f_auth'];
						}
					}
					echo $post.' Posts '.$reply.' Replies<br>';
				}
				else {
				echo 'Failed query';
				}
				echo '</b></td>
			  </tr>';
			  
?>