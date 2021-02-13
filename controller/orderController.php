<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Customer;
use DDDDD\model\Filament;
use DDDDD\model\Model;
use DDDDD\model\Orders;
use DDDDD\model\Pricing;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	protected $filaments = null;
	protected $errors = [];

	public function configurator($subAction) {

		if (!isset($_POST['submitCalculation']) && !isset($_POST['submitContinue']) && !isset($_POST['submitUpload'])) {
			$_SESSION['printTime'] = null;
			$_SESSION['printPrices'] = null;
			$_SESSION['infill'] = null;
			$_SESSION['resolution'] = null;
			$_SESSION['filamentColor'] = null;
			$_SESSION['filamentColorCode'] = null;
			$_SESSION['modelName'] = null;
//			$_SESSION['shoppingCart'] = null;
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
				} else {
					$uploadsDir = UPLOADSPATH.'temp'.DIRECTORY_SEPARATOR;
					$this->checkDirectory($uploadsDir);
					$uploadsDir .= $_SESSION['uid'] . DIRECTORY_SEPARATOR;
				}

				$fileName = $modelName . '.stl';



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

				$file = $directory . DIRECTORY_SEPARATOR . $newest_file;

				$_SESSION['testDone'] = $file;
				$_SESSION['glbFile'] = $file; // Fehler

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

		if (!empty($_POST['infill'])
			&& !empty($_POST['resolution'])
			&& !empty($_POST['filament'])) {


			$infill = $_POST['infill'];
			$resolution = $_POST['resolution'];
			$filamentColor = $_POST['filament'];

			$userDirectory = $_SESSION['userDirectory'];
			$modelName = $_SESSION['modelName'];
			$file = $userDirectory.'stl'.DIRECTORY_SEPARATOR.$modelName.'-00.stl';

			$fileSize = filesize($file);

			$baseTime = 0.25;
			$size = $fileSize / 300000;

			$printTime =($baseTime + $size + ($infill/50)) + (($size / ($resolution + 0.0)));

			$_SESSION['printTime'] = round($printTime,2);

			$pricing = Pricing::find()[0];


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
			$materialPrice = $printTime * $pricerPerGramm * $grammsPerHour;
			$workPrice = $printTime * $workPerHour;
			$energyPrice = $printTime * $energyPerHour;

			$taxesPrice = ($materialPrice + $workPrice + $energyPrice + $shippting) * $taxes;

			$printPrice = $energyPerHour + $workPrice + $energyPrice + $shippting + $taxesPrice;

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

		$this->processModel();

		$link = 'index.php?c=order&a=shoppingCart';

		header("Location: $link ");

	}

	public function shoppingCart() {

		if (isset($_SESSION['testDone'])) {
			echo $_SESSION['testDone'] . "<br>";
			echo "DONE <br>";
		}

		if (isset($_POST['submitContinue'])) {
			echo "<h3>submitContinue</h3><br><br>";
		}

		$orderModelName = $_SESSION['modelName'];
		$orderInfill = $_SESSION['infill'];
		$orderResolution = $_SESSION['resolution'];
		$filamentColor = $_SESSION['filamentColor'];
		$orderPrintTime = $_SESSION['printTime'];
		$orderPrice = $_SESSION['printPrices'][0];
		$file = $_SESSION['glbFile'];

		$shoppingCartItem = [$orderModelName, $orderInfill, $orderResolution, $filamentColor, $orderPrintTime, $orderPrice, $file];
		$shoppingCart = $_SESSION['shoppingCart'];

		echo json_encode($shoppingCartItem);
		echo '<br><br>';

		echo $_SESSION['glbFile'];

		$inShoppingCart = false;
		echo '<br><br>';
		if ($shoppingCart) {
			echo "shoppingCart";
			echo '<br><br>';
			foreach ($shoppingCart as $item) {
				echo json_encode($item);
				echo '<br><br>';

				if (($item[0] == $shoppingCartItem[0])
					&& ($item[1] == $shoppingCartItem[1])
					&& ($item[2] == $shoppingCartItem[2])
					&& ($item[3] == $shoppingCartItem[3])
					&& ($item[4] == $shoppingCartItem[4])
					&& ($item[5] == $shoppingCartItem[5])
					&& ($item[6] == $shoppingCartItem[6])
				) {

					$inShoppingCart = true;
				}

			}
			if (!$inShoppingCart) {
				$_SESSION['shoppingCart'][] = $shoppingCartItem;
			}

		} else {
			echo "no shoppingCart";
			$_SESSION['shoppingCart'][] = $shoppingCartItem;
		}



	}

	public function makeOrder() {
		if (!$this->loggedIn()) {
			$_SESSION['makeOrder'] = true;
			$link = 'index.php?c=main&a=login';

			header("Location: $link ");
		} else {
			if (isset($_POST['submit'])) {
				$orderPrice = $_SESSION['printPrices'][0];
				$orderInfill = $_SESSION['infill'];
				$orderResolution = $_SESSION['resolution'];
				$orderFilamentId = $_SESSION['filamentId'];
				$orderPrintTime = round($_SESSION['printTime']);
				$orderModelName = $_SESSION['modelName'];

				$userData = $this->loadUserData();

				$order = new Orders(['Customer_id'=>$userData['cid'],
					'price'=>$orderPrice]);

				$printSettings = new PrintSettings(['resolution'=>$orderResolution, 'infill'=>$orderInfill]);

				$models = new Model(['fileName'=>$orderModelName, 'modelPrice'=>$orderPrice]);



				$printSettings->insert($this->errors);
				$models->insert($this->errors);

				$printSettingsId = $models->find(['resolution', 'infill'], [$orderResolution, $orderInfill])[0]['id'];
				$modelId = $models->find(['fileName'], [$orderModelName])[0]['id'];



				$order->insert($this->errors, ['INSERT INTO PrintConfig (Orders_id, Filaments_id, Models_id, PrintSettings_id, printTime)	
								VALUES (LAST_INSERT_ID(),'.$orderFilamentId.', '.$modelId.', '.$printSettingsId.', '.$orderPrintTime.')']);

//				echo json_encode($_SESSION['customerData']) . '<br>';
			}
		}
	}

	protected function loadUserData() {
		$username = $_SESSION['username'];

		if (!isset($_SESSION['customerData'])) {
			$loadedData = Customer::findOnJoin(
				'contactData',
				[
					'c.id as cid',

					'cd.firstName',
					'cd.lastName',
					'cd.phoneNumber',
					'cd.emailAddress',
					'cd.username',
					'cd.id as cdid',

					'a.id as aid',
					'a.street',
					'a.number',
					'a.postalCode',
					'a.city',
					'a.country',

					'pd.preferedPaymentMethod',
					'pd.id as pdid',
					'pd.CreditCard_id as ccid',
					'pd.DirectDebit_id as ddid',
					'pd.Bill_id as blid',
					'pd.Paypal_id as ppid'

				],

				['username'],

				[$username]);


//			echo json_encode($loadedData[0]) . '<br><br>';
			$_SESSION['customerData'] = $loadedData[0];
		}

		$preferedPaymentMethod = $_SESSION['customerData']['preferedPaymentMethod'];

		switch ($preferedPaymentMethod) {
			case 'dd':
				$actionName = 'setDirectDebit';
				$displayedName = 'Lastschrift';
				break;
			case 'cc':
				$actionName = 'setCreditCard';
				$displayedName = 'Kreditkarte';
				break;
			case 'bl':
				$actionName = 'setBill';
				$displayedName = 'Rechnung';
				break;
			case 'pp':
				$actionName = 'setPayPal';
				$displayedName = 'PayPal';
				break;
			default:
				$actionName = 'setDirectDebit';
				$displayedName = 'Nicht hinterlegt';
				break;
		}

		$GLOBALS['preferedPaymentMethod'] = $displayedName;
		$GLOBALS['selectedPaymentMethod'] = $actionName;

		return $loadedData[0];
	}


	protected function loadFilaments() {
		$filaments = Filament::find();

        $this->filaments = $filaments;

		$columns = array_column($filaments, 'type');
		array_multisort($columns, SORT_ASC, $filaments);


		$types = array_count_values($columns);

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