<?php

	require_once 'areTheyLoggedIn4.php';
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . "  is logged in.')</script>";

	error_reporting( ~E_NOTICE ); // avoid notice
	
	require_once '../../../php/landfill5.php';
	
	if(isset($_POST['btnsave']))
	{
		$username = $_POST['username']; // user name
		$lat  = $_POST['txtlat'];	
		$lng = $_POST['txtlng'];
		// echo "<script>console.log('Latitude is " . $lat . "')</script>";
		// echo "<script>console.log('Longitude is " . $lng . "')</script>";
		$observation = $_POST['observation']; // user email
		$caseID = $_POST['assignedCase'];
		$action = $_POST['action'];
		$pix = $_POST['pix'];
		
		$imgFile = $_FILES['observeImage']['name'];
		$tmp_dir = $_FILES['observeImage']['tmp_name'];
		$imgSize = $_FILES['observeImage']['size'];
		
		
		if(empty($username)){
			$errMSG = "Please Enter Username.";
		}
		else if(empty($observation)){
			$errMSG = "Please type your observation or image description.";
		}
		
		if(!empty($imgFile)){
			$upload_dir = 'observe_pix/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
		
			// rename uploading image
			$userpic = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$userpic);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";		
			}
		}
		
		
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $DB_con->prepare('INSERT INTO observations4(username,observation,observePic,lat,lng,caseID,action,pix) VALUES(:uname, :observation, :observePic, :lat, :lng, :caseID, :action, :pix)');
			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':observation',$observation);
			$stmt->bindParam(':observePic',$observePic);
			$stmt->bindParam(':lat',$lat);
			$stmt->bindParam(':lng',$lng);	
			$stmt->bindParam(':caseID',$caseID);
			$stmt->bindParam(':action',$action);
			$stmt->bindParam(':pix',$pix);
			
			if($stmt->execute())
			{
				$successMSG = "new record succesfully inserted ...";
				header("refresh:5;observations4.php"); // redirects image view page after 5 seconds.
			}
			else
			{
				$errMSG = "error while inserting....";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Observation</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>
<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
 
        <div class="navbar-header">
			<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a>
			<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a>
			<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a>
			<a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/assignments4.php">Assignments</a>           
        </div>
 
    </div>
</div>

<div class="container">


	<div class="page-header">
    	<h1 class="h2">Observation Upload<a class="btn btn-default" href="index.php"> <span class="glyphicon glyphicon-eye-open"></span> &nbsp; view all </a></h1>
    </div>
    

	<?php
	if(isset($errMSG)){
			?>
            <div class="alert alert-danger">
            	<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
            </div>
            <?php
	}
	else if(isset($successMSG)){
		?>
        <div class="alert alert-success">
              <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
        </div>
        <?php
	}
	?>   

<form method="post" enctype="multipart/form-data" class="form-horizontal">
	<input type="hidden" name="txtlat" id="txtlat" required value="">
	<input type="hidden" name="txtlng" id="txtlng" required value="">	    
	<table class="table table-bordered table-responsive">
	
    <tr>
    	<td><label class="control-label">username</label></td>
        <td><input class="form-control" type="text" name="username" placeholder="username" value="<?php echo $username; ?>" /></td>
    </tr>
    
			<?php
			
				// PHP code in a more secure location
				include("../../../php/landfill.php");
				// require_once '../../../php/landfill.php';
			
				// connect to database
				$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);
			
				// Connection test and feedback
				if (!$connekt) {
					die('Rats! Could not connect: ' . mysqli_error());
					echo "<script>console.log('Rats! Could not connect')</script>";
				}
			
				// Create variable for query	
				$query9 = "
				
				SELECT a.caseID, c.caseName, c.status, a.username 
					FROM assignments4 a
						INNER JOIN cases4 c
							ON a.caseID = c.caseID
								WHERE a.username = '$username' AND c.status = 1";
			
				// Use variable with MySQL command to grab info from database
				$result9 = $connekt->query($query9);	
				
				// Create Case Menu
				echo "<tr>";
					echo "<td>";
					echo "<label class='control-label' for='assignedCase'>Case</label>";
					echo "</td><td>";
						echo "<select class='form-control' name='assignedCase'>";
							echo "<option value=''>- Choose -</option>";
							while ($row = mysqli_fetch_array($result9)) {
								echo "<script>console.log('" . $row['username'] . " is assigned " . $row['caseName'] . "')</script>";
								echo "<option value='" . $row['caseID'] . "'>" . $row['caseName'] . "</option>";
							}
						echo "</select>";
					echo "</td>";
				echo "</tr>";
			
				// Feedback of whether UPDATE worked or not
				if(!$result9){
					echo "<script>console.log('query did not work')</script>";
				}						
			
				// When attempt is complete, connection closes
				mysqli_close($connekt);
			
			?>    
    
    		<tr> <!-- Row 3 -->
    			<td>
					<label class="control-label" for="action">Action</label>
				</td>
				<td>
					<select class="form-control" name="action">
						<option value="">- Choose -</option>
						<option value="pretextContact">Pretext Contact</option>
						<option value="socialMedia">Social Media</option>
						<option value="surveillance">Surveillance</option>
						<option value="trashPull">Trash Pull</option>
						<option value="undercover">Undercover</option>
					</select>
				</td>
			</tr>
    
    <tr>
    	<td><label class="control-label">Observation</label></td>
        <td><textarea class="form-control" name="observation" placeholder="Observation" value="<?php echo $observation; ?>" /></textarea></td>
    </tr>
    
    			<tr>
    				<td><label class="control-label">Photo(s) Taken</label></td>
    				<td>
						<label><input name="pix" id="photoYes" type="radio" checked="" value="Yes">Yes</label>
						<label><input name="pix" id="photoNo" type="radio" checked="" value="No">No</label>
					</td>
				</tr>
    
    <tr>
    	<td><label class="control-label">Photo</label></td>
        <td><input class="input-group" type="file" name="observeImage" accept="image/*" /></td>
    </tr>
    
    <tr>
        <td colspan="2"><button type="submit" name="btnsave" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span> &nbsp; Upload
        </button>
        </td>
    </tr>
    
    </table>
    
</form>

<!--
<div class="alert alert-info">
    <strong>App Update:</strong> <a href="http://www.roxorsoxor.com">Read here</a>!
</div>
-->
    
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="geoloc5.js"></script>
</body>
</html>