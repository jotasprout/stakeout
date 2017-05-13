<?phprequire_once 'class.gator.php';require_once 'stylesAndSuch.php';$user = new USER();if(empty($_GET['id']) && empty($_GET['code'])) {	$user->redirect('login_form_09.php');}if(isset($_GET['id']) && isset($_GET['code'])) {	$id = base64_decode($_GET['id']);	$code = $_GET['code'];		$statusY = "Y";	$statusN = "N";			$stmt = $user->runQuery("SELECT * FROM user_creds4 WHERE id=:uID AND tokenCode=:code LIMIT 1");	$stmt->execute(array(":uID"=>$id,":code"=>$code));	$rows = $stmt->fetch(PDO::FETCH_ASSOC);		// if user is registered (there's a row for them)	if($stmt->rowCount() > 0) {		// VERIFICATION stuff		// if user is already active		if($row['userStatus']==$statusY) {			$msg = "<div class='alert alert-error'>				   <button class='close' data-dismiss='alert'>&times;</button>					  <strong>Shiite!</strong> Your account is already activated: <a href='index.php'>Login here</a>			       </div>";					}		// if user is NOT already active		else {			$stmt = $user->runQuery("UPDATE user_creds4 SET userStatus=:status WHERE id=:uID");			$stmt->bindparam(":status",$statusY);			$stmt->bindparam(":uID",$id);			$stmt->execute();							$msg = "<div class='alert alert-success'>				   <button class='close' data-dismiss='alert'>&times;</button>					<strong>Voila!</strong> Your account is now activated. So far, so good. Enter your new password.</div>";						  			// PASSWORD STUFF				if(isset($_POST['btn-make-pass'])) {				$pass = $_POST['pass'];				$cpass = $_POST['confirm-pass'];								if($cpass!==$pass) {					$msg = "<div class='alert alert-block'>							<button class='close' data-dismiss='alert'>&times;</button>							<strong>Passwords don't match.</strong> Try again.</div>";				}				else {					$password = md5($cpass);					$stmt = $user->runQuery("UPDATE user_creds4 SET password=:upass WHERE id=:uid");					$stmt->execute(array(":upass"=>$password,":uid"=>$rows['id']));										$msg = "<div class='alert alert-success'>							<button class='close' data-dismiss='alert'>&times;</button>							Password set. Good job.</div>";					header("refresh:5;index.php");				}			}						}			}	// if not registered (no row)	else {		$msg = "<div class='alert alert-error'>			   <button class='close' data-dismiss='alert'>&times;</button>			   <strong>I am so very, truly sorry!</strong> No such account found: <a href='signup.php'>Signup here</a>			   </div>";		}	}?><!DOCTYPE html><html>  <head>    <title>Password Reset</title><?php echo $stylesAndSuch; ?>        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->    <!--[if lt IE 9]>      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>    <![endif]-->  </head>  <body>    <div class="container">	<nav class="navbar navbar-default">		<div class="container-fluid">			<div class="navbar-header"> <a class="navbar-brand" href="http://www.roxorsoxor.com/mailer9/index_09.php">You</a> </div>			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">				<ul class="nav navbar-nav">					<li><a href="//www.roxorsoxor.com/mailer9/cases_09.php">Cases</a></li>					<li><a href="//www.roxorsoxor.com/mailer9/observations_09.php">Observations</a></li>					<li><a href="//www.roxorsoxor.com/mailer9/gators_09.php">Investigators</a></li>					<li><a href="//www.roxorsoxor.com/mailer9/assignments_09.php">Assignments</a></li></ul>				<ul class="nav navbar-nav navbar-right">					<li><a href="logout_09.php">Logout</a></li>				</ul>			</div>			<!-- /collapse --> 					</div>		<!-- /container-fluid --> 			</nav>	<!-- /navbar -->        	<div class='alert alert-success'>			<strong>Hello there,</strong> <?php echo $rows['username'] ?>! 		</div>        <form class="form-signin" method="post">        <h3 class="form-signin-heading">Password Reset</h3><hr />        <?php        if(isset($msg))		{			echo $msg;		}		?>        <input type="password" class="input-block-level" placeholder="Type your new password" name="pass" required />        <input type="password" class="input-block-level" placeholder="Type it again" name="confirm-pass" required />     	<hr />        <button class="btn btn-large btn-primary" type="submit" name="btn-make-pass">Make it so</button>              </form>    </div> <!-- /container -->  </body></html>