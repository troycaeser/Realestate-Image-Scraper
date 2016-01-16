<?php
	class DatabaseObject {
		private $dbo;
		private static $m_instance;

		public static function getInstance() {
			if (!self::$m_instance)
				self::$m_instance = new self();
			return self::$m_instance;
		}

		private function __construct() {
			// select database
				/* PDO code */

			// mysql version:
			// $this->dbo = mysql_select_db($database);
		}

		function __destruct() {
			$this->dbo = null;
		}

		private function __clone() {
		}

		public function getDBO() {
			return $this->dbo;
		}
	}
?>