<?php

require_once 'class.gator5.php';
$user = new USER();

if(empty($_GET['id']) && empty($_GET['code'])) {	
    $user->redirect('login_form5.php');
    }

if(isset($_GET['id']) && isset($_GET['code'])) {	
    $id = base64_decode($_GET['id']);	
    $code = $_GET['code'];		
    $statusY = 1;	
    $statusN = 0;		
    $stmt = $user->runQuery("SELECT id,status FROM user_creds4 WHERE id=:uID AND tokenCode=:code LIMIT 1");	
    $stmt->execute(array(":uID"=>$id,":code"=>$code));	
    $row=$stmt->fetch(PDO::FETCH_ASSOC);	
    
    if($stmt->rowCount() > 0) {		
        if($row['status']==$statusN) {			
            $stmt = $user->runQuery("UPDATE user_creds4 SET status=:status WHERE id=:uID");			$stmt->bindparam(":status",$statusY);			
            $stmt->bindparam(":uID",$id);			
            $stmt->execute();							
            $msg = "<div class='alert alert-success'><button class='close' data-dismiss='alert'>&times;</button><strong>Dude!</strong> Your account is now activated: <a href='login_form5.php'>Login here</a></div>";			
        }		
        else {			
            $msg = "<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Dude!</strong> Your account is already activated: <a href='login_form5.php'>Login here</a></div>";		
        }	
    }	
    else {		
        $msg = "<div class='alert alert-error'><button class='close' data-dismiss='alert'>&times;</button><strong>Sorry, dude!</strong> No such account found: <a href='insert_gator5.php'>Signup here</a></div>";	
    }	
}
?>

<!DOCTYPE html>
<html>  

<head>    
<title>Confirm Registration</title>    
<!-- Bootstrap -->    
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">    
<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">    
<link href="assets/styles.css" rel="stylesheet" media="screen">     
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->    
<!--[if lt IE 9]>      
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>    
<![endif]-->    

<script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>  
</head>  

<body id="login">    

<div class="container">		

<?php 
if(isset($msg)) { 
    echo $msg; 
} 
?>    

</div> <!-- /container -->    

<script src="vendors/jquery-1.9.1.min.js"></script>    
<script src="bootstrap/js/bootstrap.min.js"></script>  
</body>
</html>