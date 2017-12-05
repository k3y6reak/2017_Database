<!DOCTYPE html>

<?php
   include_once "../../includes/session.php";
?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>DBMS</title>
  <!-- Bootstrap core CSS-->
  <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">MAIL_ORDER</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Parts">
          <a class="nav-link" href="./parts_list.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Part List</span>
          </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Basket">
            <a class="nav-link" href="./basket_list.php">
                <i class="fa fa-fw fa-table"></i>
                <span class="nav-link-text">Basket</span>
            </a>
        </li>
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Purchase">
            <a class="nav-link" href="./purchase_list.php">
                <i class="fa fa-fw fa-table"></i>
                <span class="nav-link-text">Purchase</span>
            </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>

    <?php
        include_once "../../includes/dbconn.php";
    ?>

  <div class="content-wrapper">
    <div class="container-fluid">
        <?php
        $count=0;
        $sql = "select * from purchase where";
        foreach($_POST as $key=>$value)
        {
            if($count==0)
            {
                $sql = $sql. " " . $key . "=" . $value;
            }
            $count++;
        }
        $sql_tb = $sql;
        $result = mysql_query($sql);
        if(!$result)
        {
            echo mysql_error();
        }
        else
        {
            $row_pur = mysql_fetch_object($result);
        }
        ?>
        <h3>Purchase List</h3>
        <form method="post" action="./confirm.php">
            <div class="form-group row text-center">
                <label for="pur_num" class="col-sm-2 col-form-label">Purchase Number</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" name="pur_num" value="<?=$row_pur->pur_num;?>" readonly>
                </div>
            </div>
            <div class="form-group row text-center">
                <label for="f_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="f_name" value="<?=$row_pur->cust_f_name;?>" readonly>
                </div>
                <label for="l_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="l_name" value="<?=$row_pur->cust_l_name;?>" readonly>
                </div>
            </div>

            <table class="table table-dark" id="purchase" width="100%" cellspacing="0">
<?php
                $sql = "show columns from purchase";
                $result_table = mysql_query($sql);
                $column_name = array();
                while($row = mysql_fetch_row($result_table))
                {
                    $column_name[] = $row[0];
                }
            ?>
                <thead>
                    <tr>
                        <th><?php echo $column_name[3]; ?></th>
                        <th><?php echo $column_name[4]; ?></th>
                        <th><?php echo $column_name[5]; ?></th>
                        <th><?php echo $column_name[6]; ?></th>
                    </tr>
                </thead>

                <tbody>
<?php
                    $result = mysql_query($sql_tb);
                    
                    while($row = mysql_fetch_object($result))
                    {
                ?>
                        <tr>
                            <th>
                               <?php echo $row->part_num;?>
                                <td><?php echo $row->part_name;?></td>
                                <td><?php echo $row->quantity;?></td>
                                <td><?php echo $row->price; ?></td>
                            </th>
                        </tr>
                <?php
                    }
                ?>

                </tbody>

            </table>




             <div class="form-group row text-center">
                <label for="all_price" class="col-sm-2 col-form-label">All Price</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="all_price" value="" readonly>
                </div>
            </div>
             <div class="form-group row text-center">
                <label for="emp_f_name" class="col-sm-2 col-form-label">Emp First Name</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="emp_f_name" value="<?=$row_pur->emp_f_name; ?>" readonly>
                </div>
                <label for="emp_l_name" class="col-sm-2 col-form-label">Emp Last Name</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="emp_l_name" value="<?=$row_pur->emp_l_name; ?>" readonly>
                </div>
            </div>
             <div class="form-group row text-center">
                <label for="actual_date" class="col-sm-2 col-form-label">Actual Date</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="acutal_date" value="<?=$row_pur->actual_date;?>" readonly>
                </div>
                <label for="exp_date" class="col-sm-2 col-form-label">Expect Date</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="exp_date" value="<?=$row_pur->expect_date;?>" readonly>
                </div>
            </div>
             <div class="form-group row text-center">
                <label for="recv_date" class="col-sm-2 col-form-label">Recevie Date</label>
                <div class="col-sm-4">
                <input type="text" class="form-control" id="recv_date" value="<?=$row_pur->recevie_date;?>" readonly>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm</button>
        </form>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Database Management System</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="../../login/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../../vendor/chart.js/Chart.min.js"></script>
    <script src="../../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="../../js/sb-admin-datatables.min.js"></script>
    <script src="../../js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
