<?php
	require_once 'areTheyLoggedIn4.php';
?>

<!DOCTYPE html>
<html>
<head><meta name="viewport" content="user-scalable=no, width=device-width" />
<meta charset="UTF-8">
    <title>Open A Case</title>   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="http://www.jotascript.com/js/bootstrap/css/justified-nav.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">

            <div class="masthead">
                <a href="http://www.roxorsoxor.com/stakeout4/index4.php"><img src="http://www.roxorsoxor.com/stakeout/stakeoutLogo.png" width="680" height="198"/></a>      
            </div> <!-- /masthead -->

            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="http://www.roxorsoxor.com/stakeout4/index4.php">Home</a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				   		<ul class="nav navbar-nav">
                            <li><a href="http://www.roxorsoxor.com/stakeout4/cases4.php">Cases</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/observations4.php">Observations</a></li>
                            <li><a href="http://www.roxorsoxor.com/stakeout4/gators4.php">Investigators</a></li>
							<li><a href="http://www.roxorsoxor.com/stakeout4/assignments4.php">Assignments</a></li>						
						</ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="logout_stakeout4.php">Logout</a></li>
                        </ul>
                    </div> <!-- /collapse -->                    
                </div> <!-- /container-fluid -->   
            </nav> <!-- /navbar -->

        <!-- This form uses code in handle_prez to insert input into the database -->
        <form class="form-horizontal" action="handle_case4.php" method="post">
            <fieldset>
            	<legend>Open a Case</legend>
                
                <div class="form-group"> <!-- Row 1 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseNum">Case #</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseNum" placeholder="Case Number" />
                    </div>
                </div><!-- /Row 1 -->    
                
                <div class="form-group"> <!-- Row 2 -->
                    <!-- Column 1 -->
                    <label class="col-lg-2 control-label" for="caseName">Case Name</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="caseName" placeholder="Case Name" />
                    </div>
                </div><!-- /Row 2 -->         		

                <div class="form-group"> <!-- Row 3 -->
                    <label class="col-lg-2 control-label" for="startDate">Start Date</label>
                    <!-- Column 2 -->
                    <div class="col-lg-4">
                        <input class="form-control" type="text" name="startDate" placeholder="YYYY-MM-DD" />
                    </div>
                </div><!-- /Row 3 --> 
 
                <div class="form-group"> <!-- Last Row -->           
                    <div class="col-lg-4 col-lg-offset-2">
                        <button class="btn btn-primary" type="submit" name="submit">Open Case</button>
                    </div>
                </div><!-- /Last Row -->            
            
            </fieldset>
        </form>
	
    <footer class="footer">
        <p>&copy; RoxorSoxor 2017</p>
    </footer>

</div> <!-- /container -->

</body>
</html>