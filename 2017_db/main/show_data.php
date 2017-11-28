<!DOCTYPE html>
<meta charset="utf-8"/>

<?php

  session_start();
  if(!isset($_SESSION['man_id']))
  {
    echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
    exit;
  }

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
</head>

<body style="background-image:url(&quot;../assets/img/main_sky.jpg&quot;);">
    <div style="height:600px;">
            <div class="row">
                <div class="col-md-2 float-left text-center">
                    <ul class="list-group">
                        <li class="list-group-item"><img src="../assets/img/logo.png" style="width:100%;"></li>
                        <li class="list-group-item"><span><a href="./db_list.php">Databases</a></span></li>
                        <li class="list-group-item"><span>test1</span></li>
                        <li class="list-group-item"><span>test2</span></li>
                        <li class="list-group-item"><span><a href="../login/logout.php">Logout</a></span></li>
                    </ul>
                </div>
                <div class="col-sm-6 float-right" style="height:600px;">
                    <div class="text-center" style="padding-top:15px;">
                    <?php
                        include_once "../dbconn/dbconn.php";
                        $tb_name = $_GET['tb_name'];
                        $sql = "show columns from $tb_name";
                        $result = mysql_query($sql);

                        if(!$result)
                        {
                            echo "DB Error, could not list data\n";
                            echo 'MySQL Error: ' . mysql_error();
                            exit;
                        }
                    ?>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="SQL" aria-label="SQL">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">Execute</button>
                                </span>
                        </div>

                        <table class="table table-striped table-dark" style="margin-top:10px;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                    <?php
                        $column_name = array();
                        while ($row = mysql_fetch_row($result))
                        {
                            $column_name[] = $row[0];
                    ?>

                                    <th scope="col"><?php echo "{$row[0]}"; ?></th>
                    <?php
                        }

                        mysql_free_result($result);
                    ?>
                                </tr>
                            </thead>


                            <?php
                                $sql = "select * from $tb_name";
                                $result = mysql_query($sql);

                                if(!$result)
                                {
                                    echo "Query Error\n";
                                    echo "MySQL Error: " . mysql_error();
                                    exit;
                                }
                            ?>

                            <tbody>
                                    <?php
                                        while ($row = mysql_fetch_object($result))
                                        {
                                    ?>
                                            <tr>
                                            <th scope="row">
                                                <button type="button" class="btn btn-warning">Modify</button>
                                                <button type="button" class="btn btn-danger">Delete</button>
                                            </th>

                                    <?php
                                            for($i=0; $i < count($column_name); $i++)
                                            {
                                    ?>
                                            <td><?php echo $row->$column_name[$i]; ?></td>
                                    <?php
                                            }
                                    ?>
                                            </tr>
                                    <?php
                                        }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>