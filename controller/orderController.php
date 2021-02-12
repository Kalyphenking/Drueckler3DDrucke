<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Filament;
use DDDDD\model\Pricing;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	protected $filaments = null;

	public function configurator($subAction) {

		if (!isset($_POST['submitCalculation']) && !isset($_POST['submitContinue']) && !isset($_POST['submitUpload'])) {
			echo "<h1>DELETE</h1>";
			$_SESSION['printTime'] = null;
			$_SESSION['printPrices'] = null;
			$_SESSION['infill'] = null;
			$_SESSION['resolution'] = null;
			$_SESSION['filamentColor'] = null;
			$_SESSION['filamentColorCode'] = null;
			$_SESSION['modelName'] = null;
		}

		if (isset($_FILES['uploadFile']) && !empty($_FILES['uploadFile']))
		{

//			echo 'fileExits <br>';

			if(file_exists($_FILES['uploadFile']['tmp_name']) && is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {

				$modelName = basename($_FILES['uploadFile']['name']);
				$modelName = str_replace(' ', '', $modelName);
				$modelName = substr($modelName, 0, strlen($modelName) - 4);
				$_SESSION['modelName'] = $modelName;
				$modelName .= '-00';

//				echo "modelName: ".substr($modelName, 0, strlen($modelName) - 4)."<br>";

//				echo "modelName: $modelName<br>";

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

//				echo "modelName: $modelName<br>";
//				echo "uploadsDir: $uploadsDir<br>";
//				echo "fileName: $fileName<br>";

				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $stlFile)) {

//					$glbFileName = trim($fileName, 'stl') . 'glb';
//
//					$_SESSION['glbFileName'] = DIRECTORY_SEPARATOR.$uploadsDir.'glb'.DIRECTORY_SEPARATOR.$glbFileName;


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


			if ((isset($_SESSION['userDirectory']) && isset($_POST['submitCalculation']) || isset($_POST['submitContinue']))) {
				$directory = $_SESSION['userDirectory'].'glb';

				$files = scandir($directory, SCANDIR_SORT_DESCENDING);
				$newest_file = $files[0];

//				echo json_encode($directory . DIRECTORY_SEPARATOR . $newest_file);

				$file = $directory . DIRECTORY_SEPARATOR . $newest_file;

				echo "<script>displayModel(\"$file\")</script>";
			};
		}

		if (isset($_POST['submitCalculation'])) {
			$this->processModel();
		}

		if (isset($_POST['submitContinue'])) {
			$this->saveConfiguration();
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


//		if (!empty($_POST['infill'])) {
//			echo "infill <br>";
//		}
//		if (!empty($_POST['resolution'])) {
//			echo "resolution <br>";
//		}
//		if (!empty($_POST['filament'])) {
//			echo "filament <br>";
//		}

		if (!empty($_POST['infill'])
			&& !empty($_POST['resolution'])
			&& !empty($_POST['filament'])) {


			$infill = $_POST['infill'];
			$resolution = $_POST['resolution'];
			$filamentColor = $_POST['filament'];

//			echo "resolution $resolution<br>";

			$userDirectory = $_SESSION['userDirectory'];
			$modelName = $_SESSION['modelName'];
			$file = $userDirectory.'stl'.DIRECTORY_SEPARATOR.$modelName.'-00.stl';

			$fileSize = filesize($file);



			$baseTime = 0.25;
			$size = $fileSize / 300000;

			$printTime =($baseTime + $size + ($infill/50)) + (($size / ($resolution + 0.0)));


			$_SESSION['printTime'] = round($printTime,2);


			$pricing = Pricing::find()[0];

//			echo json_encode($pricing) . '<br>';

			$shippting = $pricing['shipping'];
			$workPerHour = $pricing['workPerHour'];
			$energyPerHour = $pricing['energyPerHour'];
			$taxes = $pricing['taxes'];
			$grammsPerHour = $pricing['grammsPerHour'];
			$filaments = $_SESSION['filaments'];

			foreach ($filaments as $filament) {
				if ($filament['rgba'] == $filamentColor) {
					$pricerPerGramm = $filament['pricePerGramm'];
					$_SESSION['filamentId'] = $filament['id'];
					$_SESSION['filamentColor'] = $filament['type'].': '.$filament['color'];
					$_SESSION['filamentColorCode'] = $filament['rgba'];
				}
			}

//			echo "shipping $shippting<br>";
//			echo "workPerHour $workPerHour<br>";
//			echo "energyPerHour $energyPerHour<br>";
//			echo "taxes $taxes<br>";
//			echo "grammsPerHour $grammsPerHour<br>";
//			echo "pricePerGramm $pricerPerGramm<br>";




			$materialPrice = $printTime * $pricerPerGramm * $grammsPerHour;
			$workPrice = $printTime * $workPerHour;
			$energyPrice = $printTime * $energyPerHour;

			$taxesPrice = ($materialPrice + $workPrice + $energyPrice + $shippting) * $taxes;

			$printPrice = $energyPerHour + $workPrice + $energyPrice + $shippting + $taxesPrice;
//			echo "<br><br>";
//			echo "materialPrice $materialPrice<br>";
//			echo "shippting $shippting<br>";
//			echo "workPrice $workPrice<br>";
//			echo "energyPrice $energyPrice<br>";
//			echo "taxesPrice $taxesPrice<br>";
//			echo "printPrice $printPrice<br>";



			$_SESSION['printPrices'][0] = round($printPrice, 2);
			$_SESSION['printPrices'][1] = round($energyPerHour, 2);
			$_SESSION['printPrices'][2] = round($workPrice, 2);
			$_SESSION['printPrices'][3] = round($energyPrice, 2);
			$_SESSION['printPrices'][4] = round($shippting, 2);
			$_SESSION['printPrices'][5] = round($taxesPrice, 2);
			$_SESSION['infill'] = $infill;
			$_SESSION['resolution'] = $resolution;





		}


	}

	protected function saveConfiguration() {

	}

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