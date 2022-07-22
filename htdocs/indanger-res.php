<?php
//include the database connectivity setting
include("inc/dbconn.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Hotel Database</title>
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

            <form role="form" name="" action="indanger-res.php" method="GET">
              <div class="form-group">

                NFC ID Filter<br>
                <input class="form-control" name="nfcid" type="text" placeholder="Give me a nfc id ..." value="<?php echo isset($_GET['nfcid']) ? htmlspecialchars($_GET['nfcid'], ENT_QUOTES) : ''; ?>">

                <input type="hidden" name="nfc" value="<?= $_GET['nfc'] ?>">
                <input class="btn btn-embosed btn-primary" type="submit" value="Search">
              </div>
            </form>
            <hr>

            <?php
            $nfcidqr = '';

            $counter = 0;
            if (!empty($_GET['nfcid'])) {
              $nfcidans = $_GET['nfcid'];
              $nfcidqr = "CoV2_positive = '$nfcidans'";
              $counter++;
            }

            $arr = array($nfcidqr);
            if ($counter > 0) {
              $bigquery = "SELECT * FROM min2 WHERE ";
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
              $bigquery = "SELECT * FROM min2";
            }

            //Create SQL query
            $nfcidanswer = $_GET['nfcid'];
            $queryview = "CREATE VIEW min2 AS SELECT * FROM min WHERE CoV2_positive = $nfcidanswer";

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
              echo ("Seems like everyone is safe!<br>");
            } //end no record
            else { //there is/are record(s)
            ?>
              <h5>Customers in danger because of contact with positive case, which has NFC ID: "<?php echo $nfcidanswer; ?>"</h5><br>
              <table width="90%" class="table table-hover">
                <thead>
                  <tr>
                    <th>NFC ID</th>
                    <th>Entrance Datetime</th>
                    <th>Positive's Customer Exit Datetime</th>
                  </tr>
                </thead>
                <?php
                while ($rekod = mysqli_fetch_array($qrfiltered)) { //redo to other records
                ?>
                  <tr>
                    <td><?php echo $rekod['nfc_id'] ?></td>
                    <td><?php echo $rekod['entrance_datetime'] ?></td>
                    <td><?php echo $rekod['sick_person_left'] ?></td>
                  </tr>
                <?php
                } //end of records
                ?>
              </table>
            <?php
            } //end if there are records
            $query = "DROP VIEW min2";
            $qr = mysqli_query($db, $query);
            if ($qr == false) {
              echo ("Query cannot be executed:view cannot be dropped!<br>");
              echo ("SQL Error : " . mysqli_error($db));
            }

            //end db search
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