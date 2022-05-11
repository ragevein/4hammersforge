<div class="fancy-header">Status Page</div>
<div class="container">
<div class="card">
<h3>Gold Garnered</h3> (last 10 transactions from completing quests)
<?php 
$sql = "SELECT * FROM transactions INNER JOIN users ON transactions.t_init_user = users.u_id WHERE 
t_type = 0 ORDER BY t_id DESC LIMIT 10";
if($result = mysqli_query($link, $sql)){
	echo '<table>';
	for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		echo '<tr><td width="150"><a href="index.php?mainaction=profile&sid='.$arow['u_id'].'">'.$row['u_name'].' </a></td><td width="150">'.$row['t_amount'].' gold </td><td width="200">'.time_since(strtotime($row['t_stamp'])).' ago </td></tr>';
	}
	echo '</table>';
}
echo '</div>
<div class="card">
<h3>Skirmish</h3> (last 10 battles)';
$sql = "SELECT * FROM transactions INNER JOIN users ON transactions.t_init_user = users.u_id WHERE 
t_type = 1 ORDER BY t_id DESC LIMIT 10";
if($result = mysqli_query($link, $sql)){
	echo '<table>';
	for ($a = 1; $a <= mysqli_num_rows($result); $a++){
		$row = mysqli_fetch_array($result);
		$sql = "SELECT u_id, u_name FROM users WHERE u_id = ".$row['t_affect_user']." ";
		$uresult =  mysqli_query($link, $sql);
		$arow = mysqli_fetch_array($uresult);
		echo '<tr><td width="150"><a href="index.php?mainaction=profile&sid='.$arow['u_id'].'">'.$row['u_name'].'</a> </td><td width="150">'.$row['t_amount'].' gold </td><td>from <a href="index.php?mainaction=profile&sid='.$arow['u_id'].'">'.$arow['u_name'].'</a></td><td width="200">'.time_since(strtotime($row['t_stamp'])).'
		 ago </td><td>Scenario: </td><td>'.$row['t_event'].'</td><td><button class="open-button">View</button></td></tr>';
	}
	echo '</table>';
}
echo '</div>
	<div class="card">
<h3>Forum Posts</h3>';
$cutoff = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d")-7, date("Y")));
$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id WHERE 
f_date >= '".$cutoff."' AND f_cat != 421 AND f_cat != 0 ORDER BY f_id DESC";
if($result = mysqli_query($link, $sql)){}
for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		if ($row['f_parent'] == 0){
		echo '<a href="index.php?mainaction=vthread&id='.$row['f_id'].'&cat='.$row['f_cat'].'" class="blue">'. $row['f_sub'].'</a>
		 Posted by '.$row['u_name'].' on '.$row['f_date'].'<br>';
		}
		else {
		$sql = "SELECT * FROM forum WHERE f_id = ".$row['f_parent']."";
		if($subres = mysqli_query($link, $sql)){}
		//$subres = mysql_query($query) or die ('Reply query failure: '.mysql_error());
		$subdata =  mysqli_fetch_array($subres);
		echo 'Replied to <a href="index.php?mainaction=vthread&id='.$subdata['f_id'].'&cat='.$subdata['f_cat'].'" class="blue">'.$subdata['f_sub'].'</a>  
		by '.$row['u_name'].' on '.$row['f_date'].'<br>';
		}
	
}

echo '</div>
<div class="card">
<h3>Profiles updated</h3>';
$sql = "SELECT * FROM users WHERE 
u_update >= '".$cutoff."'";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('Post query failure: '.mysql_error());
for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		echo '';
		switch ($row['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">Member ';
				break;
				default:
				echo '';
				break;
			}
		echo $row['u_name'].'</a> Updated there profile on '.$row['u_update'].'<br>';
}

echo '</div>
<div class="card">
<h3>Game Status Updates</h3><br>';
$sql = "SELECT users.u_name, users.u_id, users.u_sec, user_games.gu_status, user_games.gu_update, Games.g_name FROM user_games INNER JOIN users ON user_games.gu_userid = users.u_id INNER JOIN Games ON user_games.gu_gameid = Games.g_id WHERE 
user_games.gu_update >= '".$cutoff."'";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('3 inner join query failure: '.mysql_error());
for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		echo '';
		if ($row['gu_status'] == 1) {
		$status = 'is currently playing';
		}
		elseif ($row['gu_status'] == 2) {
		$status = 'is casually playing';
		}
		else {
		$status = 'is no longer playing';
		}
		switch ($row['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">Member ';
				break;
				default:
				echo '';
				break;
			}
		echo $row['u_name'].'</a> '.$status.' '.$row['g_name'].' as of '.$row['gu_update'].'<br>';
}

echo '</div>
<div class="card">
<h3>New images</h3><br>';
$sql = "SELECT * FROM image INNER JOIN users ON image.i_auth = users.u_id WHERE 
i_date >= '".$cutoff."'";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('Post query failure: '.mysql_error());
for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		echo 'New Image Uploaded by ';
		switch ($row['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'">Member ';
				break;
				default:
				echo '';
				break;
			}
		echo $row['u_name'].'</a> on '.$row['i_date'].'<br>';
}
echo '</div>
<div class="card">
<h3>News Comments</h3><br>';
$sql = "SELECT * FROM comment INNER JOIN users ON comment.com_auth = users.u_id WHERE 
com_date >= '".$cutoff."' ORDER BY com_id DESC";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('Post query failure: '.mysql_error());
for ($i = 1; $i <= mysqli_num_rows($result); $i++){
		$row = mysqli_fetch_array($result);
		switch ($row['u_sec']){
			
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="blue">'.($row['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$row["u_id"].'" class="green">Member ';
				break;
				default:
				echo '';
				break;
			}
		$sql = "SELECT * FROM news WHERE n_id = ".$row['com_npost']."";
		if($subres = mysqli_query($link, $sql)){}
		//$subres = mysql_query($query) or die ('news query failure: '.mysql_error());
		$subdata =  mysqli_fetch_array($subres);
		echo $row['u_name'].'</a> Commented on News post <a href="index.php?mainaction=story&id='.$subdata['n_id'].'" class="blue">'.$subdata['n_title'].'</a> on '.$row['com_date'].'<br>';
}
echo '</div></div>';

echo '<dialog name="modal" id="modal">scenario</dialog>'

?>

<script>
	// the main update form
const modal = document.querySelector('#modal')
var openModal = document.querySelector('.open-button');
var closeModal = document.querySelector('#close-button');

openModal.addEventListener('click', () => {
    modal.showModal();    
})

closeModal.addEventListener('click', () => {
    modal.close();
})

</script>