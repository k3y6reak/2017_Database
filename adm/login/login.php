<?php

if(!isset($_POST['man_id']) || !isset($_POST['man_pw'])) exit;

$man_id = $_POST['man_id'];
$man_pw = $_POST['man_pw'];

include_once "../includes/dbconn.php";
$sql = "select * from manager where id='$man_id'";
$result = mysql_query($sql, $connect);
$num_match = mysql_num_rows($result);

if(!$num_match)
{
    echo "
        <script>
            window.alert('Unregistered ID');
            history.go(-1);
        </script>
        ";
        exit;
}
else
{
    $row = mysql_fetch_array($result);
    $db_passwd = $row['passwd'];
    if($man_pw != $db_passwd)
    {
        echo $passwd;
        echo "
            <script>
                window.alert('Incorrect Password');
                history.go(-1);
            </script>
             ";
            exit;
    }
    else
    {
        session_start();
        $_SESSION['man_id'] = $man_id;
    }

}
?>

<meta http-equiv='refresh' content='0;url=../main/main.php'>
