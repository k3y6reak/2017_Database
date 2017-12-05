<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

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

$sql = $sql . " where " . "part_num" . "=" . $condition_value;


echo $sql;

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
