<?php

    session_start();
    if(!isset($_SESSION['man_id']))
    {
        echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
        exit;
    }

?>
