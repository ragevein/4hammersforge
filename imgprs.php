<?php
session_name('4hammers');
session_start();
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
//$currentdb = 'blackdra_tech';
//$db = mysql_connect("localhost","blackdra_joe","g31horses") or die("Problem connecting");
//mysql_select_db($currentdb) or die("Problem selecting database");

extract($_POST);
$table = 'image';
if (!isset($target)) {
$target = "profile";
}
// 
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
						$fwidth = 100; 
					}
					$thumb = 0;
					if ($width > $fwidth){
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
					
					// enter a record into database
					$sql = "INSERT INTO image (i_src, i_name, i_date, i_auth, i_thumb, i_cap, i_cat, i_width)
					VALUES
					('".$_FILES['userfile']['name']."', '".$name."', '".date('Y-m-d H:i:s')."', '".$_SESSION['u_id']."', ".$thumb.", '".$desc."', '".$cat."', ".$fwidth.")";
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query) or die ('Insert image - '.mysql_error());

						// grabs last record from database to get an id for new file name
						$sql = "SELECT * FROM image WHERE i_auth = ".$_SESSION['u_id']." ORDER BY i_id DESC";
						if($result = mysqli_query($link, $sql)){}
						//$result = mysql_query($query);
						$data = mysqli_fetch_array($result);
						$upfile = 'prof'.$_SESSION['u_id'].$data[0] . $file_ext;
						
						// Resize and put into directory
						$filename = "img/profile/thumb/". $upfile;
						imagejpeg($tmp,$filename,100);
						imagedestroy($src);
						imagedestroy($tmp);
						// --------
						$sql = "UPDATE image SET i_src = '".$upfile."' WHERE i_id = ".$data[0]."";
						if($result = mysqli_query($link, $sql)){}
						//$result  = mysql_query($query) or die ('img update query fail - '.mysql_error());
					
					if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/profile/'.$upfile)){
						echo 'Problem: Could not move file to destination directory!';
						exit;
					}
				}
				if ($_FILES['userfile']['error'] != 4){ // the 4 means it didn't throw the no file uploaded error and all is good
					if ($target == "profile"){
					$urlloc = 'Location: index.php?mainaction=profile&sub=user&sid='.$_SESSION['u_id'];
					}
					else {
					$urlloc = 'Location: index.php?mainaction=game&sid='.$cat;
					}
					
				}
				else {
					
						echo 'Something bad happened here';
						exit;		
				}
header( $urlloc ) ;
session_write_close();
?>