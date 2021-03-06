<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../../secret_php/dbconfig.php';

class USER {

	private $conn;
	
	public $jefe = false;

	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

	public function runQuery($sql) {
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lasdID() {
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

	public function register($uname,$forename,$surname,$email,$code) {
		try {
			// $password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO user_creds (username,forename,surname,email,tokenCode) VALUES(:user_name, :forename, :surname, :user_mail, :active_code)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":forename",$forename);
			$stmt->bindparam(":surname",$surname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();
			return $stmt;
		}

		// should not ex be exception like it is in user class? Make all of this consistent
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}

	public function login($email,$upass) {
		try {
			$stmt = $this->conn->prepare("SELECT * FROM user_creds WHERE email=:email_id");
			$stmt->execute(array(":email_id"=>$email));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

			if($stmt->rowCount() == 1) {
				if($userRow['userStatus']=="Y") {
					if($userRow['password']==md5($upass)) {
						$_SESSION['username'] = $userRow['username'];
						$_SESSION['email'] = $userRow['email'];
						$_SESSION['forename'] = $userRow['forename'];
						$_SESSION['jefe'] = $userRow['admin'];
						return true;
					}
					else {
						header("Location: http://www.roxorsoxor.com/stakeout/login_form.php?error");
						exit;
					}
				}
				else {
					header("Location: http://www.roxorsoxor.com/stakeout/login_form.php?inactive");
					exit;
				}
			}
			else {
				header("Location: http://www.roxorsoxor.com/stakeout/login_form.php?error");
				exit;
			}
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}

	public function areTheyLoggedIn() {
		if(isset($_SESSION['username'])) {
			return true;
		}
	}
	
	public function redirect($url) {
		header("Location: $url");
	}

	public function logout() {
		session_destroy();
		$_SESSION['username'] = false;
		header("location: http://www.roxorsoxor.com/stakeout/login_form.php");
	}

	function send_mail($email,$message,$subject) {

		require 'vendor/autoload.php';

		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->SMTPDebug  = 2;
		$mail->SMTPAuth   = true;
		$mail->AuthType = "PLAIN";
		$mail->SMTPSecure = "TLS";
		$mail->Host       = "mailtime.roxorsoxor.com";
		$mail->Port       = 587;
		$mail->AddAddress($email);
		$mail->Username="stakeout@roxorsoxor.com";
		$mail->Password='shesofine';
		$mail->SetFrom('stakeout@roxorsoxor.com','Stakeout');
		$mail->AddReplyTo("stakeout@roxorsoxor.com","Stakeout");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}

	function message_bottle ($email, $message, $subject) {
		$to = $email;
		$subject = $subject;
	
		// headers for From info
		$headers = "From: stakeout@roxorsoxor.com\r\n";
		$headers .= "Reply-To: stakeout@roxorsoxor.com\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();
	
		// body
		$message = $message;
	
		// send email
		mail($to, $subject, $message, $headers);
	}

}
