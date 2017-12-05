<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

$count = 0;
$sql = "DELETE FROM";

foreach($_POST as $key=>$value)
{
    if($count == 0)
    {
        $tb_name = $key;
        $sql = $sql . " " . $key . " " . "where ";
    }
    else
    {
        $sql = $sql . $key . "=" . $value;
    }
    $count++;
}


$result = mysql_query($sql);

if(!$result)
{
    echo mysql_error();
}
else
{
    echo "<meta http-equiv='refresh' content='0;url=./basket_list.php'>";
}


?>
