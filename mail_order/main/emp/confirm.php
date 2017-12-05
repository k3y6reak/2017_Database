<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";


$sql = "select * from employee where id_num=".$_SESSION['id_num'];
$result = mysql_query($sql);
$row = mysql_fetch_object($result);

$emp_f_name = $row->f_name;
$emp_l_name = $row->l_name;

$sql = "update  pur_list set ";
$sql2 = "update  purchase set ";

foreach($_POST as $key=>$value)
{
    $sql = $sql . "confirm='O' where " . $key . "=" . $value;
    $sql2 = $sql2 . "emp_f_name='".$emp_f_name . "', emp_l_name='".$emp_l_name."' where ". $key . "=" . $value;
}


mysql_query($sql);
mysql_query($sql2);

echo "<meta http-equiv='refresh' content='0;url=./purchase_list.php'>";

?>
