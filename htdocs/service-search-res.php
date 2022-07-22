<?php
//include the database connectivity setting
include("inc/dbconn.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Hotel database</title>
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

			<div class="col-md-9" name="maincontent" id="maincontent">

				<div id="exercise" name="exercise" class="panel panel-info">
					<div class="panel-heading">
						<h5>ASDF Palace Database</h5>
					</div>
					<div class="panel-body">
						<!-- ***********Edit your content STARTS from here******** -->

						<form role="form" name="" action="service-search-res.php" method="GET">
							<div class="form-group">
								Date Filter<br>
								<div style="float:left;width:395px">
									<input class="form-control" name="datefrom" type="text" placeholder="Give me a date range from..." value="<?php echo isset($_GET['datefrom']) ? htmlspecialchars($_GET['datefrom'], ENT_QUOTES) : ''; ?>">
								</div>
								<div style="float:right;width:395px">
									<input class="form-control" name="dateto" type="text" placeholder="...to" value="<?php echo isset($_GET['dateto']) ? htmlspecialchars($_GET['dateto'], ENT_QUOTES) : ''; ?>">
								</div>
								Fee Filter <br>
								<div style="float:left;width:395px">
									<input class="form-control" name="costfrom" type="text" placeholder="Give me a cost range from..." value="<?php echo isset($_GET['costfrom']) ? htmlspecialchars($_GET['costfrom'], ENT_QUOTES) : ''; ?>">
								</div>
								<div style="float:right;width:395px">
									<input class="form-control" name="costto" type="text" placeholder="...to" value="<?php echo isset($_GET['costto']) ? htmlspecialchars($_GET['costto'], ENT_QUOTES) : ''; ?>">
								</div>

								Description Filter<br>
								<input class="form-control" name="category" type="text" placeholder="Give me a category name..." value="<?php echo isset($_GET['category']) ? htmlspecialchars($_GET['category'], ENT_QUOTES) : ''; ?>">

								<input type="hidden" name="serviceid" value="<?= $_GET['serviceid'] ?>">
								<input class="btn btn-embosed btn-primary" type="submit" value="Search">
							</div>
						</form>
						<hr>

						<?php

						$datefromqr = '';
						$datetoqr = '';
						$costfromqr = '';
						$costtoqr = '';
						$categoryqr = '';
						$counter = 0;
						if (!empty($_GET['datefrom'])) {
							$datefromans = $_GET['datefrom'];
							$datefromqr = "charge_date >= '$datefromans'";
							$counter++;
						}
						if (!empty($_GET['dateto'])) {
							$datetoans = $_GET['dateto'];
							$datetoqr = "charge_date <= '$datetoans'";
							$counter++;
						}
						if (!empty($_GET['costfrom'])) {
							$costfromans = $_GET['costfrom'];
							$costfromqr = "service_fee >= $costfromans";
							$counter++;
						}
						if (!empty($_GET['costto'])) {
							$costtoans = $_GET['costto'];
							$costtoqr = "service_fee <= $costtoans";
							$counter++;
						}
						if (!empty($_GET['category'])) {
							$categoryans = $_GET['category'];
							$categoryqr = "charge_description LIKE '%$categoryans%'";
							$counter++;
						}
						$arr = array($datefromqr, $datetoqr, $costfromqr, $costtoqr, $categoryqr);
						if ($counter > 0) {
							$bigquery = "SELECT * FROM Selected_Service WHERE ";
							foreach ($arr as &$value) {
								if ($value != '') {
									$bigquery = $bigquery . $value;
									if ($counter > 1) {
										$bigquery = $bigquery . " AND ";
									}
									$counter--;
								}
							}
						} else {
							$bigquery = "SELECT * FROM Selected_Service";
						}
						//if there's user search - then perform db search
						//Create SQL query
						$serviceidanswer = $_GET['serviceid'];
						$queryview = "CREATE VIEW Selected_Service AS SELECT * FROM Yphresies WHERE service_id = $serviceidanswer";
						//Execute the query
						$qr = mysqli_query($db, $queryview);
						if ($qr == false) {
							echo ("Query cannot be executed:View cannot be created!<br>");
							echo ("SQL Error : " . mysqli_error($db));
						}

						$qrfiltered = mysqli_query($db, $bigquery);
						if ($qrfiltered == false) {
							echo ("Query cannot be executed!<br>");
							echo ("SQL Error : " . mysqli_error($db));
						}
						//Check the record effected, if no records,
						//display a message				

						if (mysqli_num_rows($qrfiltered) == 0) {
							echo ("Sorry, seems that no record found for Service with id: $serviceidanswer for the given parameters...<br>");
						} //end no record
						else { //there is/are record(s)
						?>
							<h5>Search results for the service transactions made in hotel "<?php echo $serviceidanswer; ?>"</h5><br>
							<table width="90%" class="table table-hover">
								<thead>
									<tr>
										<th>NFC ID</th>
										<th>Charge Description</th>
										<th>Service fee</th>
										<th>Date</th>
									</tr>
								</thead>
								<?php
								while ($rekod = mysqli_fetch_array($qrfiltered)) { //redo to other records
								?>
									<tr>
										<td><?php echo $rekod['nfc_id'] ?></td>
										<td><?php echo $rekod['charge_description'] ?></td>
										<td><?php echo $rekod['service_fee'] ?></td>
										<td><?php echo $rekod['charge_date'] ?></td>
									</tr>
								<?php
								} //end of records
								?>
							</table>
						<?php
						} //end if there are records
						$query = "DROP VIEW Selected_Service";
						$qr = mysqli_query($db, $query);
						if ($qr == false) {
							echo ("Query cannot be executed:view cannot be dropped!<br>");
							echo ("SQL Error : " . mysqli_error($db));
						}
						//}//end db search
						?>

						<!-- ***********Edit your content ENDS here******** -->
					</div>
					<!--body panel main -->
				</div>
				<!--toc -->

			</div><!-- end main content -->

			<div class="col-md-3">
				<?php
				//include the sidebar menu
				include("inc/sidebar-menu.php"); ?>
			</div><!-- end main menu -->
		</div>
	</div><!-- end container -->

	<?php
	//include the footer
	include("inc/footer.php"); ?>

</body>

</html>