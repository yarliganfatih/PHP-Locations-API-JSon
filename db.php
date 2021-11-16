<?php
	 $host = "";
	 $user = "";
	 $password = "";
	 $database = "";

$db = mysqli_connect($host, $user, $password, $database);
$db->query("set names 'utf8'");
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}else{
	
}
?>