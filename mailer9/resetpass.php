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
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}

if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$stmt = $user->runQuery("SELECT * FROM user_creds4 WHERE id=:uid AND tokenCode=:token");
	$stmt->execute(array(":uid"=>$id,":token"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if($stmt->rowCount() == 1)
	{
		if(isset($_POST['btn-reset-pass']))
		{
			$pass = $_POST['pass'];
			$cpass = $_POST['confirm-pass'];
			
			if($cpass!==$pass)
			{
				$msg = "<div class='alert alert-block'>
						<button class='close' data-dismiss='alert'>&times;</button>
						<strong>Try again.</strong> Passwords don't match. 
						</div>";
			}
			else
			{
				$password = md5($cpass);
				$stmt = $user->runQuery("UPDATE user_creds4 SET password=:upass WHERE id=:uid");
				$stmt->execute(array(":upass"=>$password,":uid"=>$rows['id']));
				
				$msg = "<div class='alert alert-success'>
						<button class='close' data-dismiss='alert'>&times;</button>
						Password changed. Good job. You'll be redirected home in 5 seconds.
						</div>";
				header("refresh:5;index_09.php");
			}
		}	
	}
	else
	{
		$msg = "<div class='alert alert-success'>
				<button class='close' data-dismiss='alert'>&times;</button>
				No such account found. Try again.
				</div>";		
	}	
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Password Reset</title>
<?php echo $stylesAndSuch; ?>   
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="login">
    <div class="container">
<?php echo $navbar; ?>   
    	<div class='alert alert-success'>
			<strong>Hello there,</strong> <?php echo $rows['username'] ?>! So far, so good. Enter your new password.
		</div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Password Reset</h3><hr />
        <?php
        if(isset($msg))
		{
			echo $msg;
		}
		?>
        <input type="password" class="input-block-level" placeholder="Type your new password" name="pass" required />
        <input type="password" class="input-block-level" placeholder="Type it again" name="confirm-pass" required />
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-reset-pass">Make it so</button>
        
      </form>
    </div> <!-- /container -->
  </body>
</html>