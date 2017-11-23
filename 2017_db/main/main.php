<!DOCTYPE html>
<meta charset="utf-8"/>

<?php

    session_start();
    if(!isset($_SESSION['man_id']))
    {
        echo "<meta http-equiv='refresh' content='0;url=../login/login.html'>";
        exit;
    }

?>




<html lang="ko">
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style_main.css">
    </head>

    <body>
        <div class="nav-side-menu">
    		<div class="brand">Brand Logo</div>
    		<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    		<div class="menu-list">
        		<ul id="menu-content" class="menu-content collapse out">
            			<li>
                			<a href="#">
                    			<i class="fa fa-dashboard fa-lg"></i> Databases
                			</a>
            			</li>
            			<li>
                			<a href="#">
                    			<i class="fa fa-dashboard fa-lg"></i> Databases2
                			</a>
            			</li>
            			<li>
                			<a href="#">
                    			<i class="fa fa-dashboard fa-lg"></i> Databases3
                			</a>
            			</li>
            			<li>
                			<a href="../login/logout.php">
                    			<i class="fa fa-dashboard fa-lg"></i> Logout
               			 	</a>
            			</li>
        		</ul>
    		</div>
	</div>

	<div class="container" id="main">
    		<div class="row">
        		<div class="col-md-12">
            			<h4>This is suppose to be in the main content</h4>
        		</div>
    		</div>
	</div>
    </body>

</html>
