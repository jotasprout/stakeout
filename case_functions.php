<?php

	// PHP code in a more secure location
	require_once '../../../php/class.gator.php';
	
	class CASE {
		private $conn;
		
		$caseNum = htmlspecialchars($_POST['caseNum']);
		$caseName = htmlspecialchars($_POST['caseName']);
		$startDate = htmlspecialchars($_POST['startDate']);
		
		public function openCase ($caseNum,$caseName,$startDate) {
			try {
				$stmt = $this->conn->prepare("INSERT INTO cases (caseNum,caseName,startDate) VALUES (:caseNum,:caseName,:startDate)");
				$stmt->bindparam(":caseNum",$caseNum);
				$stmt->bindparam(":caseName",$caseName);
				$stmt->bindparam(":startDate",$startDate);
				$stmt->execute();
				return $stmt;
			}
			catch (PDOException $ex) {
				echo $ex->getMessage();
			}
		}
	}

?>
