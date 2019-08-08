<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "laporkuy";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	} 
	
	$id = $_GET['id'];
	$sql= "UPDATE `reportInbox` SET `finish` = '1' WHERE id = ".$id."";
	mysqli_query($conn, $sql);
	$sql1= "UPDATE `reportInbox` SET `finishDate` = NOW() WHERE id = ".$id."";
	mysqli_query($conn, $sql1);
?>