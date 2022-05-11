<?php 
	$table = 'news';
	if (!$offset){
		$offset = 0;
	}
	$sql = "SELECT n_id FROM ".$table." WHERE n_arch = 0 && n_publish = 0";
	if($result = mysqli_query($link, $sql)){
	}
	//$result = mysql_query($query) or die ("News Query failed". mysql_error());
	$vpage	= mysqli_num_rows($result);
	$tpages = ceil(mysqli_num_rows($result)/5);
	
	$sql = "SELECT * FROM ".$table." WHERE n_arch = 0 && n_publish = 0 Order By n_id DESC LIMIT 5 OFFSET ".$offset."";
	if($result = mysqli_query($link, $sql)){
		
	}
	else{
		echo 'news query failed';
	}
		echo '<div class="news">';
		
		$i = 0;
		for ($i = 0; $i < mysqli_num_rows($result); $i++){
			$n_row = mysqli_fetch_array($result);
			$sql2 = "SELECT * FROM comment WHERE com_npost = ".$n_row['n_id']." ";
			if($result2 = mysqli_query($link, $sql2)){
			}
			else {
				echo 'comments fail';
			}
			//$rresult = mysql_query($rquery) or die ("News page". mysql_error());
			$comments = mysqli_num_rows($result2);
			echo '<div class="article">
				<table>';
			$sql3 ="SELECT * FROM users WHERE u_id = '".$n_row['n_auth']."'";
			if($result3 = mysqli_query($link, $sql3)){
			}
			//$resul = mysql_query($quer) or die ("Cant look up user");
			$ro = mysqli_fetch_array($result3);
			$ntitle = str_replace("&gay", "'", $n_row['n_title']);
				echo '<tr><td rowspan="3"><img src="img/header/spacer.gif" width="3" height="245" border="0"></td>
				<td colspan="2"><img src="img/header/spacer.gif" width="670" height="3" border="0"></td></tr>
				<tr><td colspan="2"><h1>'. $ntitle.'</h1>
				'.time_since(strtotime($n_row['n_date'])).' ago by  <a href="index.php?mainaction=profile&sub=user&sid='.$ro['u_id'].'"> '.$ro[3].'</a>';
				if ($comments > 0){
				echo ' &nbsp;<i><a href="index.php?mainaction=story&id='.$n_row['n_id'].'">('.$comments.' Comments)</a></i>';
				//echo ' &nbsp;<b class="blue"> ('.$comments.' Comments)</b>';
					}
					//'.date("M jS", strtotime($n_row['n_date'])).'
				if (isset($_SESSION['login']) && $_SESSION['sec'] == 3){
					echo '&nbsp;&nbsp;&nbsp;<a href="index.php?mainaction=addnews&subaction=edit&sid='.$n_row['n_id'].'" class="green"> Edit</a> | 
					<a href="index.php?mainaction=del&sub=news&sid='.$n_row['n_id'].'">Del</a>
					';
					//if (strlen($n_row['n_body']) >  50){
						//echo ' String Length '.strlen($n_row['n_body']);
					//}
				}
				echo '</td>
				</tr><tr><td width="170">';
					if ($n_row['n_img'] == 1){
						echo '<img src="img/news/logo/'.$n_row['n_img_src'].'" height="150" width="150" hspace="10" vspace="0">';
					}
					else {
						echo '<img src="img/news/logo/news.gif" height="150" width="150" hspace="10" vspace="0">';
					}

				echo '<br></td><td>';

			$nsub = str_replace("&gay", "'", $n_row['n_sub']);
			echo '<p>'.$nsub.'</p><p><a href="index.php?mainaction=story&id='.$n_row['n_id'].'" class="blue">Full Story</a></p>'; 
			echo '<img src="img/header/spacer.gif" width="510" height="3" border="0"></td></tr>';
		echo '</table></div>';
		}
		
			// Pagination area ///////////////////////////////////////////////////////////////
		$bu = 0;
		$last = ($tpages*5) - 5;
		$big = (($offset/5) + 3);
		$lil = (($offset/5) - 2);
		ECHO '';
		echo '<table width="100%"><tr><td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="200" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td>
		<td><img src="img/header/spacer.gif" width="85" height="2" alt=""></td></tr><tr><td align="center">';
		echo ($offset == 0 ? '' : '<a href="index.php?offset=0" class="nav3">First</a>').'</td>
		<td align="center"> '.($offset == 0 ? '' : '<a href="index.php?offset='.($offset == 0 ? '0' : $offset - 5 ).'" rel="prev" class="nav3"> << </a>').'</td>
		<td align="center">';
		echo ($offset >= 15 ? '<span class="blue"> ... </span>' : ' ');
		for ($i = 1; $i <= $tpages; $i++){
			if ($big >= $i || (($offset == 0) && $i <= 4) ){
				if ($lil >= $i){
				  	if (($tpages == (($offset/5) +1)) && $i == ($i - 3)){
						$page = 5*$bu;
						echo '<a href="index.php?offset='.$page.'" class="nav3"> '.$i.' </a>';
						$bu = $bu + 1;
					}
					else {
					$page = 5*$bu;
					$bu = $bu + 1;
					}
				}
				else {
				$page = 5*$bu;
						if ($page == $offset){
							echo '<span class="gray">'.$i.'</span>';
						}
						else {
							echo '<a href="index.php?offset='.$page.'" class="nav3"> '.$i.' </a>';
						}
				$bu = $bu + 1;
				}
			}
			else {
			$page = 5*$bu;
			$bu = $bu + 1;
			}
		}
		echo ($offset < (($tpages*5) - 15) ? '<span class="blue"> ... </span>' : ' ');
		 echo '</td><td align="center">';
		$next = $offset + 5;
		echo ($last == $offset ? '' : '<a href="index.php?offset='.$next.'" rel="next" class="nav3"> >> </a>').'</td><td align="center">'. ($last == $offset ? '' : '<a href="index.php?offset='.$last.'"  class="nav3">Last</a>' );
			// End Pagination area ///////////////////////////////////////////////////////////////
		echo '</td></tr></table>';
		echo '</td></tr></table>
		</td>
	</tr>
  </table>
</div>
<div class="rightside">' ;
require('rightside.php');
?>
</div>

		
		
		
