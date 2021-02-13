<?php

$error = "";

$myfile = fopen("/Applications/XAMPP/xamppfiles/htdocs/Drueckler3DDrucke/log/stlErrors.txt", "w") or die("Unable to open file!");

if (isset($_FILES['file']) && !empty($_FILES['file']))
{
	if(file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

		$fileName = trim($_POST['fileName'], '"');

		$txt = 'fileName: '.$fileName . "\n\n";
		fwrite($myfile, $txt);


		$glbDirectory = substr($fileName, 0, strpos($fileName, 'glb')+3);

		$txt = 'glbDirectory: '.$glbDirectory . "\n\n";
		fwrite($myfile, $txt);

		$files = scandir('..'.DIRECTORY_SEPARATOR.$glbDirectory, SCANDIR_SORT_NONE);
//		$newest_file = $files[0];

		$modelName = substr($fileName, strlen($glbDirectory) + 1);

		$modelName = substr($modelName, 0, strlen($modelName) - 7);

		$txt = 'modelName: ' .$modelName. "\n\n";
		fwrite($myfile, $txt);

		foreach ($files as $file) {
			$extensiont = substr($file, strlen($file) - 3, 3);
			$baseName = substr($file, 0, strlen($file)-7);

			$txt = 'baseName: ' .$baseName. "\n\n";
			fwrite($myfile, $txt);

			$deleteName = trim($file, '"');


			if (($extensiont == 'glb') && ($modelName === $baseName)) {
				$txt = 'deleteName: ' .$deleteName. "\n\n";
				fwrite($myfile, $txt);
				unlink('..'.DIRECTORY_SEPARATOR.$glbDirectory.DIRECTORY_SEPARATOR.$deleteName);
			}


		}


		if (move_uploaded_file($_FILES['file']['tmp_name'], '..'.DIRECTORY_SEPARATOR.$fileName)) {
			$txt = 'saved' . "\n\n";
			fwrite($myfile, $txt);
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


$txt = 'works' . "\n\n";
fwrite($myfile, $txt);

fclose($myfile);