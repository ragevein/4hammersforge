<?php 
session_name('4hammers');
session_start();
$link = mysqli_connect("localhost", "radmin", "OtENi66smQs0c5Ly*", "4hammersforge");
extract($_REQUEST);
?>

<html>
<head>
<title>Image View</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
b { font-weight:normal; color:#ffffff;}
</style>
</head>

<body bgcolor="#000000">

<?php 
$query = "SELECT * FROM image WHERE i_id = ".$id."";
$result = mysqli_query($link, $query) or die ("Query failed,  " .mysql_error());
$data = mysqli_fetch_array($result);


?>
<table align="center">
  <tr>
    <td align="center">
	  <?php 
	  echo '<img src="img/profile/'.$data[4].'" hspace="5" vspace="5" caption="'.$data['i_name'].'">';
	  ?>
	</td>
  </tr>
  <tr>
    <td align="center">
	  <?php 
	  echo '<b>'.$data['i_cap'].'</b>';
	  ?>
	</td>
  </tr>
</table>

</body>
</html>
