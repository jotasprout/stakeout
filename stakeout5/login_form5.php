<?php	
session_start();	
if (isset($_SESSION['username'])) {		
    header("location:index5.php");	
}	
require_once 'handle_login5.php';
?>

<!doctype html>
<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />	
<meta charset="UTF-8">	
<title>Stakeout | Login</title>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>    
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css"> 
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">    
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
<link rel="apple-touch-icon-precomposed" href = "stakeoutIcon.png" />    
<LINK href="favicon.ico" rel="icon" type="image/x-icon">    
<LINK href="favicon.ico" rel="shortcut icon" type="image/x-icon">    
<LINK href="favicon.ico" rel="icon" type="image/ico">
</head>

<body id="login">	
<div class="container">	 		
<nav class="navbar navbar-default">			
<div class="container-fluid">				
<div class="navbar-header">					
<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout5/index5.php">You</a>				
</div>				
<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">					
<ul class="nav navbar-nav">						
<li><a href="http://www.roxorsoxor.com/stakeout5/cases5.php">Cases</a></li>						
<li><a href="http://www.roxorsoxor.com/stakeout5/observations5.php">Observations</a></li>		
<li><a href="http://www.roxorsoxor.com/stakeout5/gators5.php">Investigators</a></li>
<li><a href="http://www.roxorsoxor.com/stakeout5/assignments5.php">Assignments</a></li>					
</ul>
</div> <!-- /collapse -->			
</div> <!-- /container-fluid -->		
</nav> <!-- /navbar -->		

<form class="form-horizontal" action="handle_login5.php" method="post">			

<fieldset>				
<div class="form-group">

<!-- Row 1 -->					
<!-- Column 1 -->					
<label class="col-lg-2 control-label" for="username">username</label>					
<!-- Column 2 -->					
<div class="col-lg-4">						
<input class="form-control" type="text" name="username" placeholder="username"/>					
</div>				
</div><!-- /Row 1 -->	

<div class="form-group"><!-- Row 3 -->					
<label class="col-lg-2 control-label" for="password">password</label>					
<div class="col-lg-4">						
<input class="form-control" type="password" name="password" placeholder="password"/>					
</div>				
</div><!-- /Row 3 -->				
<div class="form-group"><!-- Last Row -->					
<div class="col-lg-4 col-lg-offset-2">						
<button class="btn btn-primary" type="submit" name="submit">Log In</button>					
</div>				
</div><!-- /Last Row -->			
</fieldset>		
</form>		
<footer class="footer">			
<p>&copy; RoxorSoxor 2017</p>		
</footer>	
</div><!-- /container -->
</body>
</html>