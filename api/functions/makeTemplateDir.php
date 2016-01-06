<?php
	function makeTemplateDir ($propertyInfo, &$templateDir, &$templateDirWeb) {
		// $propertyDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/agentAssets/";
		$propertyDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentAssets/";
		
		//$propertyDir = "../assets/agentAssets/";
		
		$propertyDir .= $propertyInfo['agency_localDir'];
		$propertyDir .= '/';

		$templateDir = array (
			'root' => $propertyDir,
			'Banner' => $propertyDir . "banner.png",
			'Bath' => $propertyDir . "bath.png",
			'Bed' => $propertyDir . "bed.png",
			'Bottom' => $propertyDir . "bottom.png",
			'Car' => $propertyDir . "car.png",
			'Font' => $propertyDir . "font.ttf",
			'Logo' => $propertyDir . "logo.png"
		);

		$propertyDir = "/api/assets/agentAssets/";
		
		//$propertyDir = "../assets/agentAssets/";
		
		$propertyDir .= $propertyInfo['agency_localDir'];
		$propertyDir .= '/';

		$templateDirWeb = array (
			'root' => $propertyDir,
			'Banner' => $propertyDir . "banner.png",
			'Bath' => $propertyDir . "bath.png",
			'Bed' => $propertyDir . "bed.png",
			'Bottom' => $propertyDir . "bottom.png",
			'Car' => $propertyDir . "car.png",
			'Font' => $propertyDir . "font.ttf",
			'Logo' => $propertyDir . "logo.png"
		);
	}
?>
