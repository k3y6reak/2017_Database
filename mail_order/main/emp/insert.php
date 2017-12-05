<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

$count = 0;
$sql = "insert into ";


foreach($_POST as $key=>$value)
{

    if($count == 0)
    {
        $tb_name = $key;
        $sql = $sql . $tb_name . " (";
    }
    else
    {
        if($count == (count($_POST)-1))
        {
            $sql = $sql . " " . $key;
        }
        else
        {
            $sql = $sql . " " . $key . ", ";
        }
    }

    $count++;
}

$sql = $sql. ") values(";
$count = 0;

foreach($_POST as $key=>$value)
{
    if($count)
    {
        if($count == (count($_POST)-1))
        {
            $sql = $sql . " " . $value;
        }
        else
        {
            $sql = $sql . " " . $value . ", ";
        }
    }

    $count++;
}

$sql = $sql . ")";


$result = mysql_query($sql);

if(!$result)
{
    echo mysql_error();
}
else
{
    echo "<meta http-equiv='refresh' content='0;url=./parts_list.php'>";
}

?>
