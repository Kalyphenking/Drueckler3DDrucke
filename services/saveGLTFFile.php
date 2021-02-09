<?php

$error = "";

$myfile = fopen("/Applications/XAMPP/xamppfiles/htdocs/Drueckler3DDrucke/log/stlErrors.txt", "w") or die("Unable to open file!");

if (isset($_FILES['file']) && !empty($_FILES['file']))
{
	if(file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

		$fileName = trim($_POST['fileName'], '"');

		$savePath = '..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.'glb'.DIRECTORY_SEPARATOR;

		if (!file_exists($savePath)) {
			mkdir($savePath, 0777);
			chmod($savePath, 0777);
		}

		$uploadFile = $savePath . $fileName;

		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {

		} else {
			echo 'Moglicherweise shit\n';
			$error .= 'Moglicherweise shit\n';
		}
	} else {
		$error .= 'no upload\n';
		echo 'no upload';
		echo '<br>';
	}
}



$txt = json_encode($_FILES['file']) . "\n\n";
fwrite($myfile, $txt);
$txt = $error . "\n\n";
fwrite($myfile, $txt);
fclose($myfile);