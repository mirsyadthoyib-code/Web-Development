<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laporkuy";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek konenksi
if ($conn->connect_error) 
{
	die("Connection failed: " . $conn->connect_error);
} 
?>