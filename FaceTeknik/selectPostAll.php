<?php 

 /*
 
 penulis:	Muhammad Irsyad Thoyib
 proyek:	FaceTeknik
 
 */

	$id = $_GET['id'];
	
	//Import File Koneksi Database
	require_once('connection.php');
	
	//Membuat SQL Query
	$sql = "SELECT postingan.id, fullName, image, text, date FROM user INNER JOIN (SELECT friendlist.idUser as idUser, idFriend, post.id as id ,date, image, text from friendlist inner join post on friendlist.idFriend = post.idUser) as postingan ON user.id = postingan.idFriend where postingan.idUser = $id union SELECT post.id, fullName, image, text, date FROM user inner join post on user.id = post.idUser where idUser = $id order by date DESC;";
	
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