<?php 

 /*
 
 penulis:	Muhammad Irsyad Thoyib
 proyek:	FaceTeknik
 
 */
		
	//Import File Koneksi Database
	require_once('connection.php');
	
	//Membuat SQL Query
	$sql = "SELECT id, fullName, userName, email, tanggalLahir, bio FROM user;";
	
	//Mendapatkan Hasil
	$r = mysqli_query($con,$sql);
	
	//Membuat Array Kosong 
	$result = array();
	
	while($row = mysqli_fetch_array($r)){
		
		//Memasukkan data kedalam Array Kosong yang telah dibuat 
		array_push($result,array(
			"id"=>$row['id'],
			"fullName"=>$row['fullName'],
			"userName"=>$row['userName'],
			"email"=>$row['email'],
			"tanggalLahir"=>$row['tanggalLahir'],
			"bio"=>$row['bio']
		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>