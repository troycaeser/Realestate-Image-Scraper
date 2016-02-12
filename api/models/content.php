<?php
	class Content{
		protected $dbConnection;
		private $dbObject;

		public function __construct(){
			$dao = DatabaseAccess::getInstance();
			$this->dbConnection = $dao->getConnection();
		}

		public function getContent(){
			$q = $this->dbConnection->prepare("SELECT * FROM t_content");
			$res = $q->execute();
			return $q->fetchAll();
		}

		public function getContentById($id){
			$q = $this->dbConnection->prepare("SELECT * FROM t_content WHERE content_id = :id");
			$q->bindParam(':id', $id, PDO::PARAM_STR, 10);
			$res = $q->execute();
			return $q->fetchAll();
		}
	}
?>
