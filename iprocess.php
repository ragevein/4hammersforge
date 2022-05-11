<?php
session_name('4hammers');
session_start();
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
//$currentdb = 'fubarstr_Dragonclaw';
//$db = mysql_connect("localhost","fubarstr_rage","Dragonblade90!") or die(mysql_error(). 'Problem connecting');
//mysql_select_db($currentdb) or die("Problem selecting database");
extract($_POST);
$table = 'news';
if ($logo == NULL){
// then do nothing
$n_img = 0;
}
else {
$n_img = 1;
}
if (!isset($feat)){
$feat = 0;
}
// add logo to dbase ------------------------------------------------------------------------------------------------------
				if ($_FILES['userfile2']['error'] > 0){
					switch ($_FILES['userfile']['error']){
					case 1: echo 'File exceeded upload_max_filesize'; break; exit;
					case 2: echo 'File exceeded max_file_size'; break; exit;
					case 3: echo 'File only partially uploaded'; break; exit;
					//case 4: echo 'No file uploaded'; break;
					}
				}
				if (is_uploaded_file($_FILES['userfile2']['tmp_name'])){
					// does the file have the right MIME type?  currently jpeg and gif only
					$badfile = 0;
					if ($_FILES['userfile2']['type'] == 'image/jpeg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile2']['type'] == 'image/jpg'){
						$badfile = 1;
					}
					elseif ($_FILES['userfile2']['type'] == 'image/gif'){
						$badfile = 1;	
					}
					elseif ($_FILES['userfile2']['type'] == 'image/pjpeg'){
						$badfile = 1;	
					}
					if ($badfile == 0){
								echo 'Problem: file is not a jpeg or a gif image.<br>';
								echo $_FILES['userfile2']['type'];
								exit;
					}
					// put the file where we'd like it
					$upfile = $_FILES['userfile2']['name'];
					//--- my additions
					$file_basename = substr($upfile, 0, strripos($upfile, '.')); // strip extention
					$file_ext = substr($upfile, strripos($upfile, '.')); // strip name
					// resize to 150 w if oversized -------------------------------------------- 
					list($width, $height, $type, $attr) = getimagesize($_FILES['userfile2']['tmp_name']);
					if ($width > 150){
						$fwidth = 150;
						$resized = 1;
						$nheight = ( $height / $width * $fwidth);
						$uploadedfile = $_FILES['userfile2']['tmp_name'];
						$newwidth = $fwidth;
						$newheight = $nheight;
						$tmp = imagecreatetruecolor($newwidth, $newheight);
						if ($_FILES['userfile2']['type'] == 'image/gif'){
							$src = imagecreatefromgif($uploadedfile);
						}
						else {
							$src = imagecreatefromjpeg($uploadedfile);
						}
						imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight, $width,$height);
					}
					// enter a record into database for added image
					$sql = "INSERT INTO news_img (n_src, n_name, n_date, n_auth, n_thumb, n_width, n_align, n_type, n_post)
					VALUES
					('".$_FILES['userfile2']['name']."', '".$nlogo."', '".date('Y-m-d H:i:s')."', '".$_SESSION['u_id']."', 0, 150, 0, 1, 0)";
					if($result = mysqli_query($link, $sql)){
					// something
					}
					//$result = mysql_query($query) or die ('news insert update query fail - '.mysql_error());
						// grabs last record from database to get an id for new file name
						$sql = "SELECT * FROM news_img WHERE n_auth = ".$_SESSION['u_id']." ORDER BY n_id DESC";
						if($result = mysqli_query($link, $sql)){}
						//$result = mysql_query($query);
						$data = mysqli_fetch_array($result);
						$upfile = 'logo'.$_SESSION['u_id'].$data[0] . $file_ext;
						if ($resized == 1){
							// Resize and put into directory
							$filename = "img/news/logo/". $upfile;
							imagejpeg($tmp,$filename,100);
							imagedestroy($src);
							imagedestroy($tmp);
						}
						// --------
						else {
							if (!move_uploaded_file($_FILES['userfile2']['tmp_name'], 'img/news/logo/'.$upfile)){
							echo 'Problem: Could not move logo file to destination directory!';
							exit;
							}
						}
						$sql = "UPDATE news_img SET n_src = '".$upfile."' WHERE n_id = ".$data[0]."";
						if($result = mysqli_query($link, $sql)){
						// something
						}
						//$result  = mysql_query($query) or die ('news logo update query fail - '.mysql_error());
					$logo = $data[0];
					
				}
