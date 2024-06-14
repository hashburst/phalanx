<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top" onload="colorRow()">

  <!-- Page Wrapper -->
  <div id="wrapper">

  		<?php 

  			$dir = "/.wsprobes/";

  			if (is_dir($dir)) {
  				if ($dh = opendir($dir)) {
  					while(($file = readdir($dh)) !== false) {
  						$probes[$_GET['e']] = $file;
  					}
  				}
  			}

  			if (!file_exists($probes[$_GET['e']])) {
  				$url = "text.json"; //"http://hpvm.multimediatrader.com/kb/index.php";
				$file_headers = get_headers($url);
				//print_r($file_headers);

				$json = file_get_contents($url);
				$table = json_decode($json, true);

				$flag = true;
  			} else {
  				$flag = false;
  			}

			//print_r($table);

		?>

		<!-- Begin Page Content -->
		<div class="container-fluid">

			  <!-- DataTales Example -->
			  <div class="card shadow mb-4">
					
				<div class="card-body">
				  <div class="table-responsive">
					<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					  <thead>
						<tr>
						  <th>#</th>
						  <th>Date & Time</th>
						  <th>IP</th>
						  <th>User Agent</th>
						  <th>Gravity</th>
						  <th>Payload</th>
						</tr>
					  </thead>
					  <tfoot>
						<tr>
						  <th>#</th>
						  <th>Date & Time</th>
						  <th>IP</th>
						  <th>User Agent</th>
						  <th>Gravity</th>
						  <th>Payload</th>
						</tr>
					  </tfoot>
					  <tbody>
					  	
						<?php

							$good = 0;
							$warn = 0;
							$dang = 0;


							if ($flag === true) {
								$row = 0;

								foreach($table['alerts'] as $tab) {

									$time = $tab['timeUTC'];
									$ip = $tab['ip'];
									$ua = $tab['ua'];
									$type = $tab['type'];
									$payload = $tab['payload'];

									
									switch($type) {
										case 1: echo "<tr id=\"tr".$row."\" style=\"background-color:#ffbe00; color:black\">"; break;
										case 2: echo "<tr id=\"tr".$row."\" style=\"background-color:#c50000; color:white\">"; break;
										default: echo "<tr id=\"tr".$row."\">";
									}
									echo "<td style=\"text-align:center\"><input id=\"input".$row."\" type=\"radio\" onclick=\"vulnManager(".$row.")\"> ".$row."</td>";
									echo "<td>".$time."</td>";
									echo "<td>".$ip."</td>";
									if ($ua == "") {
										echo "<td>null</td>";
									} else {
										echo "<td>".$ua."</td>";
									}
									switch ($type) {
										case 0: echo "<td id=\"rel".$row."\">Not Relevant</td>"; $good++; break;
										case 1: echo "<td id=\"rel".$row."\"><b>Relevant</b></td>"; $warn++; break;
										case 2: echo "<td id=\"rel".$row."\"><b>Very Relevant</b></td>"; $dang++; break;
									}
									echo "<td>".$payload."</td>";
									echo "</tr>";
								
									$row++;
								/*
									if ($key == 'timeUTC') {
										$row++;
										echo "<tr id=\"tr".$row."\">";
										echo "<td style=\"text-align:center\"><input id=\"input".$row."\" type=\"radio\" onclick=\"vulnManager(".$row.")\"> ".$row."</td>";
										echo "<td>".$value."</td>";
									} elseif ($key == 'ua') {
										if ($value == "") {
											echo "<td>null</td>";
										} else {
											echo "<td>".$value."</td>";
										}
									} elseif ($key == 'ip') {
										echo "<td>".$value."</td>";
									} elseif ($key == 'type') {

										switch ($value) {
											case 0: echo "<td id=\"rel".$row."\" onload=\"colorRow(".$row.", 0)\">Not Relevant</td>"; $good++; break;
											case 1: echo "<td id=\"rel".$row."\" onload=\"colorRow(".$row.", 1)\">Relevant</td>"; $warn++; break;
											case 2: echo "<td id=\"rel".$row."\" onload=\"colorRow(".$row.", 2)\">Very Relevant</td>"; $dang++; break;
										}
										
									} elseif ($key == 'payload') {
										echo "<td>".$value."</td>";
										echo "</tr>";
									}

									*/
								}
							} else {
								echo "<td colspan='6'>No Data</td>";
							}

							
						?>
						
					  </tbody>
					</table>
					<!-- End of Table -->
				  </div>
				  <!-- End of Table Responsive -->
				</div>
				<!-- End of Card Body -->
			  </div>
			  <!-- End of Table Example General -->




			</div>
			<!-- /.container-fluid -->

		  </div>
		  <!-- End of Main Content -->

		</div>
		<!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

	<script type="text/javascript">
		function vulnManager(id) {
			document.getElementById("tr"+id).style.backgroundColor = "#009300";
			document.getElementById("tr"+id).style.color = "#ffffff";
			document.getElementById("rel"+id).innerHTML = "managed";
			document.getElementById("input"+id).style.display = "none";
		}
	</script>

	<script type="text/javascript">
		function colorRow() {

			var table = document.getElementById("dataTable");
			for (var i = 0, row; row = table.rows[i]; i++) {

				switch(row[4]) {
					case '0': break;
					case '1': document.getElementById("tr"+id).style.backgroundColor = "#ffbe00"; break;
					case '2': document.getElementById("tr"+id).style.backgroundColor = "#c50000"; break;
				}
			}
		}
	</script>

</html>
