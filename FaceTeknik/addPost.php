<?php

 /*
	add post
 
 */

	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		$image = NULL;
		$text = NULL;
		
		//Mendapatkan Nilai Variable
		$idUser = $_POST['idUser'];
		$image = $_POST['image'];
		$text = $_POST['text'];
		
		//Pembuatan Syntax SQL
		$sql = "INSERT INTO post (idUser, image, text) VALUES ('$idUser', '$image', '$text')";
		
		//Import File Koneksi database
		require_once('connection.php');
		
		//Eksekusi Query database
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Menambahkan Post';
		}else{
			echo 'Gagal Menambahkan Post';
		}
		
		$sql = "Select id from post where idUser = '$idUser' and image = '$image 'and text = '$text'";
		
		//Mendapatkan Hasil
		$r = mysqli_query($con,$sql);
		
		//Membuat Array Kosong 
		$result = array();
		
		while($row = mysqli_fetch_array($r)){
			
			//Memasukkan data kedalam Array Kosong yang telah dibuat 
			array_push($result,array(
				"id"=>$row['id']
			));
			
			$sql = "INSERT INTO notification (idPost) VALUES ('".$row['id']."')";
		}
		
		
		
		
		//Eksekusi Query database
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Menambahkan notif';
		}else{
			echo 'Gagal Menambahkan notif';
		}
		
		mysqli_close($con);
	}
?>