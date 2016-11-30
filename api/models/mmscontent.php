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

		public function getMmsContentById($contentId){
			$q = $this->dbConnection->prepare("SELECT * FROM t_content_mms WHERE content_id = :id");

			$final = array();
			$replacement = array();

			$q->bindParam(':id', $contentId, PDO::PARAM_STR, 10);
			$q->execute();

			foreach($q->fetchAll() as $record){
				$record['txt_file'] = $this->convertTxt($record['txt_file']);
				$record[3] = $this->convertTxt($record[3]);
				array_push($final, $record);
			}

			return $final;
		}

		public function convertTxt($path){
            if(isset($path)){
                $full = 'http://localhost:3000/api/'.$path;
                $txtString = file_get_contents($full);
                return $txtString;
            }
		}
	}
?>
