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

	public function reportCase() {
		if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
			// query db
			$caseID = $_GET['id'];
			$result = mysqli_query($connekt, "SELECT * FROM cases WHERE caseID=$caseID")
			or die(mysqli_error($result));
			$row = mysqli_fetch_array($result);
			// check that the 'id' matches up with a row in the databse
			if($row) {
				// get data from db
				$caseID = $row['caseID'];
				$caseNum = $row['caseNum'];
				$caseName = $row['caseName'];
				$startDate = new DateTime($row["startDate"] ." UTC");
				$startDate ->setTimezone(new DateTimeZone('America/New_York')); 
				$endDate = $row['endDate'];
				$deliveryDate = $row['deliveryDate'];
			}
			else {
				// if no match, display result
				echo "No results!";
			}
		}
		else {
			// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error 
			echo $error;
		}
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
