<?php

	session_start();
    include 'areTheyLoggedIn.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Stakeout</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout2/index.php"><img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/></a>      
            </div> <!-- /masthead -->
            
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout/index.php">Stakeout Home</a>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout/cases.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout/observations.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout/gators.php">Investigators</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    
                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->

      <div class="jumbotron">

        <h1>Welcome</h1>

        <p class="lead">This is the homepage.</P>

        <p class="lead">Go somewhere else.</P>

      </div>
	

    <footer class="footer">

        <p>&copy; RoxorSoxor 2017</p>

    </footer>

</div> <!-- /container -->

</body>
</html>