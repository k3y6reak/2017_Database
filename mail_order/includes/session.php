<?php

    session_start();
    if(!isset($_SESSION['id_num']))
    {
        echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
        exit;
    }

?>
