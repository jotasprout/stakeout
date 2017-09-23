<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once '../../secret_php/dbconfig.php';

class REPORT {

	private $conn;
	
	public $jefe = false;

	public function __construct() {
		$report = new Report();
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

	// make this Cover
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
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}

	// make this List of Observations in chronological order
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
		catch(PDOException $ex) {
			echo $ex->getMessage();
		}
	}

}
