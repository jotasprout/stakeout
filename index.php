<?php

	session_start();

	$username = "jotaNaked";
	$password = "We2CanFly!";

	# Does this automatically redirect logged in users to success? I don't think I like that.
	if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
		header("Location: insertObserveBS.htm");
	}

	if (isset($_POST['username']) && isset($_POST['password'])) {
		if ($_POST['username'] == $username && $_POST['password'] == $password) {
			$_SESSION['logged_in'] = true;
			header("Location: insertObserveBS.htm");
		}
		else {
			header("Location: failedstakeout.htm");
		}		
	}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Stakeout</title>
    <script src="http://www.jotascript.com/js/jquery-214.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="http://www.jotascript.com/js/bootstrap/js/bootstrap.js"></script>
</head>
<body>
	<div class="container">
            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout/index.php"><img src="stakeoutLogo.png" width="680" height="198"/></a>      
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