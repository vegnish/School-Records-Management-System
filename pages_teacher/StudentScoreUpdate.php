<!DOCTYPE html>
<?php 
	include("header.php");
	require_once '../db_connect.php';
?>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Student Score Update</title>
		<link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
		<link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../css/style.css">
		<link rel="shortcut icon" href="../images/favicon.png" />
	</head>

	<body>
		<div class="container-scroller">
			<?php 
				include("nav.php"); 
			?>
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="row">
						<div class="col-md-12 d-flex align-items-stretch grid-margin">
							<div class="row flex-grow">
								<div class="col-12">
									<div class="card">
										<div class="card-body">
											<div class="page-header clearfix">
												<h2 style="float:left">Scores Update</h2>				
											</div>
											</br>
											<form class="forms-sample" method="post">
												<table id="recent-orders" class="table table-hover table-xl mb-0">
													<thead>
														<tr>
															<th class="border-top-0">Subject ID</th>
															<th class="border-top-0">Subject Name</th>   
															<th class="border-top-0">Score</th> 
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>BM001</td>
															<td>BM</td>
															<td>
																<div class="form-group">
																	<input type="text" class="form-control" name="score" value="90" required> <!-- value will be extrcted from database -->
																</div>
															</td>
														</tr>
														<tr>
															<td>EN1266</td>
															<td>English</td>
															<td>
																<div class="form-group">
																	<input type="text" class="form-control" name="score" value="75" required>
																</div>
															</td>
														</tr>
													</tbody>
												</table>
												<button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
												<input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='StudentView.php'"/>
											</form>									
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php 
					include("../footer.php"); 
				?>
			</div>
		</div>
		<script src="../vendors/js/vendor.bundle.base.js"></script>
		<script src="../vendors/js/vendor.bundle.addons.js"></script>
		<script src="../js/off-canvas.js"></script>
		<script src="../js/misc.js"></script>
	</body>
</html>