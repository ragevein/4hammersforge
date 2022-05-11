<?php
switch ($action){
		case "forum":
			$fileloc = "f_img/";
			
			break;
		case "profile":

			break;
		default:
			echo 'error';

			break;
	}

if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
				// does the file have the right MIME type?
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
				
				// create a thumbnail image -----------------------------------------------------------------------------------------------------------
				list($width, $height, $type, $attr) = getimagesize($_FILES['userfile']['tmp_name']);
					if (!isset($fwidth)) { 
						$fwidth = 400; 
					}
					if ($fwidth == 0){
						if ($fwidth <= 400){
						$thumb = 0;
						}
						else {
						$fwidth = 400;
						}
						
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
				// enter a record into avatar database
				//
				$sql = "INSERT INTO f_img (d_name, d_src, d_date, d_auth, d_thumb)
				VALUES
				('".$i_name."', '".$_FILES['userfile']['name']."', '".date('Y-m-d')."', '".$_SESSION['u_id']."', 'yes')";
				if($result = mysqli_query($link, $sql)){}
				//$result = mysql_query($query);
				
				if (file_exists("img/". $fileloc . $upfile)) {
					// grabs last record from database to get an id for new file name
					$sql = "SELECT * FROM f_img WHERE d_auth = ".$_SESSION['u_id']." ORDER BY d_id DESC";
					if($result = mysqli_query($link, $sql)){}
					//$result = mysql_query($query);
					$data = mysqli_fetch_array($result);
					$upfile = 'dark'.$_SESSION['u_id'].$data[0] . $file_ext;
					// Resize and put into directory
					$filename = "img/dark/thumb/". $upfile;
					imagejpeg($tmp,$filename,100);
					imagedestroy($src);
					imagedestroy($tmp);
					// --------
					$sql = "UPDATE f_img SET d_src = '".$upfile."' WHERE d_id = ".$data[0]."";
					if($result = mysqli_query($link, $sql)){}
					//$result  = mysql_query($query);
				}
				else {
				$filename = "img/f_img/thumb/". $upfile;
					imagejpeg($tmp,$filename,100);
					imagedestroy($src);
					imagedestroy($tmp);
				}
				if (!move_uploaded_file($_FILES['userfile']['tmp_name'], 'img/f_img/'.$upfile)){
					echo 'Problem: Could not move file to destination directory!';
					exit;
				}
			}
		if ($_FILES['userfile']['error'] != 4){ // the 4 means it didn't throw the no file uploaded error
			$query = "UPDATE forum 
			SET f_sub='".$sub."',
	   		f_body='".$body;
			if ($thumb == 0) {
			$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/thumb/'.$upfile.'"></a>';
			}
			else {
			$query .= '<a href="img/f_img/'.$upfile.'"><img src="img/f_img/'.$upfile.'"></a>';
			}
			$query .= "', f_order='".$order."'
			WHERE f_id = '".$id."'";
			if($result = mysqli_query($link, $query)){}
			//$result = mysql_query($query);
			if (!$result) {
    			die('Invalid query: ' . mysql_error());
			}
			if ($reply == "yes"){
			$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$sid : '').(isset($sid) ? '&sid='.$id : '');
			}
			else {
			$urlloc = 'Location: index.php?mainaction=vthread&subaction=edit'.(isset($cat) ? '&cat='.$cat : '').(isset($id) ? '&id='.$id : '').(isset($sid) ? '&sid='.$sid : '');
       		}
			header( $urlloc ) ;
		}
		else {
			$query = "UPDATE forum 
			SET f_sub='".$sub."',
	   		f_body='".$body."',
			f_order='".$order."'
			WHERE f_id = '".$id."'";
			$result = mysql_query($query);
			if (!$result) {
    			die('Invalid query: ' . mysql_error());
			}
       	header( $urlloc ) ;
		}
	}


?>