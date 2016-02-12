<?php
	require 'database.php';

	class DatabaseAccess {
		private $connection;
		private static $m_instance;
		private $m_host = "localhost";
		private $m_username = "root";
		private $m_password = "root";
		private $m_database = "linkubi";

		public static function getInstance() {
			if (!self::$m_instance)
				self::$m_instance = new self();
			return self::$m_instance;
		}

		private function __construct() {
			// create connection
				/* PDO code */
			$this->connection = new PDO('mysql:host=localhost;dbname=linkubi', $this->m_username, $this->m_password);

			return $this->connection;
			// error handling
				/* PDO code */

			/*
			try {
				$this->connection = new PDO ('mysql:host=localhost;dbname=test', $m_username, $m_password);
			}
			catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			*/
		}

		function __destruct() {
			$this->connection = null;
		}

		private function __clone() {
		}

		public function getConnection() {
			return $this->connection;
		}
	}
?>
