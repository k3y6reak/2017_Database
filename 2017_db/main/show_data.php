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
                    <form method="post" action="./execute.php">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="SQL" name="query">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">Execute</button>
                        </span>
                    </div>
                    </form>
                    <?php
                    if($_SESSION['msg'])
                    {
                    ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['msg'] ?>
                        </div>
<?php
                        $_SESSION['msg'] = "";
}
?>


                    <table class="table table-striped" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <?php
                                $column_name = array();
                                while($row = mysql_fetch_row($result))
                                {
                                    $column_name[] = $row[0];
                                ?>
                                    <th scope="col"><?php echo "{$row[0]}"; ?></th>
                                <?php
                                }
                                ?>
                            </tr>
                        </thead>

                        <tbody>
                        <form method="post" action="./insert.php">
                            <input type="hidden" name="<?php echo $tb_name; ?>">
                            <tr>
                                <th scope="row">
                                    <button type="submit" class="btn btn-primary">Insert</button>
                                </th>

                                <?php
                                    for($i=0; $i< count($column_name); $i++)
                                    {
                                ?>
                                        <td>
                                            <input type="text" class="form-control" name="<?=$column_name[$i]?>">
                                        </td>
                                <?php
                                    }
                                ?>

                            </tr>
                        </form>
                        </tbody>
                    </table>


                    <table class="table table-striped table-dark" style="margin-top:10px;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <?php
                                $sql = "show columns from $tb_name";
                                $result = mysql_query($sql);
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
                            <?php $count = 0;
                            while ($row = mysql_fetch_object($result))
                            {
                                ?>
                                <tr>
                                    <th scope="row">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modify<?=$count?>">Modify</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$count?>">Delete</button>
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

                                <div class="modal" id="modify<?=$count?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="post" action="./modify.php">
                                                <div class="modal-header">
                                                    <input type="hidden" name="<?php echo $tb_name; ?>">
                                                    <h5 class="modal-title"><?php echo $tb_name; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    if(mysql_field_type($result, 0) == "string")
                                                    {
                                                        ?>

                                                        <input type="hidden" name="<?=$column_name[0]."_"?>" value="<?php echo "\x27".$row->$column_name[0]."_\x27"?>" >
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>

                                                        <input type="hidden" name="<?=$column_name[0]."_"?>" value=<?php echo $row->$column_name[0]."_"?> >
                                                        <?php
                                                    }

                                                    for($i=0; $i < count($column_name); $i++)
                                                    {
                                                        ?>
                                                        <div class="input-group">
                                                            <span class="input-group-addon col-md-3"> <?php echo $column_name[$i] ?></span>

                                                            <?php
                                                            $type = mysql_field_type($result, $i);
                                                            if($type == "string")
                                                            {
                                                                ?>
                                                                <input type="text" class="form-control" name="<?=$column_name[$i]?>" value="<?php echo "\x27".$row->$column_name[$i]."\x27" ?>" >

                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <input type="text" class="form-control" name="<?=$column_name[$i]?>" value=<?php echo $row->$column_name[$i] ?> >
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="delete<?=$count?>"tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="post" action="./delete.php">
                                                <div class="modal-header">
                                                <input type="hidden" name="<?php echo $tb_name; ?>">
                                                <h5 class="modal-title"><?php echo $tb_name;?></h5>
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
                                                            <input type="hidden" name="<?=$column_name[0]?>" value="<?php echo "\x27".$row->$column_name[0]."\x27"?>" >
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
                                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <?php $count++;
                            }
                            ?>
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
