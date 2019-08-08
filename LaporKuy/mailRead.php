<!doctype html>
<html>
<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="stylesLaporKuy.css">
	<link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
	<script>
		<!-- Fungsi update tanggal pemrosesan -->
		function proceedForm(str) {
		  var xhttp;  
		  alert("Laporan telah di proses");
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) 
			{}
		  };
		  xhttp.open("GET", "updateProceed.php?id="+str, true);
		  xhttp.send();
		}
		
		<!-- Fungsi update tanggal laporan selesai -->
		function finishedForm(str) {
		  var xhttp;  
		  alert("Laporan telah selesai");
		  xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) 
			{}
		  };
		  xhttp.open("GET", "updateFinished.php?id="+str, true);
		  xhttp.send();
		}
	</script>
	<div class="mail-box">
		<?php
		// Variabel koneksi
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
		
		// ID dari laporan
		$id = $_GET['id'];
		
		// Update database untuk menandakan laporan telah dibaca
		$sql = "SELECT * FROM reportInbox where id = ".$id."";
		$wasRead = "UPDATE `reportInbox` SET `wasRead` = '1' WHERE id = ".$id."";
		mysqli_query($conn, $wasRead);
		?>
		
		<!-- Bagian kiri tampilan -->
		<aside class="sm-side">
			<!-- Logo polri dan Nama Polri -->
			<div class="polri-logo-background">
				<aside>
					<a class="inbox-avatar" href="javascript:;">
						<img  width="64" hieght="60" src="logoPolri.png">
					</a>
				</aside>
				<aside>
					<div class="polri-name">
						<h5> <a href="#">POLRI</a> </h5>
						<span> <a href="#">KEPOLISIAN NEGARA REPUBLIK INDONESIA </a> </span>
					</div>
				</aside>
			</div>
			
			<!-- List folder laporan -->
			<ul class="mail-type-navigation mail-type-divider">
				<li class="active">
					<a href="reportInbox.php">
						<i class="fa fa-inbox"></i>Report Inbox 
						<span class="label label-danger pull-right">
						
							<!-- Penanda jumlah laporan yang belum dibaca -->
							<?php
							$countRead = "SELECT count(*) as unread FROM `reportInbox` where wasRead = 0";
							$countReadResult = mysqli_query($conn, $countRead);
							if(mysqli_num_rows($countReadResult) > 0) 
							{
								while($row = mysqli_fetch_assoc($countReadResult)) 
								{
									echo $row["unread"];
								}
							}
							?>
						</span>
					</a>
				</li>
				<li>
					<a href="reportFeedback.php"><i class="fa fa-bookmark-o"></i>Report Follow Up
						<span class="label label-info pull-right"">
							<!-- Penanda jumlah laporan yang belum dibaca -->
							<?php
							$countRead = "SELECT count(*) as unread FROM `reportfeedback` where wasRead = 0";
							$countReadResult = mysqli_query($conn, $countRead);
							if(mysqli_num_rows($countReadResult) > 0) 
							{
								while($row = mysqli_fetch_assoc($countReadResult)) 
								{
									echo $row["unread"];
								}
							}
							?>
						</span>
					</a>
				</li>
			</ul>
		</aside>
		
		<!-- Bagian kanan tampilan -->
		<aside class="lg-side">
			<div class="mail-type-head">
				<h3>Report Inbox</h3>
			</div>
			<div class="mail-type-divider" style="background-color:white; min-height:50px; padding-top: 6px; padding: 10px;">
				<aside style="float:left">
				
					<!-- Tombol kembali ke report inbox -->
					<aside style="padding-right:10px">
						<form action="reportInbox.php">
							<button type="submit"; class="btn btn-default"; style="background-color:#ffffff";>
								<span class="glyphicon glyphicon-chevron-left"></span>
							</button>
						</form>
					</aside>
					
					<!-- Judul laporan -->
					<aside>
						<h4 style="color:black">
							<?php
							$result = mysqli_query($conn, $sql);
							if(mysqli_num_rows($result) > 0) 
							{
								while($row = mysqli_fetch_assoc($result)) 
								{
									echo "" . $row["title"]. "<br>";
								}
							} 
							?>
						</h4>
					</aside>
				</aside>
				
				<!-- Tombol pemrosesan dan penyelesaian laporan -->
				<aside style="float:right">
					<?php
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result) > 0) 
					{
						while($row = mysqli_fetch_assoc($result)) 
						{
							$proceed = $row["proceed"];
							$finish = $row["finish"];
						}
					}
					if($proceed == 0)
					{
						echo "	<button type='submit' class='btn btn-default' style='background-color:#FFD700; color:white' onclick='proceedForm(".$id.")' >
								<span> Proceed </span>
								</button>
							 ";
					}
					if($proceed == 1 and $finish == 0)
					{
						echo "	<button type='submit' class='btn btn-default' style='background-color:#FFD700; color:white' onclick='finishedForm(".$id.")'>
									<span> Finished </span>
								</button>
							 ";
					}
					?>
				</aside>
			</div>
			<div style="min-height:50px; padding-top: 6px; padding: 10px;">
				<div>
				
					<!-- Nama pengirim dan ktp -->
					<aside style="width:50%; float:left">
					Pengirim :
						<?php
						$result = mysqli_query($conn, $sql);
						if(mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
								echo "" . ucwords($row["name"]). " (" . $row["ktp"] .")<br>";
							}
						} 
						?>
					</aside>
					
					<!-- Tanggal laporan masuk -->
					<aside style="width:50%; float:right"; align="right">
						<?php
						$result = mysqli_query($conn, $sql);
						if(mysqli_num_rows($result) > 0)
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
								echo "" . $row["deto"]. "<br>";
							}
						}
						?>
					</aside>
				</div>
				<br/>
				
				<!-- Deskripsi laporan masuk -->
				<div style="padding-top:30px;">
				Deskripsi :
					<div style="padding:30px; padding-top:5px;">
						<?php
						$result = mysqli_query($conn, $sql);

						if(mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
								echo "" . $row["description"]."<br>";
							}
						} 
						?>
					</div>
				</div>
				
				<!-- Alamat dan koordinat kejahatan -->
				<div style="padding-top:30px;">
				Alamat :
					<div style="padding:30px; padding-top:5px;">
						<?php
						$result = mysqli_query($conn, $sql);

						if(mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
								echo "" . $row["address"]."<br>";
								echo "Latitude  : " . $row["latitude"]."<br>";
								echo "Longitude : " . $row["longtitude"]."<br>";
							}
						} 
						?>
					</div>
				</div>
				
				<!-- Tanggal pemrosesan dan tanggal selesai -->
				<div style="padding-top:30px;">
				Tanggal :
					<div style="padding:30px; padding-top:5px;">
						<?php
						$result = mysqli_query($conn, $sql);

						if(mysqli_num_rows($result) > 0) 
						{
							while($row = mysqli_fetch_assoc($result)) 
							{
								echo "Pemrosesan : " . $row["proceedDate"]."<br>";
								echo "Selesai    : " . $row["finishDate"]."<br>";
							}
						} 
						?>
					</div>
				</div>
			</div>
		</aside>
	</div>
</body>
</html>