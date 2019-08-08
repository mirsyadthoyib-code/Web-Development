<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laporkuy";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$id = $_GET['id'];
$reply = "UPDATE `reportInbox` SET `reply` = '1' WHERE id = ".$id."";
$result = mysqli_query($conn, $reply);
if($result){
    header( 'Location: localhost/Laporkuy/mailRead.php' ) ;
} else{
    echo("<br>Input data is fail");
}
?>