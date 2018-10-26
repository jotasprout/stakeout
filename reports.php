<?php
    session_start();
    require_once 'class.gator.php';
    require_once 'stylesAndSuch.php';
    require_once 'navbar.php';
    $user = new USER();

    if(!$user->areTheyLoggedIn()) {
        $user->redirect('http://www.roxorsoxor.com/stakeout/login_form.php');
    }
    else {
        $jefe = $_SESSION['jefe'];
        if ($jefe == 1) {
            echo "<script>console.log('You are an admin.')</script>";
        } else {
            $user->redirect('index.php');
        }	
        $username = $_SESSION['username'];
        echo "<script>console.log('" . $username . " is logged in.')</script>";
    }
?>

<!DOCTYPE html>
<html>

<head>
	<title>Reports</title>
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
    </nav> <!-- /navbar -->	
	<!-- main -->
	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Reports</h3>
		</div>
		<div class="panel-body"> 
			
			<!-- Panel Content --> 

            <div class="form-group"> 
                <div class="col-lg-4 col-lg-offset-2">
                    <button class="btn btn-primary" type="submit" name="submit">Create Cover</button>
                </div>  
            </div> 

		</div>
    </div>
    	
</div> <!-- /container-fluid -->   

<script src='//roxorsoxor.com/stakeout/js/mobrules.js'></script></body>
</html>
