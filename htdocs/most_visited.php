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

			<div class="col-md-9" name="maincontent" id="maincontent">

				<div id="exercise" name="exercise" class="panel panel-info">
					<div class="panel-heading">
						<h5>ASDF Palace Database</h5>
					</div>
					<div class="panel-body">
						<!-- ***********Edit your content STARTS from here******** -->

						<form role="form" name="" action="most_visited.php" method="GET">
							Age Filter <br>
							<select class="form-control" name="agegroup">
								<option value=''> -- </option>
								<option value='20-40'>20-40</option>
								<option value='41-60'>41-60</option>
								<option value='61+'>61+</option>
							</select>
							Date Filter <br>
							<select class="form-control" name="date">
								<option value=''> -- </option>
								<option value=1>Last Month</option>
								<option value=12>Last Year</option>
							</select>
							<input class="btn btn-embosed btn-primary" type="submit" value="Search">
						</form>
						<hr>

						<?php
	
						$date = '';
						$agegroup = '';
						if (!empty($_GET['date']) && !empty($_GET['agegroup'])) {
							$date = $_GET['date'];
							$agegroup = $_GET['agegroup'];

							$bigquery = "SELECT facility_id, facility_name, visits FROM (select facility_id, facility_name, count(nfc_id) as visits, Team from most_visited where months<=$date group by Team, facility_id) as x where Team = '$agegroup' order by visits desc";

							$qr = mysqli_query($db, $bigquery);

							if ($qr == false) {
								echo ("Query cannot be executed:View cannot be created!<br>");
								echo ("SQL Error : " . mysqli_error($db));
							}
							//Check the record effected, if no records,
							//display a message

							if (mysqli_num_rows($qr) == 0) {
								echo ("Sorry, seems that no record found for Visits for the given parameters...<br>");
							} //end no record
							else { //there is/are record(s)
						?>
								<h5>Most visited facilities by age group:</h5><br>
								<table width="90%" class="table table-hover">
									<thead>
										<tr>
											<th>Visits</th>
											<th>Facility ID</th>
											<th>Facility Name</th>
										</tr>
									</thead>
									<?php
									while ($rekod = mysqli_fetch_array($qr)) { //redo to other records
									?>
										<tr>
											<td><?php echo $rekod['visits'] ?></td>
											<td><?php echo $rekod['facility_id'] ?></td>
											<td><?php echo $rekod['facility_name'] ?></td>
										</tr>
									<?php
									} //end of records
									?>
								</table>
						<?php
							}
						}
						else {
							echo ("You must select an age group and a date first...");
						} //end if there are records
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