<?php
$ds = DIRECTORY_SEPARATOR;
	if (!empty ($_FILES)) {
		$tempFile = $_FILES['file']['tmp_name'];
		$targetPath = '{$_SERVER['DOCUMENT_ROOT']}/api/assets/testUpload/';
		$targetFile = $targetPath.$_FILES['file']['name'];
		move_uploaded_file ($tempFile, $targetFile);
	}
?>