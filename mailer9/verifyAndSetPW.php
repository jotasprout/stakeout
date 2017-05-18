<?php
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();
if(empty($_GET['id']) && empty($_GET['code'])) {
	$user->redirect('login_form_09.php');
}
if(isset($_GET['id']) && isset($_GET['code'])) {
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$statusY = "Y";
	$statusN = "N";	
	
	$stmt = $user->runQuery("SELECT * FROM user_creds4 WHERE id=:uID AND tokenCode=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	// if user is registered (there's a row for them)
	if($stmt->rowCount() > 0) {
		// VERIFICATION stuff
		// if user is already active
		if($row['userStatus']==$statusY) {
			$msg = "<div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>What are you doing here?</strong> Your account is already activated: <a href='login_form_09.php'>Login here</a>.</div>";			
		}
		// if user is NOT already active
		else {
			$stmt = $user->runQuery("UPDATE user_creds4 SET userStatus=:status WHERE id=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			
			$msg = "<div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					<strong>Voila!</strong> Your account is now activated. So far, so good. Create a secure password.</div>";	
					  
			// PASSWORD STUFF	
			if(isset($_POST['btn-make-pass'])) {
				$pass = $_POST['pass'];
				$cpass = $_POST['confirm-pass'];
				
				if($cpass!==$pass) {
					$msg = "<div class='alert alert-block'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<strong>Passwords don't match.</strong> Try again, fumble-fingers.</div>";
				}
				else {
					$password = md5($cpass);
					$stmt = $user->runQuery("UPDATE user_creds4 SET password=:upass WHERE id=:uid");
					$stmt->execute(array(":upass"=>$password,":uid"=>$rows['id']));
					
					$msg = "<div class='alert alert-success'>
							<button class='close' data-dismiss='alert'>&times;</button>
							Password set. Good job.<br>You'll be automatically redirected to your home page.</div>";
					header("refresh:5;index_09.php");
				}
			}				
		}		
	}
	// if not registered (no row)
	else {
		$msg = "<div class='alert alert-error'>
			   <button class='close' data-dismiss='alert'>&times;</button>
			   <strong>I am so very, truly sorry!</strong> No such account found. Contact your administrator.</div>";	
	}	
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Create a Password</title>
	<?php echo $stylesAndSuch; ?>   
  </head>
  <body>
    <div class="container">
<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>    
    	<div class='alert alert-success'>
			<strong>Hello there,</strong> <?php echo $rows['username'] ?>! 
		</div>
        <form class="form-signin" method="post">
        <h3 class="form-signin-heading">Create Your Password</h3><hr />
        <?php
        if(isset($msg))
		{
			echo $msg;
		}
		?>
        <div><input type="password" class="input-block-level" placeholder="Type your new password" name="pass" required /></div>
        <div><input type="password" class="input-block-level" placeholder="Type it again" name="confirm-pass" required /></div>
     	<hr />
        <button class="btn btn-large btn-primary" type="submit" name="btn-make-pass">Submit</button>
        
      </form>
    </div> <!-- /container -->
  </body>
</html>