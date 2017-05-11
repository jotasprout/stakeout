<?php

session_start();
require_once 'class.user.php';

$reg_user = new USER();

if($reg_user->is_logged_in()!="") {
	$reg_user->redirect('home.php');
}

if(isset($_POST['submit'])) {
	$uname = trim($_POST['username']);
	$forename = trim($_POST['forename']);
	$surname = trim($_POST['surname']);
	$email = trim($_POST['email']);
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

			$message = "Welcome to Stakeout, $forename!<br/>
						Click the link below to complete your registration.<br/>
						<br /><br />
						<a href='http://www.roxorsoxor.com/mailer8/verifyAndSetPW.php?id=$id&code=$code'>Click here to activate</a>.
						<br /><br />
						Thanks,";

			$subject = "Confirm Registration";

			$reg_user->send_mail($email,$message,$subject);
			$msg = "<div class='alert alert-success'>
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
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
	<meta charset="UTF-8">
	<title>Add Investigator</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<?php if(isset($msg)) echo $msg;  ?>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="http://www.roxorsoxor.com/mailer9/index_09.php">You</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li><a href="http://www.roxorsoxor.com/mailer9/cases5.php">Cases</a></li>
						<li><a href="http://www.roxorsoxor.com/mailer9/observations_09.php">Observations</a></li>
						<li><a href="http://www.roxorsoxor.com/mailer9/gators5.php">Investigators</a></li>
						<li><a href="http://www.roxorsoxor.com/mailer9/assignments5.php">Assignments</a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="logout_stakeout5.php">Logout</a></li>
					</ul>
				</div>
				<!-- /collapse -->
			</div>
			<!-- /container-fluid -->
		</nav>
		<!-- /navbar -->
		<!-- This form uses code in handle_gator to insert input into the database -->
		<form class="form-horizontal" method="post">
			<fieldset>
				<legend>Add Investigator</legend>
				<div class="form-group"><!-- Row 1 -->
					<!-- Column 1 -->
					<label class="col-lg-2 control-label" for="forename">First Name</label>
					<!-- Column 2 -->
					<div class="col-lg-4">
						<input class="form-control" type="text" name="forename" placeholder="First Name"/>
					</div>
				</div><!-- /Row 1 -->
				<div class="form-group"><!-- Row 2 -->
					<!-- Column 1 -->
					<label class="col-lg-2 control-label" for="surname">Last Name</label>
					<!-- Column 2 -->
					<div class="col-lg-4">
						<input class="form-control" type="text" name="surname" placeholder="Last Name"/>
					</div>
				</div><!-- /Row 2 -->
				<div class="form-group"><!-- Row 3 -->
					<!-- Column 1 -->
					<label class="col-lg-2 control-label" for="username">username</label>
					<!-- Column 2 -->
					<div class="col-lg-4">
						<input class="form-control" type="text" name="username" placeholder="username"/>
					</div>
				</div><!-- /Row 3 -->
				
				<div class="form-group"><!-- Row 5 -->
					<!-- Column 1 -->
					<label class="col-lg-2 control-label" for="email">email</label>
					<!-- Column 2 -->
					<div class="col-lg-4">
						<input class="form-control" type="text" name="email" placeholder="you@domain.com"/>
					</div>
				</div><!-- /Row 5 -->
				<div class="form-group"><!-- Last Row -->
					<div class="col-lg-4 col-lg-offset-2">
						<button class="btn btn-primary" type="submit" name="submit">Add Investigator</button>
					</div>
				</div>
				<!-- /Last Row -->
			</fieldset>
		</form>
		<footer class="footer">
			<p>&copy; RoxorSoxor 2017</p>
		</footer>
	</div>
	<!-- /container -->
</body>
</html>
