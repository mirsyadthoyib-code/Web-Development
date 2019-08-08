<?php 

 /*
 
 penulis:	Muhammad Irsyad Thoyib
 proyek:	FaceTeknik
 
 */

	$id = $_GET['id'];
	
	//Import File Koneksi Database
	require_once('connection.php');
	
	//Membuat SQL Query
	$sql = "SELECT notification.id, fullName, date, alreadyRead FROM notification INNER JOIN (SELECT friendlist.idUser, idPost, fullName, date from friendlist INNER JOIN (SELECT post.id as idPost, post.idUser, fullName, date from post INNER JOIN user ON post.idUser = user.id) as poster on poster.idUser = friendlist.idFriend) as postteman ON notification.idPost = postteman.idPost where postteman.idUser = $id order by date desc;";
	
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
			"alreadyRead"=>$row['alreadyRead']
		));
	}
	
	//Menampilkan Array dalam Format JSON
	echo json_encode(array('result'=>$result));
	
	mysqli_close($con);
?>