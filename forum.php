<?php 
$sql = "SELECT * FROM forum WHERE f_cat != 0 AND f_arch = 0";
if($resul1 = mysqli_query($link, $sql)){}
//$resul1 = mysql_query($argh) or die ("Failed query");
$rcounts = mysqli_num_rows($resul1);
	for ($i = 0; $i < $rcounts; $i++){
		$row1 = mysqli_fetch_array($resul1);
		if ($row1['f_parent'] == 0){
		$tpost = $tpost+1;
		}
		else {
		$treply = $treply+1;
		}
	}
$sql = "SELECT * FROM forum WHERE f_cat = 0 AND f_arch = 0";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ("Category Query failed");
echo '<table cellpadding="5" cellspacing="1">';  
	
	
	for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$n_row = mysqli_fetch_array($result);
		if ($n_row['f_id'] != 1 && !isset($_SESSION['login'])){
		//echo "Your not a member and can't see the private forums.";
		}
		elseif($n_row['f_dark'] == 1 && $_SESSION['dark'] != 1){
			
		}
		else {
			if ($subaction == edit && $n_row['f_id'] == $sid){
				echo '<form action="process.php" method="post" name="forum"><input type="Hidden" name="action" value="forum"><input type="Hidden" name="sub_action" value="update"><input type="Hidden" name="id" value="'.$n_row['f_id'].'"';
				echo '<tr><td bgcolor="#000000"><li><input type="Text" size="89" name="sub" value="'.$n_row['f_sub'].'">';
				echo '</td><td align="right" bgcolor="#000000">'.date("n-j-y", strtotime($n_row['f_date'])).'</td><td width="25"></td></tr><tr><td colspan="3" bgcolor="#000000">';
				echo '<p><textarea rows="9" cols="75" name="body">'.$n_row['f_body']. '</textarea><input type="Submit"></p>';
				echo '</form>';
				echo '</td></tr>';
			}
			else {
				echo '<tr><td colspan="3" bgcolor="#000000"><li>'. $n_row['f_sub'];
				if (isset($_SESSION['login']) && $_SESSION['sec'] == 3){
					echo '<a href="'.$url.'?mainaction=forum&subaction=edit&sid='.$n_row['f_id'].'" class="green">&nbsp;&nbsp; Edit</a> | <a href="index.php?mainaction=del&sub=forum&sid='.$n_row['f_id'].'" class="red">Del</a> | <a href="index.php?mainaction=post&cat='.$n_row['f_id'].'&tag=1" class="blue">Add Forum</a>';
				}
			echo '<br>&nbsp;&nbsp;'.$n_row['f_body'].'</li>';
			
			echo '</td></tr>';
				// pulls up forums under this category
				$sql = "SELECT * FROM forum WHERE f_cat = '".$n_row['f_id']."' AND f_arch = 0 ORDER BY f_order DESC, f_sub";
				if($result2 = mysqli_query($link, $sql)){}
				//$result2 = mysql_query($query2) or die ("Forum Query failed");
				for ($e = 0; $e < mysqli_num_rows($result2); $e++){
					$n_row2 = mysqli_fetch_array($result2);
					if ($subaction == edit && $n_row2['f_id'] == $sid){
						echo '<form action="process.php" method="post" name="forum"><input type="Hidden" name="action" value="forum"><input type="Hidden" name="sub_action" value="update"><input type="Hidden" name="id" value="'.$n_row2['f_id'].'"';
						echo '<tr><td bgcolor="#000000"><input type="Text" size="89" name="sub" value="'.$n_row2['f_sub'].'">';
						echo '</td><td align="right" bgcolor="#000000">'.date("n-j-y", strtotime($n_row2['f_date'])).'</td><td width="25"></td></tr><tr><td colspan="3" bgcolor="#000000">';
						echo '<p><textarea rows="4" cols="75" name="body">'.$n_row2['f_body']. '</textarea><input type="Submit"></p>';
						if ($tag == 1){
						echo '<input type="Hidden" name="tag" value="1">';
						}
						echo '</form>';
						echo '</td></tr>';
					}
					else {
					// show if a new thread was added
					$sql = "SELECT * FROM forum WHERE f_date > '".$_SESSION['old_date']."' AND f_cat = '".$n_row2['f_id']."' AND f_arch = 0";
					if($nresult = mysqli_query($link, $sql)){}
					//$nresult = mysqli_query($nquery);
					$numrows = mysqli_num_rows($nresult);
					echo '<tr '.($numrows > 0 ? 'bgcolor="#361111"' : 'bgcolor="#1A2431"').'><td><a href="index.php?mainaction=thread&cat='.$n_row2['f_id'].'" class="nav">'. $n_row2['f_sub'].'</a><br>';		
					echo '&nbsp;'.$n_row2['f_body'].'';
					if ($numrows > 0){
					echo '<span class="eight">&nbsp;&nbsp;&nbsp; ('.$numrows.' new posts)</span>';
					}
					if (isset($_SESSION['login']) && $_SESSION['sec'] == 3){
						echo '<a href="'.$url.'?mainaction=forum&subaction=edit&sid='.$n_row2['f_id'].'&tag=1" class="green">&nbsp;&nbsp; Edit</a> | <a href="index.php?mainaction=del&sub=forum&sid='.$n_row2['f_id'].'" class="red">Del</a>';
					}
					$sql3 = "SELECT * FROM forum WHERE f_cat = '".$n_row2['f_id']."' AND f_parent = 0 AND f_arch = 0";
					$sql6 = "SELECT * FROM forum WHERE f_cat = '".$n_row2['f_id']."' AND f_parent != 0 AND f_arch = 0";
					if($result3 = mysqli_query($link, $sql3)){}
					if($result6 = mysqli_query($link, $sql6)){}
					//$result6 = mysql_query($query6) or die ("Forum Query failed");
					//$result3 = mysql_query($query3) or die ("Forum Query failed");
					$numrows = mysqli_num_rows($result3);
					$numrows2 = mysqli_num_rows($result6);
					$sql9 = "SELECT * FROM forum WHERE f_cat = '".$n_row2['f_id']."' AND f_arch = 0 ORDER BY f_date DESC";
					if($result9 = mysqli_query($link, $sql9)){}
					//$result9 = mysql_query($query9) or die ("Forum Query failed");
					$row9 = mysqli_fetch_array($result9);
									
					//this is necessary because thread-creating posts have a parent of 0
					if ($row9['f_parent'] == "0"){
						$newID = $row9['f_id'];
					}
					else
						$newID = $row9['f_parent'];
					$newCat = $row9['f_cat'];
					
					//note: "Newest post" seems a bit large as a hyperlink - added class green to change font size color
						
					//echo '<td>Newest post - '.time_since(strtotime($row9['f_date'])).' </td></td><td>'.$numrows.' posts '.$numrows2.' replies &nbsp;&nbsp;';
					echo '<td><a href="index.php?mainaction=vthread&id='.$newID.'&cat='.$newCat.'" class="green">Newest post</a>  - '.time_since(strtotime($row9['f_date'])).' </td></td><td>'.$numrows.' posts '.$numrows2.' replies &nbsp;&nbsp;';
					
					echo '</td></tr>';
					}
				}
			}
		}
	}

echo '</tr><tr bgcolor="#1A2431">
			    <td colspan="2">
				Total Threads = '.$tpost.' Replies = '.$treply.'
				</td>
				<td>';
				if (isset($_SESSION['login']) && $_SESSION['sec'] == 3){
					echo '<a class="nav" href="index.php?mainaction=post&cat=0">Add Category</a>';
				}
				echo '</td>
			  </tr>';
		
?><tr><td colspan="3"><img src="img/header/spacer.gif" height="2" width="938"></td></tr>
</td>
</tr>
</table>

