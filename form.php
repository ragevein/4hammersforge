<img src="img/header/spacer.gif" width="800" height="2">
<?php 

if (!isset($parent)){
		$parent = 0;
		$target = 'forum';
		}
		//<tr><td height="2"><img src="../img/bar2.jpg"></td></tr>
		echo '<table width="100%"><form enctype="multipart/form-data" action="process.php" method="post" name="forum">';
		echo '<input type="Hidden" name="action" value="forum"><input type="Hidden" name="MAX_FILE_SIZE" value="50000000">';
		echo ($parent == 0 ? '<tr bgcolor="#1A2431"><td>Subject: <input type="Text" size="89" name="sub" accept="text/plain" tabindex="1"></td></tr>' : '').''; // if its a new thread start show subject
		echo '<tr bgcolor="#1A2431"><td '.($parent == 0 ? '> Body:' : 'width="135" ><img SRC="img/header/spacer.gif" WIDTH=130 HEIGHT=36><td>').'<textarea rows="9" cols="77" name="body" tabindex="2"></textarea>'; // body of thread
		echo '<input type="Hidden" name="cat" value="'.($cat != 0 ? $cat : 0).'">'; // if 0 then its a forum category
		echo '<input type="Hidden" name="f_date" value="'.date("Y-m-d  H:i:s").'">'; // Entry date
		echo '<input type="Hidden" name="parent" value="'.($parent != 0 ? $parent : 0).'"></td></tr>'; // if new thread or reply set parent id
		echo '<input type="Hidden" name="mainaction" value="'.$mainaction.'">';
		echo '<input type="Hidden" name="id" value="'.$id.'">';
		if ($target != 'forum' && $parent == 0){
		echo '<input type="Hidden" name="mainaction" value="thread">';
		}
		if ($target == 'forum'){
		echo '<input type="Hidden" name="target" value="forum">';
		}
		echo '<tr bgcolor="#1A2431"><td'.($parent == 0 ? '' :' colspan="2" align="right"').'>';
		if ($target != 'forum'){
			if ($parent != 0){
				echo '<input type="Hidden" name="reply" value="yes">';
			}
			echo '<input name="userfile" type="File"> <input type="Submit" value="ADD PIC">';
		}
		echo '<input type="Submit" tabindex="3"></form>';
		if ($target != 'forum' && $parent == 0){
			// not sure if i'm puting a cancel form here
		}
		echo '</td></tr></table> ';
		//echo $mainaction;
?>