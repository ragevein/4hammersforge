<?php

$table = 'news';
$sql = "SELECT * FROM news_img WHERE n_type = 1";
if($images = mysqli_query($link, $sql)){}
//$images = mysql_query($query) or die ('News query failed'. mysql_error() );
$icount = mysqli_num_rows($images);
if (isset($sid)){

$sql = "SELECT * FROM ".$table." WHERE n_id = ".$sid."";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('News query failed'. mysql_error() );
$row = mysqli_fetch_array($result);
}
else {
$sql = "SELECT * FROM ".$table." WHERE n_auth = ".$_SESSION['u_id']." AND n_publish = 1 AND n_feat = 0";
if($result = mysqli_query($link, $sql)){}
//$result = mysql_query($query) or die ('News query failed'. mysql_error() );
$count = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);

}
$fbody = str_replace("&gay", "'", $row['n_body']);
$ftitle = str_replace("&gay", "'", $row['n_title']);
$fsub = str_replace("&gay", "'", $row['n_sub']);
echo '
<table cellpadding="5" cellspacing="1">
  <tr>
    <td valign="top">
	  <table>
	    <tr>
		  <td colspan="2"><b class="beep">'.(isset($sid) ? 'Editing News!' : 'Adding News!').'</b>';
	if ($count > 0){
		echo 'You have an unpublished news post.  You can edit and publish by clicking 
		<a href="index.php?mainaction=addnews&subaction=edit&sid='.$row['n_id'].'" class="blue">here.</a> ';
	}
	echo '
		  </td>
  	  	</tr>
  	  	<tr>
    	  <td valign="top">
<form enctype="multipart/form-data" action="iprocess.php" method="post" name="news"><input type="Hidden" name="action" value="news">
<input type="Hidden" name="MAX_FILE_SIZE" value="50000000">'.(isset($sid) ? '<input type="Hidden" name="sub_action" value="update">' : '' ).'
'.(isset($sid) ? '<input type="Hidden" name="id" value="'.$sid.'">' : '' ).'
<b>Title:</b> <b class="bop">Max characters are 65.  The more intriging the better.  No html allowed here.</b>
<br><input type="Text" maxlength="65" size="70" name="title"'.(isset($sid) ? 'value="'.$ftitle.'"' : '').'><br>
<b>Description:</b> <b class="bop">Max characters are 250.  No html allowed here.</b>
<br><input type="Text" maxlength="250" size="70" name="sub"'.(isset($sid) ? 'value="'.$fsub.'"' : '').'><br>
<b>Body:</b> <b class="bop">This is where the main body of your news post goes, images, youtube links, w/e html is allowed here.</b>
<br><textarea rows="15" cols="75" name="body">'.(isset($sid) ? $fbody : '').'</textarea></td></tr></table>
<b>Choose thumbnail size for your image:</b> <b class="bop">(Height will be calculated to maintian aspect ratios.)</b><br>
<img src="img/header/spacer.gif" width="200" height="200" border="1"> <input type="Radio" name="fwidth" value="200" '.(isset($sid) ? ($row['n_width'] == 200 ? 'checked' : '') : '').'>
<img src="img/header/spacer.gif" width="150" height="150" border="1"> <input type="Radio" name="fwidth" value="150" '.(isset($sid) ? ($row['n_width'] == 150 ? 'checked' : '') : '').'>
<img src="img/header/spacer.gif" width="125" height="125" border="1"> <input type="Radio" name="fwidth" value="125" '.(isset($sid) ? ($row['n_width'] == 125 ? 'checked' : '') : '').'>
<img src="img/header/spacer.gif" width="100" height="100" border="1"> <input type="Radio" name="fwidth" value="100" '.(isset($sid) ? ($row['n_width'] == 100 ? 'checked' : '') : '').'><br>
OR No thumbnail please <input type="Radio" name="fwidth" value="0" '.(isset($sid) ? ($row['n_width'] == 0 ? 'checked' : '') : '').'><br>
<input name="userfile" type="File"> <b>Name:</b> <input type="Text" name="name" size="15" '.(isset($sid) ? 'value="'.$row['n_name'].'"' : '').'> <b class="bop">(Name your image.)</b> <br> <b>Alignment:</b> <b class="bop">(Choosing alignment for the image nicely nests your image in the body.)</b>
<b>LEFT:</b> <input type="Radio" name="align" value="left"> <b>RIGHT:</b> <input type="Radio" name="align" value="right"> <input type="Submit" value="UPLOAD PIC"><br>
<b>Publish News Post: NO <input type="Radio" name="publish" value="1" '.(isset($sid) ? ($row['n_publish'] == 1 ? 'checked' : '' ) : 'checked').'> 
YES <input type="Radio" name="publish" value="0" '.(isset($sid) ? ($row['n_publish'] == 0 ? 'checked' : '' ) : '').'></b>
<input type="Submit" value="  SAVE  "><br><b>Hey admins.</b>  <b class="bop">To add a Hyper link in the body of your post, just use a html A link.  Example:<br>
&lt;a href=&quot;Actual URL&quot; target=&quot;_blank&quot; class=&quot;blue&quot;&gt;What people see&lt;/a&gt; <br>If you need to move the location of the image in your news post, 
<br>just drag the entire code in the text box to where you want it to be and save ur post.</b><br><br>
<b>PREVIEW YOUR NEWS POST BELOW</b>
		  </td>
		  <td valign="top"><b>Admins! New Changes.  News posts will now have 3 simple things on the news page.  An image, a title and a description.  The body of your post will still remain the same when 
		someone clicks on the more button.<br><br>Main news page images below:</b>
		<div style="width:200px;height:400px;overflow:auto;">';
		for ($i = 0; $i < $icount; $i++) {
			$irow = mysqli_fetch_array($images);
			echo '<img src="/img/news/logo/'. $irow['n_src'].'" hspace="2" vspace="2"><input type="Radio" name="logo" value="'.$irow['n_src'].'" '.($row['n_img_src'] == $irow['n_src'] ? 'checked' :'').'><br>';
		}
