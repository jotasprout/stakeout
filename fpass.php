<?php
session_start();
require_once 'class.gatorGoogle.php';
require_once 'stylesAndSuch.php';

$user = new USER();

if($user->areTheyLoggedIn()!="") {
	$user->redirect('index.php');
}
else {
	echo "<script>console.log('Nobody is logged in.')</script>";
}

if(isset($_POST['btn-submit']))
{
	$email = $_POST['txtemail'];
	$stmt = $user->runQuery("SELECT id FROM user_creds WHERE email=:email LIMIT 1");
	$stmt->execute(array(":email"=>$email));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($stmt->rowCount() == 1)
	{
		$id = base64_encode($row['id']);
		$code = md5(uniqid(rand()));
		$stmt = $user->runQuery("UPDATE user_creds SET tokenCode=:token WHERE email=:email");
		$stmt->execute(array(":token"=>$code,"email"=>$email));
		$message= "Hello $email,
				   <br /><br />
				   Someone requested this email to reset your password.<br/>
				   If it was you, click the link and reset your password.<br/>
				   If it wasn't you, someone is up to no good.<br/>
				   <br /><br />
				   <a href='http://www.roxorsoxor.com/stakeout/resetpass.php?id=$id&code=$code'>Click here to reset your password</a>.
				   <br /><br />
				   Be safe.
				   ";
		$subject = "Password Reset";
		$user->send_mail($email,$message,$subject);
		$msg = "<div class='alert alert-success'>
					We've sent an email to $email.
                    Click the link in the email to reset your password.
			  	</div>";
	}
	else
	{
		$msg = "<div class='alert alert-danger'>
					<button class='close' data-dismiss='alert'>&times;</button>
					<strong>Dude!</strong> This totally sucks but your email can not be found.
			    </div>";
	}
}
?>
<!DOCTYPE html>
<html>

  <head>
    <title>Land of Forgotten Passwords</title>
	<?php echo $stylesAndSuch; ?>
  </head>
  
  <body>
    <div class="container">
	<div id='header'>		
		<h1 class="hide"><a href="index.php">Stakeout</a></h1>
	</div> <!-- /container -->
	
   
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Land of Forgotten Passwords</h3>
		</div>
		<div class="panel-body"> 
		
      <form class="form-horizontal" method="post">
	  <fieldset>
        	<?php
			if(isset($msg)) {
				echo $msg;
			}
			else {
              	echo "<div>Enter the email address for your account. You'll receive a link to reset your password.</div>";
			}
			?>
			
			<div class="form-group"><!-- Row 1 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="email">Email</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="email" name="txtemail" placeholder="email@domain.com" required />
				</div>
			</div>
			<!-- /Row 1 -->			
			
			<div class="form-group"><!-- Last Row -->
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-danger btn-primary" type="submit" name="btn-submit">Send Reset Email</button>
				</div>  
			</div> <!-- /Last Row -->

		</fieldset>
      </form>
		</div> <!-- /panel-body -->
	</div> <!-- /panel-primary -->
</div> <!-- /container -->
  <script src='//roxorsoxor.com/stakeout/js/mobrulesLogin.js'></script></body>
</html>