// end --------------------------------------------------------------------------------------------------------------------
// Process News Section ---------------------------------------------------------------------------------
		// ----- handles image upload -------------------------------------------------------------------
	  			if ($_FILES['userfile']['error'] > 0){
					switch ($_FILES['userfile']['error']){
					case 1: echo 'File exceeded upload_max_filesize'; break; exit;
					case 2: echo 'File exceeded max_file_size'; break; exit;
					case 3: echo 'File only partially uploaded'; break; exit;
					//case 4: echo 'No file uploaded'; break;
					}
				}
				if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
					// does the file have the right MIME type?  currently jpeg and gif only
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
					// create a thumbnail image ---------------------------------------------------------
					//-------------------------------------------- resize to 400 w
					list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
					if (!isset($fwidth)) { 
						$fwidth = 200; 
					}
					if ($fwidth == 0){
						$thumb = 0;
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
					
					// enter a record into database for added image
					$sql = "INSERT INTO news_img (n_src, n_name, n_date, n_auth, n_thumb, n_width, n_align)
					VALUES
					('".$_FILES['userfile']['name']."', '".$name."', '".date('Y-m-d H:i:s')."', '".$_SESSION['u_id']."', ".$thumb.", ".$fwidth.", '".$align."')";
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query) or die ('news insert update query fail - '.mysql_error());
						// grabs last record from database to get an id for new file name
						$sql = "SELECT * FROM news_img WHERE n_auth = ".$_SESSION['u_id']." ORDER BY n_id DESC";
						if($result = mysqli_query($link, $sql)){}
						//$result = mysql_query($query);
						$data = mysqli_fetch_array($result);
						$upfile = 'news'.$_SESSION['u_id'].$data[0] . $file_ext;
						// Resize and put into directory
						$filename = "img/news/thumb/". $upfile;
						imagejpeg($tmp,$filename,100);
						imagedestroy($src);
						imagedestroy($tmp);
						// --------
						$sql = "UPDATE news_img SET n_src = '".$upfile."' WHERE n_id = ".$data[0]."";
						if($result = mysqli_query($link, $sql)){}
						//$result  = mysql_query($query) or die ('news img update query fail - '.mysql_error());
					
					if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/news/'.$upfile)){
						echo 'Problem: Could not move file to destination directory!';
						exit;
					}
				}
				if ($_FILES['userfile']['error'] != 4){ // the 4 means it didn't throw the no file uploaded error
					//---- if its the first image you've added create the post else update the news post
					if ($thumb == 1) {
							$body .= '<a href="img/news/'.$upfile.'"><img src="img/news/thumb/'.$upfile.'" hspace="10" '.(isset($align) ? 'align="'.$align.'"' : '').'></a>';
					} else {
							$body .= '<img src="img/news/'.$upfile.'" hspace="10" '.(isset($align) ? 'align="'.$align.'"' : '').'>';
					}
					if ($_POST['sub_action'] == 'update'){
						$query = "UPDATE ".$table." SET n_title ='".$title."', n_sub ='".$sub."', n_body ='".$body."', n_publish ='".$publish."', n_img_src ='".$logo."',
						n_img = '".$n_img."', n_feat = ".$feat." WHERE n_id = '".$id."'";
					}
					else {
						$query = "INSERT INTO ".$table." (n_title, n_sub, n_auth, n_date, n_publish, n_body, n_img, n_img_src, n_feat)
						VALUES ('".$title."', '".$sub."', '".$_SESSION['u_id']."', '".date('Y-m-d H:i:s')."', ".$publish.", '".$body."' , '".$n_img."', '".$logo."', '".$feat."' )";
					}
					if($result = mysqli_query($link, $query)){}
					//$result = mysql_query($query) or die ('Invalid query: Insert area with pic ' . mysql_error());
					$id = mysqli_insert_id();
					$sql = "UPDATE news_img SET n_post = '".$id."' WHERE n_id = ".$data[0]."";
					if($result = mysqli_query($link, $sql)){}
					//$result  = mysql_query($query) or die ('news img update query fail - '.mysql_error());
					$urlloc = 'Location: index.php?mainaction=addnews&sid='.$id.'&subaction=edit';
				}
				else { // No Image uploaded
				$fbody = str_replace("'", "&gay", $body);
				$ftitle = str_replace("'", "&gay", $title);
				$fsub = str_replace("'", "&gay", $sub);
					// If update
						if ($_POST['sub_action'] == 'update'){
						$sql = "UPDATE ".$table." 
						SET 
						n_title ='".$ftitle."',
						n_sub ='".$fsub."',
	   					n_body ='".$fbody."',
						n_publish ='".$publish."',
						n_img_src ='".$logo."',
						n_img = '".$n_img."',
						n_feat = '".$feat."'
						WHERE n_id = '".$id."'";
						if($result = mysqli_query($link, $sql)){}
						//$result = mysql_query($query) or die('Invalid update query: ' . mysql_error());
							if ($_FILES['userfile']['error'] != 4){ /// updates img to belong to this post if one was uploaded
								$id = mysqli_insert_id();
								$sql = "UPDATE news_img SET n_post = '".$id."' WHERE n_id = ".$data[0]."";
								if($result = mysqli_query($link, $sql)){}
								//$result  = mysql_query($query) or die ('news img update query fail - '.mysql_error());
							}
							if ($publish == 1){
								$urlloc = 'Location: index.php?mainaction=addnews&sid='.$id.'&subaction=edit';
							}
							else {
								$urlloc = 'Location: index.php';
							}
						}
					// If Insert
						else {

						$sql = "INSERT INTO ".$table." (n_title, n_sub, n_body, n_auth, n_date, n_publish, n_img, n_img_src, n_feat, n_cat)
						VALUES
						('".$ftitle."', '".$fsub."', '".$fbody."', '".$_SESSION['u_id']."', '".date('Y-m-d H:i:s')."', ".$publish.", '".$n_img."', '".$logo."', '".$feat."', '0')";
						
						if($result = mysqli_query($link, $sql)){}
						//$result = mysql_query($query) or die ('Invalid insert query: ' . mysql_error()) ;
							if ($_FILES['userfile']['error'] != 4){ /// updates img to belong to this post if one was uploaded
								$id = mysqli_insert_id($link);
								$sql = "UPDATE news_img SET n_post = '".$id."' WHERE n_id = ".$data[0]."";
								if($result = mysqli_query($link, $sql)){}
								$result  = mysqli_query($query);
							}
							if ($publish == 1){
								$id = mysqli_insert_id($link, $sql);
						//echo 'stop shit'.$sql;
						//exit;
								$urlloc = 'Location: index.php?mainaction=addnews&sid='.$id.'&subaction=edit';
							}
							else {
								$urlloc ='Location: index.php';
							}
							
						}
				}
header( $urlloc ) ;
?>