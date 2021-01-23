<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Filament;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	protected $filaments = NULL;

	public function configurator() {


		if (isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload']))
		{
			if(file_exists($_FILES['fileToUpload']['tmp_name']) && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {

				$file = $_FILES['fileToUpload'];

//				echo json_encode($file) . '<br>';

				if ($this->loggedIn())
				{
					if (!file_exists(UPLOADPATH.$_SESSION['username'])) {
						mkdir(UPLOADPATH.$_SESSION['username'], 0777);
					}

					$uploadDir = UPLOADPATH.$_SESSION['username'].DIRECTORY_SEPARATOR.$_SESSION['username'].'_';
				} else {

					if (!file_exists(UPLOADPATH.'temp')) {
						mkdir(UPLOADPATH.'temp', 0777);
					}
					$uploadDir = UPLOADPATH.'temp'.DIRECTORY_SEPARATOR.$_SESSION['uid'].'_';
				}

				$uploadFile = $uploadDir . basename($_FILES['fileToUpload']['name']);

				if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
					echo 'Datei ist valide und wurde erfolgreich hochgeladen <br>';
					$this->processModel();
				} else {
					echo 'Moglicherweise shit\n';
				}
			} else {
				echo 'no upload';
				echo '<br>';
			}
		}



		if (!isset($GLOBALS['filaments']) || empty($GLOBALS['filaments']) || empty($this->filaments)) {
//			echo 'request <br>';
			$this->loadFilaments();
		}

	}

	function processModel() {

		$output = shell_exec(SLICER);
		echo "<pre>$output</pre>";

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

		$GLOBALS['filamentTypes'] = $types;
		$GLOBALS['filaments'] = $filaments;
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