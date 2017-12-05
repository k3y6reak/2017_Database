<?php

if(!isset($_POST['classify']) || !isset($_POST['f_name']) || !isset($_POST['l_name']) || !isset($_POST['id_num'])) exit;

$classify = $_POST['classify'];
$f_name = $_POST['f_name'];
$l_name = $_POST['l_name'];
$id_num = $_POST['id_num'];

include_once "../includes/dbconn.php";
$sql = "select * from $classify where id_num='$id_num'";
$result = mysql_query($sql, $connect);
$num_match = mysql_num_rows($result);


if(!$num_match)
{
    echo "
        <script>
            window.alert('Unregistered ID num');
            history.go(-1);
        </script>
        ";
        exit;
}
else
{
    $row = mysql_fetch_array($result);
    $db_fname = $row['f_name'];
    if($f_name != $db_fname)
    {
        echo "
            <script>
                window.alert('Unregistered first name');
                history.go(-1);
            </script>
             ";
            exit;
    }
    else
    {
        $result = mysql_query($sql, $connect);
        $row = mysql_fetch_array($result);
        $db_lname = $row['l_name'];
        if($l_name != $db_lname)
        {
            echo "<script>window.alert('Unregistered last name'); history.go(-1);</script>";
        }
        else
        {
            session_start();
            $_SESSION['id_num'] = $id_num;

            if($classify == "employee")
            {
?>
                <meta http-equiv='refresh' content='0;url=../main/emp/main.php'>
<?php
            }
            else
            {
?>
                <meta http-equiv='refresh' content='0;url=../main/cli/main.php'>
<?php
            }


        }
    }

}
?>
