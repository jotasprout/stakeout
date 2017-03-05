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
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout/index.php">Home</a>
                    </div>
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->

        <!-- This form uses code in handle_prez to insert input into the database -->
        <form class="form-horizontal" action="index.php" method="post">
            <fieldset>
            	<legend>Log In</legend>
                
                <div class="form-group"> <!-- Row 1 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="username">username</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="username" placeholder="username" />
                    </div>
                </div><!-- /Row 1 -->            		

                <div class="form-group"> <!-- Row 3 -->
                    <label class="col-lg-2 control-label" for="password">password</label>
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="password" placeholder="password" />                           
                    </div>
                </div><!-- /Row 3 --> 
 
                <div class="form-group"> <!-- Last Row -->           
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Log In</button>
                    </div>
                </div><!-- /Last Row -->            
            
            </fieldset>
        </form>
	

    <footer class="footer">

        <p>&copy; RoxorSoxor 2017</p>

    </footer>

</div> <!-- /container -->

</body>
</html>