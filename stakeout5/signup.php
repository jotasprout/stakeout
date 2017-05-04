<?php

session_start();

require_once 'class.gator5.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!=""){	
	$reg_user->redirect('index5.php');
}

if(isset($_POST['submit'])){	
	$uname = trim($_POST['txtuname']);	
	echo "<script>console.log('username submitted is " . $uname . "');</script>";
	$email = trim($_POST['txtemail']);	
	$upass = trim($_POST['txtpass']);	
	$code = md5(uniqid(rand()));		
	$stmt = $reg_user->runQuery("SELECT * FROM user_creds4 WHERE email=:email_id");	
	$stmt->execute(array(":email_id"=>$email));	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);		
	if($stmt->rowCount() > 0) {		
		$msg = "<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry, dude!</strong> Somebody already used that email. Try another one.</div>";	
	}	
	else {		
		if($reg_user->register($uname,$email,$upass,$code)) {						
			$id = $reg_user->lasdID();					
			$key = base64_encode($id);			
			$id = $key;						
			$message = "Hello $uname, <br /><br />Welcome to Stakeout.<br/>Click the following link to complete your registration.<br/><br /><br /><a href='http://www.roxorsoxor.com/stakeout5/verify.php?id=$id&code=$code'>Click HERE to activate</a><br /><br />Thanks,";									
			$subject = "Confirm Registration";									
			$reg_user->send_mail($email,$message,$subject);				
			$msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Success!</strong> Hal 9000 sent an email to $email. Please click the confirmation link in the email to create your account.</div>";		
		}		
		else {			
			echo "Sorry, query could not execute...";	
			echo "<script>console.log('query could not execute');</script>";	
		}			
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Adding An Investigator</title>
<!-- Bootstrap -->
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="assets/styles.css" rel="stylesheet" media="screen">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>      
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>    
<![endif]-->

</head>
<body id="login">
<div class="container">
  <?php if(isset($msg)) echo $msg;  ?>
  <form class="form-signin" method="post">
    <h2 class="form-signin-heading">Sign Up</h2>
    <hr />
    <input type="text" class="input-block-level" placeholder="Username" name="txtuname" required />
    <input type="email" class="input-block-level" placeholder="Email address" name="txtemail" required />
    <input type="password" class="input-block-level" placeholder="Password" name="txtpass" required />
    <hr />
    <button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
    <a href="login_form5.php" style="float:right;" class="btn btn-large">Sign In</a>
  </form>
</div>
<!-- /container --> 
<script src="bootstrap/js/jquery-1.9.1.min.js"></script> 
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>