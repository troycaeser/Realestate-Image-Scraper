<?php
	class MmsContent{
		protected $dbConnection;
		private $dbObject;

		public function __construct(){
			$dao = DatabaseAccess::getInstance();
			$this->dbConnection = $dao->getConnection();
		}

		public function getMmsContent(){
			$q = $this->dbConnection->prepare("SELECT * FROM t_content_mms");
			$res = $q->execute();
			return $q->fetchAll();
		}

		public function getMmsContentById($id){
			$q = $this->dbConnection->prepare("SELECT * FROM t_content_mms WHERE content_id = :id");
			$q->bindParam(':id', $id, PDO::PARAM_STR, 10);
			$res = $q->execute();
			return $q->fetchAll();
		}
	}
?>
