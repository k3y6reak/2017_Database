<?php

session_start();
if(!isset($_SESSION['man_id']))
{
    echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
    exit;
}

include_once "../dbconn/dbconn.php";

$count = 0;
$sql = "UPDATE";

foreach($_POST as $key=>$value)
{
    if($count == 0)
    {
        $tb_name = $key;
        $sql = $sql . " " . $key . " SET ";
    }
    elseif($count == 1)
    {
        $condition_column = str_replace("_", "", $key);
        $condition_value = str_replace("_", "", $value);
        #$sql = $sql . " " . $key . "=" . $value . ", ";
    }
    else
    {
        if($count == (count($_POST)-1))
        {
            $sql = $sql . " " . $key . "=" . $value;
        }
        else
        {
            $sql = $sql . " " . $key . "=" . $value . ", ";
        }
    }

    $count++;
}

$sql = $sql . " where " . $condition_column . "=" . $condition_value;

$result = mysql_query($sql);


if(!$result)
{
    echo mysql_error();
}
else
{
    echo "<meta http-equiv='refresh' content='0;url=./show_data.php?tb_name=$tb_name'>";
}


?>
