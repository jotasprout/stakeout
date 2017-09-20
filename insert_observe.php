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
	}
	$username = $_SESSION['username'];
	echo "<script>console.log('" . $username . " is logged in.')</script>";
}
	error_reporting( ~E_NOTICE ); // avoid notice
	$database = new Database();
	$db = $database->dbConnection();
	if(isset($_POST['btnsave'])) {
		$username = $_POST['username']; // user name
		$lat  = $_POST['txtlat'];	
		$lng = $_POST['txtlng'];
		$description = $_POST['description']; // user email
		$caseID = $_POST['assignedCase'];
		$action = $_POST['action'];
		$pix = $_POST['pix'];
		$imgFile = $_FILES['observeImage']['name'];
		$tmp_dir = $_FILES['observeImage']['tmp_name'];
		$imgSize = $_FILES['observeImage']['size'];
		if(empty($username)){
			$errMSG = "Please Enter Username.";
		}
		else if(empty($description)){
			$errMSG = "Please type a description of your observation, image, or audio file.";
		}
		
		if(!empty($imgFile)){
			$upload_dir = 'caseAssets/'; // upload directory
	
			$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
		
			// valid image extensions
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'm4a', 'mp3'); // valid extensions
		
			// rename uploading image
			$observeAsset = rand(1000,1000000).".".$imgExt;
				
			// allow valid image file formats
			if(in_array($imgExt, $valid_extensions)){			
				// Check file size '5MB'
				if($imgSize < 5000000)				{
					move_uploaded_file($tmp_dir,$upload_dir.$observeAsset);
				}
				else{
					$errMSG = "Sorry, your file is too large.";
				}
			}
			else{
				$errMSG = "Sorry, only JPG, JPEG, PNG, GIF, M4A, and MP3 files are allowed.";		
			}
		}
			
		// if no error occured, continue ....
		if(!isset($errMSG))
		{
			$stmt = $db->prepare('INSERT INTO observations(username,description,observeAsset,lat,lng,caseID,action,pix, observeTime) VALUES(:uname, :description, :observeAsset, :lat, :lng, :caseID, :action, :pix, UTC_TIMESTAMP())');
			$stmt->bindParam(':uname',$username);
			$stmt->bindParam(':description',$description);
			$stmt->bindParam(':observeAsset',$observeAsset);
			$stmt->bindParam(':lat',$lat);
			$stmt->bindParam(':lng',$lng);	
			$stmt->bindParam(':caseID',$caseID);
			$stmt->bindParam(':action',$action);
			$stmt->bindParam(':pix',$pix);
			
			if($stmt->execute())
			{
				$successMSG = "Observation inserted.";
			}
			else
			{
				$errMSG = "Error while inserting. Sorry that's so vague.";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Observation</title>
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

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">New Observation</h3>
	</div>
	<div class="panel-body">


<?php
if(isset($errMSG)){
?>

<div class="alert alert-danger"><strong><?php echo $errMSG; ?></strong> </div>

<?php
}
else if(isset($successMSG)){
?>

<div class="alert alert-success"> <strong><?php echo $successMSG; ?></strong> </div>

<?php
}
?>
    	
<form method="post" enctype="multipart/form-data" class="form-horizontal">
    <fieldset>
		<input type="hidden" name="txtlat" id="txtlat" required value="">
		<input type="hidden" name="txtlng" id="txtlng" required value="">
        <input type="hidden" name="username" value="<?php echo $username; ?>" />
		<!-- Row 1
		<div class="form-group">
            <label class="col-lg-2 control-label" for="username">Username</label>
            <div class="col-lg-4">
                
            </div>
        </div>
		-->

			<?php
				// PHP code in a more secure location
				include("../../secret_php/landfill.php");
				// require_once '../../secret_php/landfill.php';
			
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
					FROM assignments a
						INNER JOIN cases c
							ON a.caseID = c.caseID
								WHERE a.username = '$username' AND c.status = 1";
			
				// Use variable with MySQL command to grab info from database
				$result9 = $connekt->query($query9);	
				
				// Create Case Menu
				echo "<div class='form-group'>";
					echo "<label class='col-lg-2 control-label' for='assignedCase'>Case</label>";
					echo "<div class='col-lg-4'>";
						echo "<select class='form-control' name='assignedCase'>";
							echo "<option value=''>- Choose -</option>";
							while ($row = mysqli_fetch_array($result9)) {
								echo "<script>console.log('" . $row['username'] . " is assigned " . $row['caseName'] . "')</script>";
								echo "<option value='" . $row['caseID'] . "'>" . $row['caseName'] . "</option>";
							}
						echo "</select>";
					echo "</div>";
				echo "</div>";
			
				// Feedback of whether UPDATE worked or not
				if(!$result9){
					echo "<script>console.log('query did not work')</script>";
				}						
			
				// When attempt is complete, connection closes
				mysqli_close($connekt);
			
			?>
			<div class='form-group'> <!-- Row 3 -->
				<label class='col-lg-2 control-label' for='action'>Action</label>

				<div class='col-lg-4'>
                	<select class="form-control" name="action">
						<option value="">- Choose -</option>
						<option value="pretextContact">Pretext Contact</option>
						<option value="socialMedia">Social Media</option>
						<option value="surveillance">Surveillance</option>
						<option value="trashPull">Trash Pull</option>
						<option value="undercover">Undercover</option>
					</select>
                </div>
			</div>
            
			<div class='form-group'> <!-- Row 4 -->
				<label class='col-lg-2 control-label' for='description'>Description</label>
                <div class='col-lg-4'>
					<textarea class="form-control" name="description" placeholder="Description" value="<?php echo $description; ?>" /></textarea>
                </div>
			</div>
            
			<div class='form-group'> <!-- Row 5 -->
				<label class='col-lg-2 control-label' for='pix'>Photo(s) Taken</label>
                <div class='col-lg-4'>
                    <label class="mobRadio"><input name="pix" id="photoYes" type="radio" checked="" value="Yes"> Yes</label>
                    <label class="mobRadio"><input name="pix" id="photoNo" type="radio" checked="" value="No"> No</label>
                </div>
			</div>
            
			<div class='form-group'> <!-- Row 6 -->
				<label class='col-lg-2 control-label' for='observeImage'>Upload Asset</label>
				<div class='col-lg-4'>
                	<input class="input-group" type="file" name="observeImage" accept="image/jpeg,image/jpg,image/png,image/gif,audio/mp3,audio/m4a" />
                </div>
			</div>
            
			<div class="form-group"> <!-- Last Row -->
                <div class="col-lg-4 col-lg-offset-2">
                    <button class="btn btn-primary" type="submit" name="btnsave">Submit</button>
                </div>
            </div><!-- /Last Row -->
        </fieldset>
	</form> 
	
		</div> <!-- /panel-body -->
	</div> <!-- /panel-primary -->	
	
</div> <!-- /container -->

<script src="/js/geoloc5.js"></script>
<script src='//roxorsoxor.com/stakeout/js/mobrules.js'></script></body>
</html>