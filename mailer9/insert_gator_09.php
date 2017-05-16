<?php
session_start();

require_once 'class.gator.php';

require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!isset($_SESSION['username'])) {
	echo "<script>console.log('Nobody is logged in.')</script>";
	header("Location:login_form_09.php");
}
else {
	// $_SESSION['username'] = $userRow['username'];
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

if(isset($_POST['submit'])) {
	$uname = trim($_POST['username']);
	$forename = trim($_POST['forename']);
	$surname = trim($_POST['surname']);
	$email = trim($_POST['email']);
	$code = md5(uniqid(rand()));
	$stmt = $user->runQuery("SELECT * FROM user_creds4 WHERE email=:email_id");
	$stmt->execute(array(":email_id"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() > 0) {
		$msg = "<div class='alert alert-error'>
				<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Poop!</strong> Somebody already used that email. Try another one, slick.
			  </div>";
	}
	else {
		if($user->register($uname,$forename,$surname,$email,$code)) {
			$id = $user->lasdID();
			$key = base64_encode($id);
			$id = $key;
			$message = "Welcome to Stakeout, $forename!<br/>
						Click the link below to complete your registration.<br/>
						<a href='https://www.roxorsoxor.com/mailer9/verifyAndSetPW.php?id=$id&code=$code'>Click here to activate</a>.<br />
						Thanks,";
			$subject = "Confirm Registration";
			$user->send_mail($email,$message,$subject);
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
<?php echo $stylesAndSuch; ?>
</head>
<body>
	<div class="container">
		<?php if(isset($msg)) echo $msg;  ?>
		
<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>

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