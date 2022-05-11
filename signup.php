<table>
  <tr>
    <td background="img/header/bigblock.jpg"><img src="img/header/spacer.gif" height="5" width="800"><br>
	<b class="beep">Thank you for your interest in becoming a member</b><br><img src="img/header/spacer.gif" height="10" width="2">
  </tr>
  <?php 
  	if ($subaction == 'error'){
		echo '<tr><td colspan="2">Your passwords did not match.</td></tr>';	
	}
	elseif ($subaction == 'error2'){
		echo '<tr><td colspan="2">Your username is already in use. Please choose another one.</td></tr>';	
	}
	elseif ($subaction == 'error3'){
		echo '<tr><td colspan="2">Your password is to short. Please enter a longer password.</td></tr>';	
	}
	elseif ($subaction == 'error4'){
		echo '<tr><td colspan="2">Your username is way to long.  Max of 30 characters. Please choose a shorter username.</td></tr>';	
	}
	elseif ($subaction == 'error5'){
		echo '<tr><td colspan="2">Your entered in the incorrect code for the security image.</td></tr>';	
	}
	elseif ($subaction == 'check'){
		if ($user == 1){
		echo 'That user name is available.';
		}
		else {
		echo 'Your username is already in use.  Please choose another one.';
		}
	}
  ?>
  <tr>			
	<td valign="top">
	
	<form action="process.php" method="post" name="signup">
			  		<input type="hidden" name="action" value="signup">
					<input type="hidden" name="sub_action" value="insert">
					<input type="Hidden" name="loc" value="signup">
	  <table>
		<tr>
	  	  <td>
	  		User Name:
	  	  </td>
		  <td><?php 
			  echo '<input type="Text" name="u_name" value="'.$row[3].'" border="0" vspace="0" accept="text/plain" maxlength="20">';
			 ?>
		  </td>
		  <td>Usernames have a maximum of 30 chars Check Availibitly</td>
    	</tr>
    	<tr>
      	  <td>
	  	    Password:
	  	  </td>
		  <td><?php 
			  echo '<input type="Text" name="u_pass1" value="'.$row[4].'" border="0" vspace="0" accept="text/plain" maxlength="20">';
			
			  ?>
		  </td>
		  <td>Passwords must be a minimum of 6 characters.</td>
   		</tr>
   		<tr>
      	  <td>
	  	    ReEnter Password:
	  	  </td>
		  <td><?php 
			  echo '<input type="Text" name="u_pass2" value="'.$row[4].'" border="0" vspace="0" accept="text/plain" maxlength="20">';
			
			  ?>
		  </td>
		  <td></td>
   		</tr>
		<tr>
		  <td width="100">
			First Name:
		  </td>
		  <?php
			  	echo '<td>';
			 	echo '<input type="Text" name="u_fname" value="'.$row[1].'" border="0" vspace="0" accept="text/plain" maxlength="20">';
		    ?></td>
			<td></td>
  		</tr>
 		<tr>
      	  <td>
	  		Last Name:
	  	  </td>
		  <td><?php
			  echo '<input type="Text" name="u_lname" value="'.$row[2].'" border="0" vspace="0" accept="text/plain" maxlength="20">';
			 ?>
		  </td>
		  <td></td>
		</tr>
		<tr>
	  	  <td>
	  		Email:
	  	  </td>
		  <td><?php 
			  echo '<input type="Text" name="u_email" value="'.$row[5].'" border="0" vspace="0" accept="text/plain" maxlength="35">';
			  ?>
		  </td>
		  <td></td>
    	</tr>
		<tr>
	  	  <td>
	  		Birthdate:
	  	  </td>
		  <td>
		  <img src="img/header/spacer.gif" height="2" width="225"><br>
		  <?php 
		  echo 'M <select name="month" size="1">';
					$phpdate = strtotime( $row[6] );
					
					$bm = date( 'm', $phpdate);
					for ($m = 1; $m <= 12; $m++){
						echo '<option value="'.$m.'" '.($m == $bm ? 'selected' : '').'>'.$m.'</option>'; 
					}
					echo '</select>
					D	<select name="day" size="1">';
					$bd = date( 'd', $phpdate);
						for ($d = 1; $d <= 31; $d++){
  						echo '<option value="'.$d.'" '.($d == $bd ? 'selected' : '').'>'.$d.'</option>'; 
						}
					echo '</select>
					Y <select name="year" size="1">';
					$by = date( 'Y', $phpdate);
						for ($y = 1910; $y <= 2012; $y++){
  						echo '<option value="'.$y.'" '.($y == $by ? 'selected' : '').'>'.$y.'</option>'; 
						}
					echo '</select>';
			 ?>
	 	  </td>
    	</tr>
		<tr><td>Enter the code from the image:<br>(My bot destroyer)</td>
		  <td><input type="Text" name="s_img" maxlength="20"></td>
<?php 
		  $tibs = rand(1, 4);
		  $sql = "SELECT * FROM secure_img WHERE s_id = ".$tibs."";
		  if($result = mysqli_query($link, $sql)){}
		  //$result = mysql_query($query);
		  $row = mysqli_fetch_array($result);
		  echo '<td>
		  <input type="Hidden" name="s_id" value="'.$row['s_id'].'">
		  <img src="img/s_img/'.$row['s_name'].'"</td>';
?>
		</tr>
  	  </table>
	</td>
  </tr>  
    <td>
	<input type="submit" size="25" value="ENTER"></form>
	</td>
  </tr>
    <tr>
    <td align="center"><img src="img/header/spacer.gif" height="250" width="2"></td>
  </tr>

</table>