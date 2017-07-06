<?php

require_once 'dbconfig.php';

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
			$password = md5($upass);
			$stmt = $this->conn->prepare("INSERT INTO user_creds4 (username,forename,surname,email,tokenCode) VALUES(:user_name, :forename, :surname, :user_mail, :active_code)");
			$stmt->bindparam(":user_name",$uname);
			$stmt->bindparam(":forename",$forename);
			$stmt->bindparam(":surname",$surname);
			$stmt->bindparam(":user_mail",$email);
			$stmt->bindparam(":active_code",$code);
			$stmt->execute();
			return $stmt;
		}
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}

	public function login($email,$upass) {
		try {
			$stmt = $this->conn->prepare("SELECT * FROM user_creds4 WHERE email=:email_id");
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
						header("Location: https://www.roxorsoxor.com/stakeout/login_form.php?error");
						exit;
					}
				}
				else {
					header("Location: https://www.roxorsoxor.com/stakeout/login_form.php?inactive");
					exit;
				}
			}
			else {
				header("Location: https://www.roxorsoxor.com/stakeout/login_form.php?error");
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
		header("location: https://www.roxorsoxor.com/stakeout/login_form.php");
	}

	function send_mail($email,$message,$subject) {
		require_once('mailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug  = 0;
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host       = "roxorsoxor.com";
		$mail->Port       = 465;
		$mail->AddAddress($email);
		$mail->Username="stakeout@roxorsoxor.com";
		$mail->Password="P3@c30utBro!";
		$mail->SetFrom('stakeout@roxorsoxor.com','Stakeout');
		$mail->AddReplyTo("stakeout@roxorsoxor.com","Stakeout");
		$mail->Subject    = $subject;
		$mail->MsgHTML($message);
		$mail->Send();
	}
}
