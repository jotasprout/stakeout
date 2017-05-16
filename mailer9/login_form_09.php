<?php

session_start();

require_once 'class.gator.php';
require_once 'stylesAndSuch.php';

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
	header("Location:index_09.php");
}

else {
	echo "<script>console.log('Nobody is logged in.')</script>";
}

$user = new USER();

if(isset($_POST['submit'])) {
	$email = trim($_POST['email']);
	$upass = trim($_POST['password']);
	if($user->login($email,$upass)) {
		$user->redirect('index_09.php');
	}
}

?>

<!doctype html>

<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<meta charset="utf-8">
<title>Stakeout | Login</title>
<?php echo $stylesAndSuch; ?>
</head>

<body>
<div class="container">
<nav class='navbar navbar-default'>
	<div id='header' class='container-fluid'>
		<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
			<ul class='nav navbar-nav'>
				<li><a class='navbar-brand' href='//www.roxorsoxor.com/mailer9/index_09.php'>Home</a></li>
				<li><a href='//www.roxorsoxor.com/mailer9/cases_09.php'>Cases</a></li>
				<li><a href='//www.roxorsoxor.com/mailer9/observations_09.php'>Observations</a></li>
			</ul>
		</div> <!-- /collapse -->                    
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->
	
	<?php 

		if(isset($_GET['inactive'])) {

		?>
	<div class='alert alert-error'>
		<button class='close' data-dismiss='alert'>&times;</button>
		This account is not activated. Go to your inbox and activate it.</div>
	<?php

		}

		?>
	<form class="form-horizontal" method="post">
		<?php

        if(isset($_GET['error'])) {

		?>
		<div class='alert alert-success'>
			<button class='close' data-dismiss='alert'>&times;</button>
			<strong>Wrong Details!</strong> </div>
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
				</div>
			</div>
			<!-- /Row 3 -->
			
			<div class="form-group"><!-- Last Row -->
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Log In</button>
				</div>
                <div><a href="fpass.php">Lost your password?</a></div>
			</div>
			<!-- /Last Row -->
			
		</fieldset>
	</form>
	<footer class="footer">
		<p>&copy; RoxorSoxor 2017</p>
	</footer>
</div> <!-- /container -->

</body>
</html>
