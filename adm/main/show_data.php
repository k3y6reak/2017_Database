<!DOCTYPE html>

<?php
   include_once "../includes/session.php";
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
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.html">Database Management System v1.0</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="./db_list.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Databases</span>
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
        include_once "../includes/dbconn.php";
        $tb_name = $_GET['tb_name'];
        $sql = "show columns from $tb_name";
        $result = mysql_query($sql);
        if(!$result)
        {
            echo mysql_error();
        }
    ?>

  <div class="content-wrapper">
    <div class="container-fluid">


    <form method="post" action="./execute.php">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="SQL" name="query">
            <span>
                <button class="btn btn-secondary" type="submit">Execute</button>
            </span>
        </div>
    </form>

    <?php

    if($_SESSION['msg'])
    {
    ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['msg']; ?>
        </div>
    <?php
        $_SESSION['msg'] = "";
    }

    ?>

        <div class="card mb-3" style="margin-top:10px;">
            <div class="card-header">
                <i class="fa fa-table"></i> Insert Data
            </div>
            <div class="card-body text-center">
                <div class="table-responsice">
                    <table class="table table-bordered" id="db_list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>

                                <?php
                                    $column_name = array();
                                    while ($row = mysql_fetch_row($result))
                                    {
                                        $column_name[] = $row[0];
                                ?>
                                    <th> <?php echo "{$row[0]}"; ?></th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <form method="post" action="./insert.php">
                                <input type="hidden" name="<?php echo $tb_name; ?>">
                                    <tr>
                                        <th>
                                            <button type="submit" class="btn btn-primary">Insert</button>
                                        </th>
                                        <?php
                                            for($i=0; $i<count($column_name); $i++)
                                            {
                                        ?>
                                                <td>
                                                    <input type="text" class="form-control" name="<?=$column_name[$i]; ?>">
                                                </td>
                                        <?php
                                            }
                                        ?>
                                    </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <?php
            $sql = "show columns from $tb_name";
            $result = mysql_query($sql);
            $column_name = array();
        ?>

        <div class="card mb-3" style="margin-top10px;">
            <div class="card-header">
                <i class="fa fa-table"></i> Data List
            </div>
            <div class="card-body text-center">
                <div class="table-responsice">
                    <table class="table table-dark" id="db_list" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php
                                    while ($row = mysql_fetch_row($result))
                                    {
                                        $column_name[] = $row[0];
                                ?>
                                        <th><?php echo "{$row[0]}"; ?></th>
                                <?php
                                    }
                                ?>
                            </tr>
                        </thead>
                        <?php
                            $sql = "select * from $tb_name";
                            $result = mysql_query($sql);
                            if(!$result)
                            {
                                echo mysql_error();
                            }
                        ?>
                        <tbody>
                            <?php
                                $count = 0;
                                 while($row = mysql_fetch_object($result))
                                 {
                            ?>
                                    <tr>
                                        <th>
                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modify<?=$count;?>">Modify</button>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$count;?>">Delete</button>
                                        </th>
                                        <?php
                                            for($i=0; $i<count($column_name); $i++)
                                            {
                                        ?>
                                                <td><?php echo $row->$column_name[$i]; ?></td>
                                        <?php
                                            }
                                        ?>
                                    </tr>

                                    <div class="modal" id="modify<?=$count?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="documnet">
                                            <div class="modal-content">
                                                <form method="post" action="./modify.php">
                                                    <div class="modal-header">
                                                        <input type="hidden" name="<?php echo $tb_name; ?>">
                                                        <h5 class="modal-title"><?php echo $tb_name; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php
                                                            if(mysql_field_type($result, 0) == "string")
                                                            {
                                                        ?>
                                                                <input type="hidden" name="<?=$column_name[0]."_"?>" value="<?php echo "\x27".$row->$column_name[0]."\x27"?>">
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <input type="hidden" name="<?=$column_name[0]."_"?>" value="<?php echo $row->$column_name[0]."_"?>">
                                                        <?php
                                                            }

                                                            for($i=0; $i<count($column_name); $i++)
                                                            {
                                                        ?>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon col-md-3"><?php echo $column_name[$i]?></span>
                                                                    <?php
                                                                        $type=mysql_field_type($result, $i);
                                                                        if($type == "string")
                                                                        {
                                                                    ?>
                                                                            <input type="text" class="form-control" name="<?=$column_name[$i]?>" value="<?php echo "\x27".$row->$column_name[$i]."\x27"?>">
                                                                    <?php
                                                                        }
                                                                        else
                                                                        {
                                                                    ?>
                                                                            <input type="text" class="form-control" name="<?=$column_name[$i]?>" value="<?php echo $row->$column_name[$i]?>">
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary" type="submit">Save Changes</button>
                                                        <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal" id="delete<?=$count?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="./delete.php">
                                                    <div class="modal-header">
                                                    <input type="hidden" name="<?php echo $tb_name; ?>">
                                                    <h5 class="modal-title"><?php echo $tb_name; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Real?</p>
                                                        <?php
                                                            if(mysql_field_type($result, 0) == "string")
                                                            {
                                                        ?>
                                                                <input type="hidden" name="<?=$column_name[0]?>" value="<?php echo "\x27".$row->$column_name[0]."\x27"?>">
                                                        <?php
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <input type="hidden" name="<?=$column_name[0]?>" value=<?php echo $row->$column_name[0]?> >
                                                        <?php
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $count++;
                                 }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

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
            <a class="btn btn-primary" href="../login/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="../js/sb-admin-datatables.min.js"></script>
    <script src="../js/sb-admin-charts.min.js"></script>
  </div>
</body>

</html>
