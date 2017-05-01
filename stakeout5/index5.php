<?php	
require_once 'areTheyLoggedIn5.php';		
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />	
<meta charset="UTF-8">    
<title>Stakeout | You</title>    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>    
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">  
<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">    
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
<link rel="apple-touch-icon-precomposed" href = "stakeoutIcon.png" />    
<LINK href="favicon.ico" rel="icon" type="image/x-icon">    
<LINK href="favicon.ico" rel="shortcut icon" type="image/x-icon">    
<LINK href="favicon.ico" rel="icon" type="image/ico">
</head>
<body>
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
<ul class="nav navbar-nav navbar-right">                            
<li><a href="logout_stakeout4.php">Logout</a></li>                        
</ul>                    
</div> <!-- /collapse -->                
</div> <!-- /container-fluid -->            
</nav> <!-- /navbar -->      
<div class="jumbotron">        
<h1>Welcome <?php echo $row['forename']; ?></h1>        
<p class="lead">Your email is <?php echo $row['email']; ?></P>        
<p class="lead">Your username is <?php echo $row['username'];?></P>      
</div>    
<footer class="footer">        <p>&copy; RoxorSoxor 2017</p>    
</footer>
</div> <!-- /container -->
</body>
</html>