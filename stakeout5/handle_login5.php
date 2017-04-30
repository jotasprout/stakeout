<?php	
require_once '../../../php/landfill.php'; 

// connects to db	
$connekt = new mysqli($db_hostname, $db_username, $db_password, $db_database);	

if ($connekt->connect_error) die($connekt->connect_error);

// IF level 1 -- if connection to server is successful		
if (isset($_POST['username']) && isset($_POST['password']))	{    	
    $un_temp = mysqli_entities_fix_string($connekt, $_POST['username']);    	
    $pw_temp = mysqli_entities_fix_string($connekt, $_POST['password']);		
    // get info from db for matching username		
    $query = "SELECT * FROM user_creds4 WHERE username='$un_temp'";    	
    $result = $connekt->query($query);    	
    if (!$result) die($connekt->error);	
    // IF level 2 -- if query to table for matching username was successful, scramble submitted pw and compare to db pw			
    elseif ($result->num_rows) {			
        $row = $result->fetch_array(MYSQLI_NUM);			
        $result->close();			
        $salt1 = "qm&h*";			
        $salt2 = "pg!@";			
        $pw_hashness = hash('ripemd128', "$salt1$pw_temp$salt2");	
        
        // IF level 3 -- if entered pw matches pw in db		
        if ($pw_hashness == $row[4]) {				
            session_start();				
            $_SESSION['username'] = $un_temp;				
            $_SESSION['password'] = $pw_temp;				
            $_SESSION['forename'] = $row[1];				
            $_SESSION['surname']  = $row[2];				
            header("location:index5.php");			
        } // end of IF level 3 true			
        else die("Access Denied. Username and/or Password not accepted."); // end of IF level 3 false		
    } // end of IF level 2 true		
    else die("Access Denied. Username and/or Password not accepted."); 
    // end of IF level 2 false	
} // end of IF level 1 true -- if there's a connection to the database	

// close db connection	
$connekt->close();	
function mysqli_entities_fix_string($connekt, $string) {		
    return htmlentities(mysqli_fix_string($connekt, $string));	
}	
function mysqli_fix_string($connekt, $string) {		
    if (get_magic_quotes_gpc()) 
    $string = stripslashes($string);		
    return $connekt->real_escape_string($string);	
}	

// NEW STUFF
session_start();
require_once 'class.gator5.php';
$user_login = new USER();
if($user_login->is_logged_in()!=""){	
    $user_login->redirect('index5.php');
}
if(isset($_POST['btn-login'])){	
    $email = trim($_POST['txtemail']);	
    $upass = trim($_POST['txtupass']);		
    if($user_login->login($email,$upass)) {		
        $user_login->redirect('index5.php');	
    }
}	

?>