echo '</div>
(K you guys can add your own, trim your images to 150 x 150, or the script will cut it down for you and it will not look as good.)<br><br>';
if ($_SESSION['u_id'] == 1) {
echo 'Featured  YES <input type="Radio" name="feat" value="1" '.(isset($sid) ? ($row['n_feat'] == 1 ? 'checked' : '' ) : '').'> 
NO <input type="Radio" name="feat" value="0" '.(isset($sid) ? ($row['n_feat'] == 0 ? 'checked' : '' ) : 'checked').'>';
}
echo '<br>Add a image to the Dbase:<br><input name="userfile2" type="File"><br> <b>Name:</b>
			<input type="text" name="nlogo"><br>';
//$blahblah =  mktime(0, 0, 0, date('n'), date('j'), date('Y')) - ((date('N')-1)*3600*24);
//echo '<br>2013/01/13 00:00:00 <br>';
//echo date('Y/m/d H:i:s', $blahblah);
//'2013/01/13 00:00:00'

echo '</form>	
		  </td>
  	  	</tr>
  	  	<tr>
     	  <td colspan="2">';
if (isset($sid)){
// Preview News post
	$sql = "SELECT * FROM ".$table." WHERE n_id = ".$sid."";
	if($result = mysqli_query($link, $sql)){}
	//$result = mysql_query($query) or die ("News Query failed");
		echo '
	  	    <table cellpadding="1" cellspacing="1" border="0">
	    	  <tr>
		  	  	<td>
		  	  	</td>
			  </tr>';  
		$n_row = mysqli_fetch_array($result);
		$fbody = str_replace("&gay", "'", $n_row['n_body']);
		$ftitle = str_replace("&gay", "'", $n_row['n_title']);
		$fsub = str_replace("&gay", "'", $n_row['n_sub']);
			echo '
			  <tr>
		 	  	<td>';
			$sql ="SELECT * FROM users WHERE u_id = '".$n_row['n_auth']."'";
			if($result = mysqli_query($link, $sql)){}
			//$resul = mysql_query($quer) or die ("Cant look up user");
			$ro = mysqli_fetch_array($result);
				echo '
			  <tr>
		  	  	<td><img src="img/avatars/'.$ro['u_avatar'].'" height="75" width="75" align="left" hspace="7" vspace="0"><b class="twelve">Entry '.$n_row['n_id'].' - '. $fsub.'<br>'.date("M jS", strtotime($n_row['n_date'])).'</b>&nbsp;&nbsp; <b class="bop"> posted by -</b>&nbsp; 
				<a href="index.php?mainaction=profile&&sub=user&sid='.$row['u_id'].'" class="blue"> '.$ro[3].'</a>';			
			echo '
		        </td> 
			  </tr>
			  <tr><td>'.$ftitle.'</td></tr>
			  <tr><td>'.$fsub.'</td></tr>
			  <tr>
		      	<td>';

			echo '<p>'.nl2br($fbody);
			'</p>';
			echo '
		  	  	</td>
			  </tr>
			  <tr>
		  	  	<td></td>
			  </tr>
	   	    </table>';
}	  
	echo '
		  </td>
	  	</tr>
	  </table>
	</td>
  </tr>
</table>';
?>