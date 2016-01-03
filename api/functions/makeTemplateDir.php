<?php
	function makeTemplateDir ($url, $propertyInfo, &$templateDir) {
		$propertyDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentAssets/";
		//$propertyDir = "../assets/agentAssets/";
		
		$propertyDir .= $propertyInfo['agency_localDir'];
		$propertyDir .= '/';

		$templateDir = array (
			'banner' => $propertyDir . "banner.png",
			'bath' => $propertyDir . "bath.png",
			'bed' => $propertyDir . "bed.png",
			'bottom' => $propertyDir . "bottom.png",
			'car' => $propertyDir . "car.png",
			'font' => $propertyDir . "font.ttf",
			'logo' => $propertyDir . "logo.png"
		);
	}
?>
