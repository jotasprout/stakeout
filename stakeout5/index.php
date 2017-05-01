<?php
session_start();
require_once 'class.gator5.php';
$user_login = new USER();
if($user_login->is_logged_in()!="") {	
    $user_login->redirect('index5.php');
}

if(isset($_POST['submit'])) {	
    $username = trim($_POST['username']);	
    $password = trim($_POST['password']);		
if($user_login->login($username,$password) {		
    $user_login->redirect('index5.php');	
}
}
?>

<!DOCTYPE html>
<html>  
<head>    
<title>Login</title>    
<!-- Bootstrap -->    
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">    
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">    
<link href="assets/styles.css" rel="stylesheet" media="screen">     

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->    

<!--[if lt IE 9]>      
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>    
<![endif]-->    

<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>  
</head>  

<body id="login">    

<div class="container">		

<?php 		
if(isset($_GET['inactive'])) {			
    ?>            

<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button>				<strong>Sorry!</strong> This Account is not Activated Go to your Inbox and Activate it.</div>            

<?php		
}		
?>        

<form class="form-signin" method="post">        

<?php        
if(isset($_GET['error'])) {			
?>            

<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Wrong Details!</strong></div>            

<?php		
}		
?>        
<h2 class="form-signin-heading">Sign In.</h2>
<hr />        
<input type="text" class="input-block-level" placeholder="username" name="username" required />        
<input type="password" class="input-block-level" placeholder="password" name="password" required />     	
<hr />        
<button class="btn btn-large btn-primary" type="submit" name="submit">Sign in</button>        
<a href="insert_gator5.php" style="float:right;" class="btn btn-large">Sign Up</a>
<hr />        
<a href="fpass.php">Lost your Password ? </a>      
</form>    
</div> <!-- /container -->    
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>    
<script src="bootstrap/js/bootstrap.min.js"></script>  
</body>
</html>