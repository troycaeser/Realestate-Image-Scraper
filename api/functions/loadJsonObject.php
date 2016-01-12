
<?php
	function get_json_object ($agency_localDir) {
		// $jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/agentJson/";
		$jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentJson/";
		
		$jsonDir .= $agency_localDir;
		$jsonDir .= "/m.json";

		$jsonString = file_get_contents ($jsonDir);
		$jsonObject = json_decode ($jsonString, true);

		return $jsonObject;
	}
?>