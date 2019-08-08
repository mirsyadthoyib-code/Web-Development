<?php 

 /*
 
 penulis:	Muhammad Irsyad Thoyib
 proyek:	FaceTeknik
 
 */

	$id = $_GET['id'];
	
	//Import File Koneksi Database
	require_once('connection.php');
	
	//Membuat SQL Query
	$sql = "SELECT post.id, fullName, image, text, date FROM `post` inner join user on post.idUser = user.id where post.id = $id;";
	
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
			"image"=>$row['image'],
			"text"=>$row['text']
		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>