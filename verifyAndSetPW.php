<?php
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();
if(empty($_GET['id']) && empty($_GET['code'])) {
	$user->redirect('http://www.roxorsoxor.com/stakeout/login_form.php');
}
if(isset($_GET['id']) && isset($_GET['code'])) {
	$id = base64_decode($_GET['id']);
	$code = $_GET['code'];
	
	$statusY = "Y";
	$statusN = "N";	
	
	$stmt = $user->runQuery("SELECT * FROM user_creds WHERE id=:uID AND tokenCode=:code LIMIT 1");
	$stmt->execute(array(":uID"=>$id,":code"=>$code));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	
	// if user is registered (there's a row for them)
	if($stmt->rowCount() > 0) {
		// VERIFICATION stuff
		// if user is already active
		if($row['userStatus']==$statusY) {
			$msg = "<div class='alert alert-error'>
				   <button class='close' data-dismiss='alert'>&times;</button>
					  <strong>What are you doing here?</strong> Your account is already activated: <a href='login_form.php'>Login here</a>.</div>";			
		}
		// if user is NOT already active
		else {
			$stmt = $user->runQuery("UPDATE user_creds SET userStatus=:status WHERE id=:uID");
			$stmt->bindparam(":status",$statusY);
			$stmt->bindparam(":uID",$id);
			$stmt->execute();	
			
			$msg = "<div class='alert alert-success'>
				   <button class='close' data-dismiss='alert'>&times;</button>
				<strong>Viola!</strong> Your account is now activated. So far, so good. Create a secure password.</div>";	
					  
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
					$stmt = $user->runQuery("UPDATE user_creds SET password=:upass WHERE id=:uid");
					$stmt->execute(array(":upass"=>$password,":uid"=>$rows['id']));
					
					$msg = "<div class='alert alert-success'>
							<button class='close' data-dismiss='alert'>&times;</button>
							Password set. Good job.<br>You'll be automatically redirected to your home page.</div>";
					header("refresh:5;index.php");
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
		<nav class='navbar navbar-default'>	
			<div id='header' class='container-fluid'>		
				<h1 class="hide"><a href="index.php">Stakeout</a></h1>

<?php 
	if ($jefe == 1) {
		echo $navbarJefe;
	}
	else {
		echo $navbarGator;
	}
?>
	
	</div> <!-- /container-fluid -->   
</nav> <!-- /navbar -->	   
    	<div class='alert alert-success'>
			<strong>Hello there, <?php echo $rows['username'] ?>.</strong> 
		</div>
		
        <form method="post" class="form-horizontal">
    		<fieldset>
        		<legend>Create Your Password</legend>

			<?php
            if(isset($msg))
            {
                echo $msg;
            }
            ?>
            
            <div class="form-group"><!-- Row 1 -->
                <!-- Column 1 -->
                <label class="col-lg-2 control-label" for="pass">Type password</label>
                <!-- Column 2 -->
                <div class="col-lg-4">
                    <input type="password" class="form-control" placeholder="Type your password" name="pass" required />
                </div>
        	</div><!-- /Row 1 -->
            
            <div class="form-group"><!-- Row 2 -->
                <!-- Column 1 -->
                <label class="col-lg-2 control-label" for="confirm-pass">Type it again</label>
                <!-- Column 2 -->
                <div class="col-lg-4">
                    <input type="password" class="form-control" placeholder="Type it again" name="confirm-pass" required />
                </div>
        	</div><!-- /Row 2 -->
            
			<div class="form-group"> <!-- Last Row -->
                <div class="col-lg-4 col-lg-offset-2">
                    <button class="btn btn-primary" type="submit" name="btn-make-pass"> Submit </button>
                </div>
            </div><!-- /Last Row -->
        </fieldset>            
            
        </form>
    </div> <!-- /container -->
  <script src='//roxorsoxor.com/stakeout/js/mobrules.js'></script></body>
</html>