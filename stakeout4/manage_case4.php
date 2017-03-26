<?php

	require_once 'areTheyLoggedIn4.php';

# if they are logged in, the following works like normal?

function renderForm($caseNum, $caseName, $startDate, $status, $endDate, $deliveryDate, $error)
	{
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Case Management</title>
    <script src="http://www.jotascript.com/js/jquery-214.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="http://www.jotascript.com/js/bootstrap/js/bootstrap.js"></script>
    <LINK href="favicon.ico" rel="icon" type="image/x-icon">
    <LINK href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <LINK href="favicon.ico" rel="icon" type="image/ico"> 
</head>

<body>
	<div class="container">
            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout4/index4.php"><img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/></a>      
            </div> <!-- /masthead -->

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Stakeout Home</a>
                    </div>
                    
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                        <ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://www.roxorsoxor.com">RoxorSoxor.com</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    
                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->
 
 
 
<?php 
 	// if there are any errors, display them
 	if ($error != '')
		{
		echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
		}
?> 
 
		<p>*Required</p>
 		<p><strong>ID:</strong> <?php echo $id; ?></p>
        <form class="form-horizontal" action="" method="post">
        	<input type="hidden" name="id" value="<?php echo $id; ?>"/>
            
            <fieldset>
            	<legend>Case Management</legend>
                
                <div class="form-group"> <!-- Row 1 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseNum">Case Number</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseNum" value="<?php echo $caseNum; ?>"/>
                    </div>
                </div><!-- /Row 1 -->            		

                <div class="form-group"> <!-- Row 2 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseName">Case Name</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseName" value="<?php echo $caseName; ?>" />
                    </div>
                </div><!-- /Row 2 -->

                <div class="form-group"> <!-- Row 4 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="startDate">Start Date</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="startDate" value="<?php echo $startDate; ?>" />
                    </div>
                </div><!-- /Row 4 -->
    
                <div class="form-group"> <!-- Row 5 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="endDate">End Date</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="endDate" value="<?php echo $endDate; ?>" />
                    </div>
                </div><!-- /Row 5 -->
 
                <div class="form-group"> <!-- Last Row -->           
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Update Case</button>
                    </div>
                </div><!-- /Last Row -->            
            
            </fieldset>
        </form> 
 
 	</div> <!-- /container -->
    
 </body>
 </html> 
 
<?php

	} // end of the renderForm function


// credentials in a more secure location
include("../../../php/landfill.php");

//Uses PHP code to connect to database
mysqli_select_db("jscript_stakeout", $connekt);
 
// check if the form has been submitted. If it has, process the form and save it to the database
if (isset($_POST['submit']))
	{ 
	
	// confirm that the 'id' value is a valid integer before getting the form data
	if (is_numeric($_POST['id']))
		{
			
		// get form data, making sure it is valid
		$id = $_POST['id'];
		$caseNum = mysqli_real_escape_string(htmlspecialchars($_POST['caseNum']));
		$caseName = mysqli_real_escape_string(htmlspecialchars($_POST['caseName']));
		$startDate = mysqli_real_escape_string(htmlspecialchars($_POST['startDate']));
		$endDate = mysqli_real_escape_string(htmlspecialchars($_POST['endDate']));		

		// check that firstName and lastName fields are both filled in
		if ($caseNum == '' || $startDate == '')
			{
			// generate error message
			$error = 'ERROR: Boy, you sure are stupid! Fill in all required fields like you were told!';
 
			//error, display form
			renderForm($id, $caseNum, $caseName, $startDate, $endDate, $error);
			}

		else
			{

			// save data to database
			mysqli_query("UPDATE cases SET caseNum='$caseNum', caseName='$caseName',startDate='$startDate', endDate='$endDate' WHERE id='$id'")
			or die(mysqli_error()); 
 
			// after save, go to view page
			header("Location: cases4.php"); 
			}
		}

	else
		{

		// if the 'id' isn't valid, display an error
		echo 'Error!';
		}
	}

else // if the form hasn't been submitted, get the data from the db and display the form
	{

	// get 'id' value from URL (if it exists), confirming it is valid and is numeric/larger than 0)
	if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)
		{

		// query db
		$id = $_GET['id'];
		$result = mysqli_query("SELECT * FROM cases WHERE id=$id")
		or die(mysqli_error()); 
		$row = mysqli_fetch_array($result);
 
		// check that the 'id' matches up with a row in the databse
		if($row)
			{
 
			// get data from db
			$caseNum = $row['caseNum'];
			$caseName = $row['caseName'];
			$startDate = $row['startDate'];
			$endDate = $row['endDate'];			
 
			// show form
			renderForm($id, $caseNum, $caseName, $startDate, $endDate, '');
			}

		else // if no match, display result
			{
			
			echo "No results!";
			}
		}

	else // if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error
		{
		echo 'Error!';
		}
	}
?>