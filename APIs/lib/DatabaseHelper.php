<?php
	$ServerName = "localhost"; //Data Type = String
	$Username = "root";
	$Password = "";
	$DBName = "vanet_paper"; //DB Name
	
	$conn = mysqli_connect($ServerName, $Username, $Password, $DBName);
	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
	//echo "Connected successfully";
?>
