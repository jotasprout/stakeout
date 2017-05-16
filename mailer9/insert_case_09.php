<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
if(!isset($_SESSION['username'])) {
	echo "<script>console.log('Nobody is logged in.')</script>";
	header("Location:login_form_09.php");
}
else {
	// $_SESSION['username'] = $userRow['username'];
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
<title>Open A Case</title>
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
	
	<!-- This form uses code in handle_prez to insert input into the database -->
	
	<form class="form-horizontal" action="handle_case_09.php" method="post">
		<fieldset>
			<legend>Open a Case</legend>
			<div class="form-group"> <!-- Row 1 --> 
				
				<!-- Column 1 -->
				
				<label class="col-lg-2 control-label" for="caseNum">Case #</label>
				
				<!-- Column 2 -->
				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="caseNum" placeholder="Case Number" />
				</div>
			</div>
			<!-- /Row 1 -->
			
			<div class="form-group"> <!-- Row 2 --> 
				
				<!-- Column 1 -->
				
				<label class="col-lg-2 control-label" for="caseName">Case Name</label>
				
				<!-- Column 2 -->
				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="caseName" placeholder="Case Name" />
				</div>
			</div>
			<!-- /Row 2 -->
			
			<div class="form-group"> <!-- Row 3 -->
				
				<label class="col-lg-2 control-label" for="startDate">Start Date</label>
				
				<!-- Column 2 -->
				
				<div class="col-lg-4">
					<input class="form-control" type="text" name="startDate" placeholder="YYYY-MM-DD" />
				</div>
			</div>
			<!-- /Row 3 -->
			
			<div class="form-group"> <!-- Last Row -->
				
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Open Case</button>
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
