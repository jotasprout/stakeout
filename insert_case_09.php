<?php
session_start();
require_once 'class.gator.php';
require_once 'stylesAndSuch.php';
require_once 'navbar.php';
$user = new USER();

if(!$user->areTheyLoggedIn()) {
	$user->redirect('https://www.roxorsoxor.com/stakeout/login_form_09.php');
}
else {
	$jefe = $_SESSION['jefe'];
	if ($jefe == 1) {
		echo "<script>console.log('You are an admin.')</script>";
	}
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
<nav class='navbar navbar-default'>	
	<div id='header' class='container-fluid'>		
		<h1 class="hide"><a href="index_09.php">Stakeout</a></h1>
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
	
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">New Case</h3>
		</div>
		<div class="panel-body"> 	
	
	<!-- This form uses code in handle_prez to insert input into the database -->
	
	<form class="form-horizontal" action="handle_case_09.php" method="post">
		<fieldset>
		
			<div class="form-group"> <!-- Row 1 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="caseNum">Case #</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="caseNum" placeholder="Case Number" />
				</div>
			</div> <!-- /Row 1 -->
			
			<div class="form-group"> <!-- Row 2 --> 
				<!-- Column 1 -->
				<label class="col-lg-2 control-label" for="caseName">Case Name</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="text" name="caseName" placeholder="Case Name" />
				</div>
			</div> <!-- /Row 2 -->
			
			<div class="form-group"> <!-- Row 3 -->
				<label class="col-lg-2 control-label" for="startDate">Start Date</label>
				<!-- Column 2 -->
				<div class="col-lg-4">
					<input class="form-control" type="date" name="startDate" placeholder="YYYY-MM-DD" />
				</div>
			</div> <!-- /Row 3 -->
			
			<div class="form-group"> <!-- Last Row -->
				<div class="col-lg-4 col-lg-offset-2">
					<button class="btn btn-primary" type="submit" name="submit">Open Case</button>
				</div>
			</div> <!-- /Last Row -->
			
		</fieldset>
	</form>
			 
		</div> <!-- /panel-body -->
	</div> <!-- /panel-primary -->	
	
</div> <!-- /container -->
<script src='//roxorsoxor.com/stakeout/mobrules.js'></script></body>
</html>
