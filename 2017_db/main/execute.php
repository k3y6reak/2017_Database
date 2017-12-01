<?php

session_start();
if(!isset($_SESSION['man_id']))
{
    echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
    exit;
}

include_once "../dbconn/dbconn.php";

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
