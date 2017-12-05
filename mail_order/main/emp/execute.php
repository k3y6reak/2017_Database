<?php

include_once "../../includes/session.php";
include_once "../../includes/dbconn.php";

$sql = "";

foreach($_POST as $key=>$value)
{
    $sql = $value;
}


$result = mysql_query($sql);

if(!$result)
{
    $_SESSION['msg'] = mysql_error();
?>
    <script>window.history.go(-1)</script>
<?php 
}
else
{
?>

    <script>window.history.go(-1)</script>
<?php
}


?>
