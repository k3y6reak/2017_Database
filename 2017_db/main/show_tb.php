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
                    <div class="card-columns text-center">
                    <?php
                        include_once "../dbconn/dbconn.php";
                        $db_name = $_GET['name'];
                        $sql = "show tables from $db_name";
                        $result = mysql_query($sql);

                        if(!$result)
                        {
                            echo "DB Error, could not list tables\n";
                            echo 'MySQL Error: ' . mysql_error();
                            exit;
                        }

                        while ($row = mysql_fetch_row($result))
                        {
                    ?>
                        <div class="card"> <img class="card-img-top w-100 d-block" src="../assets/img/table.png" alt="tables">
                            <div class="card-body">
                                <h4 class="card-title"> <?php echo "{$row[0]}"; ?> </h4>
                                <button class="btn btn-primary" type="button" onclick="location.href='show_data.php?tb_name=<?php echo "{$row[0]}";?>'">Show Data</button>
                            </div>
                        </div>
                    <?php
                        }

                        mysql_free_result($result);
                    ?>
                    </div>
                </div>
            </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>