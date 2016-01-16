<?php
/*
	$id = 5;
	try {
		// $conn = new PDO('mysql:host=localhost;dbname=myDatabase', $username, $password);
		// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
		
		$stmt = $conn->prepare('SELECT * FROM myTable WHERE id = :id');
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		

	}
	catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
*/

// CRUD

/* CREATE *

	try {
		// $pdo = new PDO('mysql:host=localhost;dbname=someDatabase', $username, $password);
		// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$stmt = $pdo->prepare('INSERT INTO someTable VALUES(:name)');
		$stmt->execute(array(
		':name' => 'Justin Bieber'
		));

		# Affected Rows?
		echo $stmt->rowCount(); // 1
	}
	catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
*/

/*
	class User {
		public $first_name;
		public $last_name;

		public function full_name() {
			return $this->first_name . ' ' . $this->last_name;
		}
	}
	try {
		// $pdo = new PDO('mysql:host=localhost;dbname=someDatabase', $username, $password);
		// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		// $result = $pdo->query('SELECT * FROM someTable');
	
		# Map results to object
		$result->setFetchMode(PDO::FETCH_CLASS, 'User');
	
		while($user = $result->fetch()) {
		# Call our custom full_name method
		echo $user->full_name();
		}
	}
	catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}

*/

// interface
//  interface property_dao_interface {}
//
//	public static function getPropertyById ($id) {
//			$dbAccess = new DatabaseAccess();
//			// build the query and return
//			// SQL:
//			// SELECT * FROM property WHERE property_id = '.(int)$id.'
//				/* PDO code */
//		}
//
//		public static function getPropertyByAddress ($address) {
//			$dbAccess = new DatabaseAccess();
//			// build the query and return
//			// SQL:
//			// SELECT * FROM property WHERE address LIKE '%.(int)$address.%'
//				/* PDO code */
//		}
//
//		public static function getPropertyByAgency ($agency) {
//			$dbAccess = new DatabaseAccess();
//			// build the query and return
//			// SQL: SELECT a.agency_name, p.*
//			// 		FROM agency a, property p
//			// 		WHERE a.agency_id = p.agency_id
//			// 		AND a.agency_name = '.$agency.'
//				/* PDO code */	
//		}
//
//		public static function getPropertyByAgent ($agent) {
//			$dbAccess = new DatabaseAccess();
//			// build the query and return
//			// SQL: SELECT a.agent_name, p.*
//			// 		FROM agent a, property p
//			// 		WHERE a.agent_id = p.agent_id
//			// 		AND a.agent_name = '.$agent.'
//				/* PDO code */	
//		}
//
//		public static function getPropertyByPriceRange ($lo, $hi) {
//			$dbAccess = new DatabaseAccess();
//			// build the query and return
//			// SQL:
//			// SELECT * FROM property
//			// WHERE price_low > '.$lo.'
//			// AND price_low < '.$hi.'
//				/* PDO code */
//		}
//
//
?>