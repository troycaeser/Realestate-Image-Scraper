<?php
	class PropertyDAO {
		private $dbConnection;
		private $dbObject;

		public function __construct() {
			$dao = DatabaseAccess::getInstance();
			$this->dbConnection = $dao->getConnection();

			$dbo = DatabaseObject::getInstance()
			$this->dbOject = $dbo->getDBO();

		public static function getPropertyById ($id) {
			// build the query and return
			// SQL:
			// SELECT * FROM property WHERE property_id = '.(int)$id.'
				/* PDO code */

			$q = $dbConnection->prepare ("SELECT * FROM property WHERE property_id = :id");
			$q->bindParam (':id', $id, PDO::PARAM_STR, 10);
			$res = $q->execute();
			// echo $res;
		}

		public static function getPropertyByAddress ($address) {
			// build the query and return
			// SQL:
			// SELECT * FROM property WHERE address LIKE '%.(int)$address.%'
				/* PDO code */
		}

		public static function getPropertyByAgency ($agency) {
			// build the query and return
			// SQL:
			// 		SELECT a.agency_name, p.*
			// 		FROM agency a, property p
			// 		WHERE a.agency_id = p.agency_id
			// 		AND a.agency_name = '.$agency.'
				/* PDO code */
		}

		public static function getPropertyByAgent ($agent) {
			// build the query and return
			// SQL:
			// 		SELECT a.agent_name, p.*
			// 		FROM agent a, property p
			// 		WHERE a.agent_id = p.agent_id
			// 		AND a.agent_name = '.$agent.'
				/* PDO code */
		}

		public static function getPropertyByPriceRange ($lo, $hi) {
			// build the query and return
			// SQL:
			// SELECT * FROM property
			// WHERE price_low > '.$lo.'
			// AND price_low < '.$hi.'
				/* PDO code */
		}

		public static function insertProperty (&$property) {
			// build the query and return
			// SQL:
			// 		INSERT INTO property ('property_id',
			// 							  'no_bed',
			// 							  'no_bath',
			// 							  'no_car',
			// 							  'no_study',
			// 							  'address',
			// 							  'price_low',
			// 							  'price_high',
			// 							  'agency_id',
			// 							  'agent_id')
			// 					  VALUES ($property['property_id'],
			// 							  $property['no_bed'],
			// 							  $property['no_bath'],
			// 							  $property['no_car'],
			// 							  $property['no_study'],
			// 							  $property['price_low'],
			// 							  $property['price_high'],
			// 							  $property['agency_id'],
			// 							  $property['agent_id'])
				/* PDO code */
		}

		public static function updateProperty ($id, $field, $value) {
			// build the query and return
			// SQL:
			// UPDATE FROM property
			// SET '.$field.' = '.$value.'
			// WHERE 'property_id' = '.$id.'
				/* PDO code */
		}

		public static function deleteProperty ($id) {
			// build the query and return
			// SQL:
			// DELETE FROM property
			// WHERE 'property_id' = '.$id.'
				/* PDO code */
		}
	}
?>
