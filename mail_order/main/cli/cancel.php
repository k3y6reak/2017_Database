<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

$pattern = "([0-9]*$)";
$sql_purlist = "delete from pur_list where pur_num=".$_POST['pur_num'];
$sql_purchase = "delete from purchase where pur_num=".$_POST['pur_num'];



for($i=1; $i < count($_POST)-2; $i++)
{
    $sql_part1 = "select * from parts where part_name='".$_POST['part_name'.$i]."'";
    $result = mysql_query($sql_part1);
    $row = mysql_fetch_object($result);
    $db_quan = $row->quantity;
    $sql_parts = "update parts set quantity=".($_POST['quantity'.$i]+$db_quan) ." where part_name='".$_POST['part_name'.$i]."'";
    mysql_query($sql_parts);

}

mysql_query($sql_purlist);
mysql_query($sql_purchase);

echo "<meta http-equiv='refresh' content='0;url=./purchase_list.php'>";

?>
