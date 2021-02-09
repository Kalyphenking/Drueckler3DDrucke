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
			if(file_exists($_FILES['uploadFile']['tmp_name']) && is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {

				$file = $_FILES['uploadFile'];

//				echo json_encode($file) . '<br>';

				if ($this->loggedIn())
				{
					$uploadDir = UPLOADSPATH.$_SESSION['username'].DIRECTORY_SEPARATOR;

//					$fileName = $_SESSION['username'].'_'.trim(basename($_FILES['uploadFile']['name']), ' ');
					$fileName = $_SESSION['username'].'_'.str_replace(' ', '', basename($_FILES['uploadFile']['name']));
				} else {

					$uploadDir = UPLOADSPATH.'temp'.DIRECTORY_SEPARATOR;

//					$fileName = $_SESSION['uid'].'_'.trim(basename($_FILES['uploadFile']['name']), ' ');
					$fileName = $_SESSION['uid'].'_'.str_replace(' ', '', basename($_FILES['uploadFile']['name']));


				}

				$this->checkDirectory($uploadDir);

				$stlDir = $uploadDir.'stl'.DIRECTORY_SEPARATOR;

				$this->checkDirectory($stlDir);

//				echo $stlDir . '<br><br>';

				$uploadFile = $stlDir . $fileName;

				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $uploadFile)) {
//					echo 'Datei ist valide und wurde erfolgreich hochgeladen <br>';

//					echo "<script>saveGLB(\"$uploadFile\", \"$fileName\")</script>";

					$glbFileName = trim($fileName, 'stl') . 'glb';

					$_SESSION['gltfFileName'] = $glbFileName;
					echo "<script>startConversion(\"$uploadFile\", \"$fileName\")</script>";

					//TODO success message
//					$this->processModel();
				} else {
					echo 'Moglicherweise shit\n';
				}
			} else {
				echo 'no upload';
				echo '<br>';
			}
		}

		if (isset($_POST['submit'])) {

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

//		$output = shell_exec(SLICER);
//		echo "<pre>$output</pre>";

		$output = [];
//		$retvar = 0;
//
//		echo exec('Prusa_Slicer'.DIRECTORY_SEPARATOR.'test.sh', $output, $retvar) . '<br><br>';

//		echo shell_exec(SLICER) . '<br><br>';

//		$this->execInBackground(SLICER);


//		echo json_encode($output) . '<br>';
//		$output = shell_exec('pwd');
//		echo "<pre>$output</pre>";

		exec("php ".VIEWSPATH."order".DIRECTORY_SEPARATOR."processModel.php"." > /dev/null &");

//		echo SLICER;

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

		$_SESSION['filamentTypes'] = $types;
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