<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

$actual_date = date("Y-m-d H:i:s");
$expect_date = date("Y-m-d H:i:s",time()+60*60*60*24);
$recevie_date = "NULL";


$sql_bask = "select * from basket where cust_num=".$_SESSION['id_num'];
$result_bask = mysql_query($sql_bask);
if(!$result_bask)
{
    echo mysql_error();
}
else
{
    $sql_purl = "select * from pur_list order by pur_num desc";
    $result_purl = mysql_query($sql_purl);
    $row_purl = mysql_fetch_row($result_purl);
    $last_pur_num = $row_purl[0];
    $pur_num = $last_pur_num + 1;

    $sql_insert_purlist="insert into pur_list(pur_num, cust_num, confirm) values(". $pur_num . ", " . $_SESSION['id_num']. ", 'X')";
    mysql_query($sql_insert_purlist);

    while($row_bask= mysql_fetch_object($result_bask))
    {
        $sql_all = "insert into purchase(pur_num, cust_f_name, cust_l_name, part_num, part_name, quantity, price, emp_f_name, emp_l_name, actual_date, expect_date, recevie_date) values(";

        $sql_cust = "select * from client where id_num=".$_SESSION['id_num'];
        $result_cust = mysql_query($sql_cust);

        $sql_all = $sql_all . $pur_num . ", ";
        $row_cust = mysql_fetch_object($result_cust);
        $cust_f_name = '\''.$row_cust->f_name.'\'';
        $cust_l_name = '\''.$row_cust->l_name.'\'';
        $sql_all = $sql_all. $cust_f_name . ", " . $cust_l_name . ", ";

        $part_num = $row_bask->part_num;
        $part_name = '\''.$row_bask->part_name.'\'';
        $quantity = $row_bask->quantity;

        $sql_parts = "update parts set quantity=" . "quantity-".$quantity . " where part_num=".$part_num;
        mysql_query($sql_parts);


        $price = $row_bask->price;
        $emp_f_name = "NULL";
        $emp_l_name = "NULL";
        $sql_all = $sql_all . $part_num . ", " . $part_name . ", " . $quantity . ", " . $price . ", " . $emp_f_name . ", " . $emp_l_name . ", ";
        $sql_all = $sql_all . '\''.$actual_date.'\'' . ", " . '\''.$expect_date.'\''. ", " .$recevie_date . ")";

        $result_all = mysql_query($sql_all);
    }
}

echo "<meta http-equiv='refresh' content='0;url=./purchase_list.php'>";

?>
