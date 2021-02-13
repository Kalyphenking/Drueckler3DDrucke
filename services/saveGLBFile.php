<?php

$error = "";


if (isset($_FILES['file']) && !empty($_FILES['file']))
{
	if(file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

		$fileName = trim($_POST['fileName'], '"');




		$glbDirectory = substr($fileName, 0, strpos($fileName, 'glb')+3);



		$files = scandir('..'.DIRECTORY_SEPARATOR.$glbDirectory, SCANDIR_SORT_NONE);
//		$newest_file = $files[0];

		$modelName = substr($fileName, strlen($glbDirectory) + 1);

		$modelName = substr($modelName, 0, strlen($modelName) - 7);



		foreach ($files as $file) {
			$extensiont = substr($file, strlen($file) - 3, 3);
			$baseName = substr($file, 0, strlen($file)-7);



			$deleteName = trim($file, '"');


			if (($extensiont == 'glb') && ($modelName === $baseName)) {

				unlink('..'.DIRECTORY_SEPARATOR.$glbDirectory.DIRECTORY_SEPARATOR.$deleteName);
			}


		}


		if (move_uploaded_file($_FILES['file']['tmp_name'], '..'.DIRECTORY_SEPARATOR.$fileName)) {

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

//$myfile = fopen("../log/stlErrors.txt", "w") or die("Unable to open file!");
//
//
//$txt = 'fileName: '.$fileName . "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'modelName: ' .$modelName. "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'glbDirectory: '.$glbDirectory . "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'baseName: ' .$baseName. "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'deleteName: ' .$deleteName. "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'saved' . "\n\n";
//fwrite($myfile, $txt);
//
//$txt = 'works' . "\n\n";
//fwrite($myfile, $txt);
//
//fclose($myfile);