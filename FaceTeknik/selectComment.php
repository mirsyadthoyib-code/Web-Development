<?php 

 /*
 
 penulis:	Muhammad Irsyad Thoyib
 proyek:	FaceTeknik
 
 */

	$id = $_GET['id'];
	
	//Import File Koneksi Database
	require_once('connection.php');
	
	//Membuat SQL Query
	$sql = "SELECT COMMENT.id, fullName, date, comment FROM `comment` inner join user on comment.idUser = user.id where comment.idPost = $id;";
	
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan data kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
			"id"=>$row['id'],
			"fullName"=>$row['fullName'],
			"date"=>$row['date'],
			"comment"=>$row['comment']
		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>