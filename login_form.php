<?php

session_start();

require_once 'class.gator.php';
require_once 'stylesAndSuch.php';

$user = new USER();

if($user->areTheyLoggedIn()!="") {
	$user->redirect('index.php');
}
else {
	echo "<script>console.log('Nobody is logged in.')</script>";
}

if(isset($_POST['submit'])) {
	$email = trim($_POST['email']);
	$upass = trim($_POST['password']);
	if($user->login($email,$upass)) {
		$user->redirect('index.php');
	}
}

?>

<!doctype html>
<html>

<head>
	<title>Stakeout | Login</title>
	<?php echo $stylesAndSuch; ?>
</head>

<body>
<div class="container">
	<div id='header'>
		<h1 class="hide"><a href="index.php">Stakeout</a></h1>
    </div>
	
	<?php 
		if(isset($_GET['inactive'])) {
	?>
    
	<div class='alert alert-error'>This account is not activated. Go to your inbox and activate it.</div>
    
	<?php
	}
	?>
    
	<form class="form-horizontal" method="post">
    
		<?php
        if(isset($_GET['error'])) {
		?>
        
		<div class='alert alert-success'><strong>Wrong Details!</strong> </div>
		
		<?php
		}
		?>
        
		<fieldset>
			<div class="form-group"><!-- Row 1 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="email">Email</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="email" name="email" placeholder="email@domain.com"/>
				</div>
			</div>
			<!-- /Row 1 -->
			
			<div class="form-group"><!-- Row 3 -->
				<label class="col-lg-2 control-label" for="password">Password</label>
				<div class="col-lg-4">
					<input class="form-control" type="password" name="password" placeholder="password"/>
                    <div id="lost"><a href="fpass.php">Reset/Change Password</a></div>
				</div>
			</div> <!-- /Row 3 -->
			
			<div class="form-group"><!-- Last Row -->
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Log In</button>
				</div>  
			</div> <!-- /Last Row -->
			
		</fieldset>
	</form>
	
</div> <!-- /container -->

<script src='//roxorsoxor.com/stakeout/mobrulesLogin.js'></script></body>
</html>