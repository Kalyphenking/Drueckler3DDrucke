<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Filament;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	protected $filaments = NULL;

	public function configurator($subAction) {

		if (isset($_FILES['uploadFile']) && !empty($_FILES['uploadFile']))
		{
			echo 'fileExits <br>';

			if(file_exists($_FILES['uploadFile']['tmp_name']) && is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {

				$modelName = basename($_FILES['uploadFile']['name']);
				$modelName = substr($modelName, 0, strlen($modelName) - 4) . '-00';
				$modelName = str_replace(' ', '', $modelName);

//				echo "modelName: ".substr($modelName, 0, strlen($modelName) - 4)."<br>";

				echo "modelName: $modelName<br>";

				if ($this->loggedIn())
				{
					$uploadsDir = UPLOADSPATH.$_SESSION['username'].DIRECTORY_SEPARATOR;
					$fileName = $_SESSION['username'].'_'.$modelName.'.stl';
				} else {

					$uploadsDir = UPLOADSPATH.'temp'.DIRECTORY_SEPARATOR;
					$this->checkDirectory($uploadsDir);
					$uploadsDir .= $_SESSION['uid'] . DIRECTORY_SEPARATOR;
					$fileName = $modelName . '.stl';
				}

				$_SESSION['userDirectory'] = $uploadsDir;
				$stlDir = $uploadsDir.'stl'.DIRECTORY_SEPARATOR;
				$glbDir = $uploadsDir.'glb'.DIRECTORY_SEPARATOR;

				$this->checkDirectory($uploadsDir);
				$this->checkDirectory($stlDir);
				$this->checkDirectory($glbDir);


				$stlFile = $stlDir . $fileName;

//				echo "stlDir: $stlDir<br>";
//				echo "uploadsDir: $uploadsDir<br>";
//				echo "fileName: $fileName<br>";

				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $stlFile)) {

//					$glbFileName = trim($fileName, 'stl') . 'glb';
//
//					$_SESSION['glbFileName'] = DIRECTORY_SEPARATOR.$uploadsDir.'glb'.DIRECTORY_SEPARATOR.$glbFileName;
					$_SESSION['modelName'] = $modelName;

					echo "<script>startConversion(\"$uploadsDir\", \"$modelName\", \"150,150,150,1\")</script>";

					//TODO success message
//					$this->processModel();
				} else {
					echo 'Moglicherweise shit\n';
				}
			} else {
				echo 'no upload';
				echo '<br>';
			}
		} else {
//
////			uploads/temp/6025b4e724fc8/glb/TestCubewithhole10x10x10mm-73.glb
//
////			if (isset($_SESSION['userDirectory'])) {
////				echo "da1 <br>";
////			}
////			if (isset($_POST['submit'])) {
////				echo "da2 <br>";
////			}
//
//			if (isset($_SESSION['userDirectory']) && isset($_POST['submit'])) {
//				$directory = $_SESSION['userDirectory'].'glb';
//
//				$files = scandir($directory, SCANDIR_SORT_DESCENDING);
//				$newest_file = $files[0];
//
//				echo json_encode($directory . DIRECTORY_SEPARATOR . $newest_file);
//
//				$file = $directory . DIRECTORY_SEPARATOR . $newest_file;
//
//				echo "<script>displayModel(\"$file\")</script>";
//			};
		}

		if (isset($_POST['submit'])) {
			$this->processModel();
		}


		if (!isset($_SESSION['filaments']) || empty($_SESSION['filaments']) || empty($this->filaments)) {
//			echo 'request <br>';
			$this->loadFilaments();
		}

	}

	protected function checkDirectory($directory) {
		if (!file_exists($directory)) {
			mkdir($directory, 0777);
			chmod($directory, 0777);
		}
	}

	protected function processModel() {
		if (!empty($_POST['infill'])
			&& !empty($_POST['resolution'])
			&& !empty($_POST['filament'])) {

			echo $_POST['infill'] . '<br>';
			echo $_POST['resolution'] . '<br>';
			echo $_POST['filament'] . '<br>';

			$infill = $_POST['infill'];
			$resolution = $_POST['resolution'];
			$filament = $_POST['filament'];


			$userDirectory = $_SESSION['userDirectory'];
			$modelName = $_SESSION['modelName'];
			$file = $userDirectory.'stl'.DIRECTORY_SEPARATOR.$modelName.'.stl';

			$fileSize = filesize($file);

			$printPrice = $fileSize / 100000 + 5;

			echo "fileSize: $fileSize <br>";


			$printTime = (($fileSize / 60 / 60 / 60 / 24 + 0.1) * (2 / $resolution)) + ($infill / 100);

			$printTime = round($printTime, 2);

			$_SESSION['printTime'] = $printTime;
			$_SESSION['printPrices'] = $printPrice;

			echo $userDirectory.'stl'.DIRECTORY_SEPARATOR.$modelName;

		}


	}

	protected function execInBackground($cmd) {
		if (substr(php_uname(), 0, 7) == "Windows"){
			pclose(popen("start /B ". $cmd, "r"));
		}
		else {
			exec($cmd . " > /dev/null &");
		}
	}

//	protected function convert($file, $filePath) {
//
//		$postUrl = '"https://myminifactory.github.io/stl2gltf/"';
//		$fieldName = '"fileuploadform"';
//
//		echo '<script>',
//		"upload($postUrl, $fieldName, $filePath)",
////		"test($postUrl, $fieldName, $filePath);",
//		'</script>'
//		;
//
//		echo 'uploaded <br>';
//	}

	protected function calculateModel() {
		$infill = isset($_POST['infill']) ? $_POST['infill'] : 0.7;
		$resolution = isset($_POST['resolution']) ? $_POST['resolution'] : 0.2;
		$filament = isset($_POST['filament']) ? $this->filaments[$_POST['filament']] : $this->filaments[0];

//		echo 'infill: ' . $infill;
//		echo '<br>';
//		echo 'resolution: ' . $resolution;
//		echo '<br>';
//		echo 'filament: ' . json_encode($filament);
//		echo '<br>';



	}

	protected function loadFilaments() {



		$filaments = Filament::find();

        $this->filaments = $filaments;

		$columns = array_column($filaments, 'type');
		array_multisort($columns, SORT_ASC, $filaments);


		$types = array_count_values($columns);

//		echo json_encode($types) . '<br>';
//		echo json_encode($columns) . '<br>';

//		$_SESSION['filamentTypes'] = $types;
		$_SESSION['filaments'] = $filaments;
	}

	protected function sortArray($array, $arrayKey) {
		foreach ($array as $key => $row) {
			$band[$key]    = $row['Band'];
			$auflage[$key] = $row['Auflage'];
		}
	}




	public function presets() {
		$this->loadPresets();




		echo 'preset: <br>' . json_encode($_SESSION['presets']) . '<br><br>';


	}

	protected function loadPresets() {
		$data = PrintSettings::find();
		$presets = [];

		foreach($data as $key => $preset) {
			if (!empty($preset['description'])) {
				$presets[] = $preset;
			}
		}

		$_SESSION['presets'] = $presets;
	}

	protected function loadPricing() {
		return 'KLAPPT';
	}


}