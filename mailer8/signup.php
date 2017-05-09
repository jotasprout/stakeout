<?php

// v8

session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="") {
	$reg_user->redirect('home.php');
}

if(isset($_POST['btn-signup'])) {
	$uname = trim($_POST['txtuname']);
	$forename = trim($_POST['forename']);
	$surname = trim($_POST['surname']);
	$email = trim($_POST['txtemail']);
	$code = md5(uniqid(rand()));

	$stmt = $reg_user->runQuery("SELECT * FROM user_creds4 WHERE email=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($stmt->rowCount() > 0) {
		$msg = "<div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Poop!</strong> Somebody already used that email. Try another one, slick.
			  </div>";
	}
	else {
		if($reg_user->register($uname,$forename,$surname,$email,$code)) {
			$id = $reg_user->lasdID();
			$key = base64_encode($id);
			$id = $key;

			$message = "
						Welcome to Stakeout, $forename!<br/>
						Click the link below to complete your registration.<br/>
						<br /><br />
						<a href='http://www.roxorsoxor.com/mailer8/verifyAndSetPW.php?id=$id&code=$code'>Click here to activate</a>.
						<br /><br />
						Thanks,";

			$subject = "Confirm Registration";

			$reg_user->send_mail($email,$message,$subject);
			$msg = "
					<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>You're almost there!</strong> We've sent an email to $email.
                    Click the link in the email to verify your account.</div>";
		}
		else {
			// echo "Crap. Query not executed.";
			$msg = "<div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Crap!</strong> Query not executed.
			  </div>";			
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Signup | Stakeout</title>
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
	<input type="text" class="input-block-level" placeholder="First name" name="forename" required />
	<input type="text" class="input-block-level" placeholder="Last name" name="surname" required />
	<input type="email" class="input-block-level" placeholder="email@domain.com" name="txtemail" required />
	<hr />
	<button class="btn btn-large btn-primary" type="submit" name="btn-signup">Sign Up</button>
	<a href="index.php" style="float:right;" class="btn btn-large">Sign In</a>
  </form>
</div>
<!-- /container -->
<script src="bootstrap/js/jquery-1.9.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
