<?php
//include the database connectivity setting
include("inc/dbconn.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>ASDF Palace Database</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Loading Flat UI Pro -->
	<link href="css/flat-ui-pro.css" rel="stylesheet">
	<link rel="shortcut icon" href="img/favicon.ico">

</head>

<body>

	<?php
	//include the navigation bar
	include("inc/navbar.php"); ?>

	<div class="container">
		<br>
		<br>

		<div class="row">
			<div class="col-md-auto">
				<?php
				//include the sidebar menu
				include("inc/sidebar-menu.php"); ?>
			</div><!-- end main menu -->

			<div class="col-md-auto" name="maincontent" id="maincontent">

				<div id="exercise" name="exercise" class="panel panel-info">
					<div class="panel-heading">
						<h5>ASDF Palace Database</h5>
					</div>
					<div class="panel-body">
						<!-- ***********Edit your content STARTS from here******** -->

						<?php

						$query = "SELECT * FROM thecustomers";
						$qr = mysqli_query($db, $query);
						if ($qr == false) {
							echo ("Query cannot be executed!<br>");
							echo ("SQL Error : " . mysqli_error($db));
						}

						if (mysqli_num_rows($qr) == 0) {
							echo ("Sorry, seems that there aren't any customers recorded yet...<br>");
						} //end no record
						else { //there is/are record(s)
						?>
							<h5>Customers</h5><br>
							<div class="table-responsive">
								<table width="90%" class="table table-hover">
									<thead>
										<tr>
											<th>NFC ID</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Date of birth</th>
											<th>ID Number</th>
											<th>ID Type</th>
											<th>Publish Department of ID</th>
											<th>Phone Number</th>
											<th>Email</th>
											<th>Charges</th>
										</tr>
									</thead>
							</div>
							<?php
							while ($rekod = mysqli_fetch_array($qr)) { //redo to other records
							?>
								<tr>
									<td>
										<?php
										$id = $rekod['nfc_id'];
										echo $id;
										$urlview = "view-staff.php?id=$id";
										?>

									</td>
									<td><?php echo $rekod['first_name'] ?></td>
									<td><?php echo $rekod['last_name'] ?></td>
									<td><?php echo $rekod['date_of_birth'] ?></td>
									<td><?php echo $rekod['id_number'] ?></td>
									<td><?php echo $rekod['id_type'] ?></td>
									<td><?php echo $rekod['publish_dept_id'] ?></td>
									<td><?php echo $rekod['phone_num'] ?></td>
									<td><?php echo $rekod['email'] ?></td>
									<td><?php echo $rekod['total_charges'] ?></td>

								</tr>
							<?php
							} //end of records
							?>
							</table>
						<?php
						}
						?>

						<!-- ***********Edit your content ENDS here******** -->
					</div>
					<!--body panel main -->
				</div>
				<!--toc -->

			</div><!-- end main content -->

		</div>
	</div><!-- end container -->

	<?php
	//include the footer
	include("inc/footer.php"); ?>

</body>

</html>