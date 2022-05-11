<?php 
	echo '<table><tr><td colspan="3">';
	if ($action == 'Success'){
	echo 'An email has been sent to you with the address you provided when you signed up.<br>Check your email and if you can';
	echo "'t find it check your spam filter and follow the instructions provided";
	echo '</td></tr>
			</table>';
	}
	
	else {
	
		if ($action == 'Error'){
			echo 'Error no such user registered.<br><br>';
		}
	echo '<form action="process.php" method="post">
			<input type="Hidden" name="action" value="forgot">
			Help!';
	echo "I'm retarded and forgot my password.</td></tr>";
	echo '<tr><td>Enter your username:</td><td align="right"> <input type="Text" name="u_name" size="20"></td></tr>
			<tr><td></td><td align="right"> <input type="Submit" value="SUBMIT"></td></tr>
			</table></form>';
	}

?>


 
