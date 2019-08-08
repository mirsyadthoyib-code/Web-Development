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
		setInterval("my_function();",5000); 
		function my_function()
		{
		  $(' #table-div').load(location.href + ' #table-body');
		}
	</script>
	<div class="mail-box">
		<?php
		include_once("config.php");
		
		// Batas jumlah laporan per halaman
		$batas = 13;
		
		// 
		$pg = isset($_GET['pg']) ? $_GET['pg'] : "";
		if(empty($pg)) 
		{
			$posisi = 0;
			$pg = 1;
			
			if(!empty($_POST["searchInput"]))
			{
				$search = $_POST["searchInput"];
				$sql = "SELECT * FROM `reportInbox` where name like '%". $search ."%' or title like '%". $search ."%' or description like '%". $search ."%' ORDER BY id DESC limit ". $batas ." offset ". $posisi ."";
			}
			else
			{
				$sql = "SELECT * from reportinbox ORDER BY id DESC limit ". $batas ." offset ". $posisi ."";
			}
		} 
		else 
		{
			$posisi = ($pg - 1) * $batas;
			
			if(!empty($_POST["searchInput"]))
			{
				$search = $_POST["searchInput"];
				$sql = "SELECT * FROM `reportInbox` where name like '%". $search ."%' or title like '%". $search ."%' or description like '%". $search ."%' ORDER BY id DESC limit ". $batas ." offset ". $posisi ."";
			}
			else
			{
				$sql = "SELECT * from reportinbox ORDER BY id DESC limit ". $batas ." offset ". $posisi ."";
			}
		}
		
		//Hitung jumlah laporan
		$allData = mysqli_query($conn, "select * from reportinbox");
		$jml_data = mysqli_num_rows($allData);
		
		//Jumlah laporan pada halaman saat ini
		$result = mysqli_query($conn, $sql);
		$jml_data_page = mysqli_num_rows($result);
		
		//Jumlah halaman
		$jmlHalaman = ceil($jml_data/$batas); //ceil digunakan untuk pembulatan keatas
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
					<a href="reportInbox.php"><i class="fa fa-inbox"></i>Report Inbox 
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
			  
			  <!-- Kotak pencarian laporan -->
			  <form method="post" action="reportInbox.php" class="pull-right position">
				  <div class="input-append">
					  <input name="searchInput" type="text" class="search-box" placeholder="Search Mail" style="background-color:#ffffff">
					  <button class="btn search-button" type="submit"><i class="fa fa-search"></i></button>
				  </div>
			  </form>
			</div>
			<div id="inbox-body" class="inbox-body">
				<div class="mail-option">
				
					<!-- Navigasi laporan -->
					<ul class="unstyled inbox-pagination">
						<li>
							<span>
								<?php
									echo $posisi+1 . " - ";
									if($posisi + $jml_data_page < $jml_data)
									{
										echo ($posisi + $jml_data_page);
									}
									else
									{
										echo $jml_data;
									}
									echo " of " . $jml_data;
								?>
							</span>
						</li>
						<li>
						
							<!-- Navigasi ke laporan terbaru -->
							<?php
							if ($pg > 1) 
							{
								$link = $pg-1;
								echo "<a class='np-btn' href='?pg=$link'><i class='fa fa-angle-left  pagination-left'></i></a>";
							} 
							else 
							{
								echo "<a class='np-btn' href=''><i class='fa fa-angle-left  pagination-left'></i></a>";
							}
							?>
						</li>
						<li>
							<!-- Navigasi ke laporan lama -->
							<?php
							if ($pg < $jmlHalaman) 
							{
								$link = $pg + 1;
								echo "<a class='np-btn' href='?pg=$link'><i class='fa fa-angle-right pagination-right'></i></a>";
							} 
							else 
							{
								echo "<a class='np-btn' href=''><i class='fa fa-angle-right pagination-right'></i></a>";
							}
							?>
						</li>
					</ul>
				</div>
				<div id="table-div">
				
					<!-- Tabel daftar laporan kejahatan -->
					<table id="table-body" class="table table-inbox table-hover">
						<tbody>
							<?php		
							$i = 0;
							if(mysqli_num_rows($result) > 0) 
							{
								while($row = mysqli_fetch_assoc($result)) 
								{
									$i++;
									echo '	<tr class="';
											if($row["wasRead"] == 0)
											{
												echo 'unread';
											}
											
									echo '	"; onclick="window.location= '." 
											'mailRead.php?id=".$row['id']. "' ".' ";> 
											';
									
									//Kolom logo on progress atau finish
									echo '	<td class="inbox-small-cells">
											';
											if($row["proceed"] == 1 and $row["finish"] == 0)
											{
												echo '<center><img width="35" hieght="35" src="logoInProgress.jpg"></center>
													';
											}
											else if($row["proceed"] == 1 and $row["finish"] == 1)
											{
												echo '<center><img width="30" hieght="30" src="logoReportFinish.jpg"></center>
													';
											}
											
									echo '	</td>
											';
									
									//Kolom nama pengirim
									echo '	<td class="view-message  dont-show">'
											. ucwords($row["name"]). '</td>
											';
										
									//Kolom judul laporan
									echo '	<td class="view-message ">
											'. $row["title"]. '
											</td>
											<td class="view-message  inbox-small-cells"></i></td>
											';
									
									//Kolom waktu laporan masuk
									echo '	<td class="view-message  text-right">
											'. $row["deto"]. '
											</td>
											</tr>
											';
								}
							} 
							else
							{
								echo "<h1> <center>Report Not Found</center> </h1>";
								echo "<center><img src='reportNotFound.JPG' width='400'></center>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</aside>
	</div>
</body>
</html>