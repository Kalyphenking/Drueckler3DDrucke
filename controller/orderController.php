<?php

namespace DDDDD\controller;

use DDDDD\controller\functions\ChangePaymentData;
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

	//manages 3D Model configurator
	public function configurator($subAction) {

		if (!isset($_POST['submitCalculation']) && !isset($_POST['submitContinue']) && !isset($_POST['submitUpload'])) {

			// unsets all configuration related sessions
			unset($_SESSION['printTime']);
			unset($_SESSION['printPrices']);
			unset($_SESSION['infill']);
			unset($_SESSION['resolution']);
			unset($_SESSION['filamentColor']);
			unset($_SESSION['filamentColorCode']);
			unset($_SESSION['modelName']);
//			unset($_SESSION['shoppingCart']);
		}

		if (isset($_POST['submitUpload'])) {
			$this->saveModel();
		}

		if (isset($_POST['submitCalculation'])) {
			$this->recallModel();
			$this->calculateModel();
		}

		if (isset($_POST['submitContinue'])) {
			$this->recallModel();
			$this->saveConfiguration();
		}

		if (!isset($_SESSION['filaments']) || empty($_SESSION['filaments']) || empty($this->filaments)) {
//			echo 'request <br>';
			$this->loadFilaments();
		}

	}

	protected function saveModel() {
		if (isset($_FILES['uploadFile']) && !empty($_FILES['uploadFile']))
		{
			if(file_exists($_FILES['uploadFile']['tmp_name']) && is_uploaded_file($_FILES['uploadFile']['tmp_name'])) {
				$modelName = basename($_FILES['uploadFile']['name']);
				$modelName = str_replace(' ', '', $modelName);
				$modelName = substr($modelName, 0, strlen($modelName) - 4);
				$_SESSION['modelName'] = $modelName;
				$modelName .= '-00';

				//if the user is not loggedin, the model will stored in a directory with the current uid

				if ($this->loggedIn())
				{
					$uploadsDir = UPLOADSPATH.$_SESSION['username'].DIRECTORY_SEPARATOR;
				} else {
					$uploadsDir = UPLOADSPATH.'temp'.DIRECTORY_SEPARATOR;
					$this->makeDirectory($uploadsDir);
					$uploadsDir .= $_SESSION['uid'] . DIRECTORY_SEPARATOR;
				}

				$fileName = $modelName . '.stl';

				$_SESSION['userDirectory'] = $uploadsDir;
				$stlDir = $uploadsDir.'stl'.DIRECTORY_SEPARATOR;
				$glbDir = $uploadsDir.'glb'.DIRECTORY_SEPARATOR;

				$this->makeDirectory($uploadsDir);
				$this->makeDirectory($stlDir);
				$this->makeDirectory($glbDir);

				$stlFile = $stlDir . $fileName;

				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $stlFile)) {

//					$glbFileName = trim($fileName, 'stl') . 'glb';
////
//					$_SESSION['glbFileName'] = DIRECTORY_SEPARATOR.$uploadsDir.'glb'.DIRECTORY_SEPARATOR.$glbFileName;
//
//					echo "glbFileName: $glbFileName <br>";

					echo "<script>startConversion(\"$uploadsDir\", \"$modelName\", \"150,150,150,1\")</script>";

					//TODO success message
//					$this->processModel();
				} else {
					echo 'Moglicherweise shit\n';
				}

			} else {
				//TODO: noUploadHandling
				echo 'no upload';
				echo '<br>';
			}
		}
	}

	//recalls newest model in directory to display in ModelViewer
	protected function recallModel() {
		if ((isset($_SESSION['userDirectory']) && isset($_SESSION['modelName']))) {
			$directory = $_SESSION['userDirectory'].'glb';

			$files = scandir($directory, SCANDIR_SORT_DESCENDING);

			$fileName = 'uploads/default/glb/3DModelHochladen.glb';

//			echo "file: $fileName <br>";

			foreach ($files as $file) {
//				echo "file loop: $file <br>";
//				echo "file session: ".$_SESSION['modelName']." <br>";
				$found = strpos($file, $_SESSION['modelName']);
				if ($found !== false) {
					$newest_file = $file;
//					echo "found file: $file <br>";
					$fileName = $directory . DIRECTORY_SEPARATOR . $newest_file;
				}
			}

//			echo "file: $fileName <br>";


			//$_SESSION['testDone'] = $file;
			$_SESSION['glbFile'] = $fileName; // Fehler
//				echo "file: " . $_SESSION['modelName'] . "<br>";
//				echo "file: $file";

			echo "<script>displayModel(\"$fileName\")</script>";
		};
	}

	protected function makeDirectory($directory) {
		if (!file_exists($directory)) {
			mkdir($directory, 0777);
			chmod($directory, 0777);
		}
	}

	protected function calculateModel() {

		if (!empty($_POST['infill'] && isset($_SESSION['modelName']))
			&& !empty($_POST['resolution'])
			&& !empty($_POST['filament'])) {


			$infill = $_POST['infill'];
			$resolution = $_POST['resolution'];
			$filamentColor = $_POST['filament'];

			$userDirectory = $_SESSION['userDirectory'];
			$modelName = $_SESSION['modelName'];

			echo $modelName;

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

		if(isset($_SESSION['modelName'])) {
			$this->calculateModel();
			$this->appendToShoppingCart();
			$link = 'index.php?c=order&a=shoppingCart';

			header("Location: $link ");
		} else {
			//TODO: errorHandling
			echo "no Model selected <br>";
		}
	}

	protected function appendToShoppingCart() {
		$orderModelName = $_SESSION['modelName'];
		$orderInfill = $_SESSION['infill'];
		$orderResolution = $_SESSION['resolution'];
		$filamentColor = $_SESSION['filamentColor'];
		$orderPrintTime = $_SESSION['printTime'];
		$orderPrice = $_SESSION['printPrices'][0];
		$file = $_SESSION['glbFile'];

//		echo "modelName: $orderModelName <br>";
//		echo "infill: $orderInfill <br>";
//		echo "resolution: $orderResolution <br>";
//		echo "filamentColor: $filamentColor <br>";
//		echo "printTime: $orderPrintTime <br>";
//		echo "printPrices: $orderPrice <br>";
//		echo "glbFile: $file <br>";

		$shoppingCartItem = [$orderModelName, $orderInfill, $orderResolution, $filamentColor, $orderPrintTime, $orderPrice, $file];

		//cheks wether shoppingCartItem is already in shoppingCart
		if (isset($_SESSION['shoppingCart'])) {

			$shoppingCart = $_SESSION['shoppingCart'];
			$inShoppingCart = false;

			foreach ($shoppingCart as $item) {
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
			$_SESSION['shoppingCart'][] = $shoppingCartItem;
		}

//		foreach ($_SESSION['shoppingCart'] as $item) {
//			echo json_encode($item) . '<br>';
//		}


	}

	protected function removeFromShoppingCart() {
		$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];
		foreach ($shoppingCart as $key => $item) {
			if (isset($_POST[$key])) {
				array_splice($shoppingCart, $key, 1);
			}
		}
		$_SESSION['shoppingCart'] = $shoppingCart;
	}

	//manages shoppinCart
	public function shoppingCart() {
		if (isset($_POST['submit'])) {
			$link = 'index.php?c=order&a=checkout';
			header("Location: $link ");
		}

		if (isset($_POST['submitDelete'])) {
			$this->removeFromShoppingCart();
		}
	}

	public function checkout($subaction) {

		echo $subaction . '<br>';

		if (!$this->loggedIn()) {
			$_SESSION['makeOrder'] = true;
			$link = 'index.php?c=main&a=login';
			header("Location: $link ");
		} else {
			$customerData = $this->loadUserData();

			if (!isset($customerData['aid']) ) {
				$GLOBALS['currentView'] = 'addressData';
			}
			else if (!isset($customerData['pdid'])) {
				echo 'PAYMENTDATA <br>';

				$paymentData = new ChangePaymentData();
				$paymentData->changePaymentData($subaction);
				$GLOBALS['currentView'] = 'paymentData';
			}
		}
	}

	//manages orders
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

//		if (!isset($_SESSION['customerData']) || empty($_SESSION['customerData'])) {

//		}

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
				'pd.Paypal_id as ppid'

			],

			['username'],

			[$username]);
		$_SESSION['customerData'] = $loadedData[0];

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

		return $_SESSION['customerData'];
	}

	protected function loadFilaments() {
		$filaments = Filament::find();

        $this->filaments = $filaments;

		$columns = array_column($filaments, 'type');
		array_multisort($columns, SORT_ASC, $filaments);


		$types = array_count_values($columns);

		$_SESSION['filaments'] = $filaments;
	}

	//manages presets
	public function presets() {
		$this->loadPresets();

		echo 'preset: <br>' . json_encode($_SESSION['presets']) . '<br><br>';


	}

	//loads and saves printSettings in sessin with filled preset attribute
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



}