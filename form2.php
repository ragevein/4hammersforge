
<?php 
//<img src="img/header/spacer.gif" width="800" height="2">
echo '
<table width="100%" cellpadding="5" cellspacing="1" border="0">
  <tr bgcolor="#1A2431">
    <td valign="top" align="center">
    <form enctype="multipart/form-data" action="process.php" method="post" name="forum">';

if ($subaction != 'edit'){
	if (!isset($parent)){
		$parent = 0;
		$target = 'forum';
	}		
			echo '<input type="Hidden" name="f_date" value="'.date("Y-m-d  H:i:s").'">'; // Entry date		

}
else {	// from thread area in edit			echo '<input type="Hidden" name="sid" value="'.$id.'">';
		if (isset($sid)){
		$it = $sid;
		echo '<input type="Hidden" name="reply" value="yes">
			  <input type="Hidden" name="sid" value="'.$id.'">
			  <input type="Hidden" name="sub" value="nothing">';
			  
		}
		else {
		$it = $id;
		}	
}// ----
if ($subaction == 'edit'){
		$sql = "SELECT * FROM forum INNER JOIN users ON forum.f_auth = users.u_id WHERE f_id = '".$it."' ";
		if($result = mysqli_query($link, $sql)){}
			$frow = mysqli_fetch_array($result);
			$fixed = str_replace("&gay", "'", $frow['f_body']);
		if (!isset($parent)){
			$parent = $frow['f_parent'];
		}			
			echo '<input type="Hidden" name="id" value="'.$it.'">';
			echo '<input type="Hidden" name="sub_action" value="update">
				  <input type="Hidden" name="action" value="forum">
				  <input type="Hidden" name="cat" value="'.$cat.'">';
}
else {
		echo '<input type="Hidden" name="id" value="'.$id.'">';
		$sql = "SELECT * FROM users WHERE u_id = '".$_SESSION['u_id']."' ";
		if($result = mysqli_query($link, $sql)){}
		$frow = mysqli_fetch_array($result);
}

			echo '<b class="bop">'.($subaction == 'edit' ? date("n-j-y h:i a", strtotime($frow['f_date'])) : '').'</b>
			<br><img src="img/header/spacer.gif" width="170" height="4" alt=""><br>
			<img src="img/avatars/'.($frow['u_avatar'] != NULL ? $frow['u_avatar'] : 'nopic.jpg').'" hspace="5" vspace="5" height="128" width="128"><br>';
			switch ($frow['u_sec']){
				case "3":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$frow["u_id"].'" class="blue">'.($frow['u_id'] == 1 ? 'Webmaster ' : 'Admin ');
				break;
				case "2":
				echo '<a href="index.php?mainaction=profile&&sub=user&sid='.$frow["u_id"].'" class="green">Member ';
				break;
				default:
				echo '';
				break;
			}
			echo $frow['u_name'].'</a><br>
			</td>';
		if ($tag == 1 ){// to identify if its a forum not a post or thread in a forum ya...
			echo '<input type="Hidden" name="tag" value="1">';  // i don't think this is actually being used
		}
				
		echo '<input type="Hidden" name="cat" value="'.($cat != 0 ? $cat : 0).'">'; // if 0 then its a forum category 
		echo '<input type="Hidden" name="parent" value="'.($parent != 0 ? $parent : 0).'">'; // if new thread or reply set parent id
		echo '<input type="Hidden" name="action" value="forum">
		      <input type="Hidden" name="MAX_FILE_SIZE" value="50000000">';
		echo '<input type="Hidden" name="mainaction" value="'.$mainaction.'">';
		
		// to direct browser back to page you once came
		if ($target != 'forum' && $subaction != 'edit' && $parent == 0){
		echo '<input type="Hidden" name="mainaction" value="thread">'; 
		}
		elseif ($target == 'forum'){
		echo '<input type="Hidden" name="target" value="forum">';
		}
		if ($target != 'forum'){
			if ($parent != 0){
				echo '<input type="Hidden" name="reply" value="yes">';
			}
			
		}
/// ----------------- the one is hiding down here or
		echo '<td>';
		if ($parent == 0){ // if its a new thread show subject
			echo ($subaction == 'edit' ? '' : 'Subject: ').'<input type="Text" size="89" name="sub" accept="text/plain" tabindex="1" '
			.(isset($id) ? 'value="'.$frow['f_sub'].'"' : '' ).'><br><img src="img/header/black.jpg" width="780" height="1" hspace="0" vspace="2"><br>';
		}		
		//function to make it simple to add links to posts for users
		echo '
		<script>
		function addLink()
		{
			txt=document.getElementById("txtarea");  // Find the element
			url=document.getElementById("pasteURL");
			lt=document.getElementById("linkText");
			str=txt.value;
			str+="<a href=\"";
			str+=url.value;
			str+="\">";
			str+=lt.value;
			str+="</a>";
			txt.value=str;
		}
		</script>
		<p>
		Enter URL: 
		<input type="text" name="pasteURL" id="pasteURL" value="" />
		&nbsp;Link Text:
		<input type="text" name="linkText" id="linkText" value="LINK" />
		<button type="button" onclick="addLink()">ADD LINK</button>';
		
		echo '<textarea rows="20" cols="77" name="body" tabindex="2" id="txtarea">'.(isset($id) ? $fixed : '' ).'</textarea>';
		if ($subaction == 'edit'){
			echo '&nbsp;&nbsp;<input type="Submit" tabindex="3" value=" UPDATE " >';
		}		
		if ($subaction != 'edit'){
			echo '&nbsp;&nbsp;<input type="Submit" tabindex="3" value=" POST " >';
		}

		echo '</td></tr>'; 
		if ($target != 'forum'){// removes this section if adding a forum category
			echo '<tr bgcolor="#1A2431"><td></td><td><b class="bop">Upload an image with your post<br>Choose the width of the thumbnail:
			(Height will be calculated to maintian aspect ratios.)</b><br>
200  <input type="Radio" name="fwidth" value="200" '.(isset($sid) ? ($frow['n_width'] == 200 ? 'checked' : '') : '').'>
150 <input type="Radio" name="fwidth" value="150" '.(isset($sid) ? ($frow['n_width'] == 150 ? 'checked' : '') : '').'>
125 <input type="Radio" name="fwidth" value="125" '.(isset($sid) ? ($frow['n_width'] == 125 ? 'checked' : '') : '').'>
100 <input type="Radio" name="fwidth" value="100" '.(isset($sid) ? ($frow['n_width'] == 100 ? 'checked' : '') : '').'> 
or no thumbnail: <input type="Radio" name="fwidth" value="0" '.(isset($sid) ? ($frow['n_width'] == 0 ? 'checked' : '') : '').'><br>
<input name="userfile" type="File"> Img Name:</b> <input type="Text" name="name" size="15" '.(isset($sid) ? 'value="'.$frow['n_name'].'"' : '').'> 
<br> <b class="bop">Alignment: LEFT: <input type="Radio" name="align" value="left"> RIGHT:</b> <b class="bop"><input type="Radio" name="align" value="right"> 
(Choosing alignment for the image nicely nests your image in the body.)</b> <input type="Submit" value="ADD PIC">
			
			</form></td></tr>';
		}
		else {
		echo '</form>';
		}
		if ($target != 'forum' && $parent == 0){
			// not sure if i'm puting a cancel form here
		}
	
		echo '</table> ';
?>
