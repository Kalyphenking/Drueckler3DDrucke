<?php
//C 3
namespace DDDDD\controller;

use DDDDD\controller\functions\ChangePaymentData;
use DDDDD\core\Controller;
use DDDDD\model\Customer;
use DDDDD\model\Filament;
use DDDDD\model\Model;
use DDDDD\model\Order;
use DDDDD\model\Pricing;
use DDDDD\model\PrintConfig;
use DDDDD\model\PrintSetting;


class OrderController extends Controller
{

	protected $filaments = null;
	protected $errors = [];
//C3_F1
	//manages 3D Model configurator
	public function configurator($subAction) {

		if (!isset($_POST['submitCalculation']) && !isset($_POST['submitContinue']) && !isset($_POST['submitUpload'])) {

			// unsets all configuration related sessions
			unset($_SESSION['printTime']);
			unset($_SESSION['printPrices']);
			unset($_SESSION['infill']);
			unset($_SESSION['resolution']);
			unset($_SESSION['filament']);
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
//C3_F2
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
					$uploadsDir = UPLOADSPATH.$_SESSION['username'].'/';
				} else {
					$uploadsDir = UPLOADSPATH.'temp'.'/';
					$this->makeDirectory($uploadsDir);
					$uploadsDir .= $_SESSION['uid'] . '/';
				}

				$fileName = $modelName . '.stl';

				$_SESSION['userDirectory'] = $uploadsDir;
				$stlDir = $uploadsDir.'stl'.'/';
				$glbDir = $uploadsDir.'glb'.'/';

				$this->makeDirectory($uploadsDir);
				$this->makeDirectory($stlDir);
				$this->makeDirectory($glbDir);

				$stlFile = $stlDir . $fileName;

				if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $stlFile)) {

					echo "<script>startConversion(\"$uploadsDir\", \"$modelName\", \"150,150,150,1\")</script>";

					//TODO success message
//					$this->processModel();
				} else {
					echo 'Moglicherweise shit Mist';
				}

			} else {
				//TODO: noUploadHandling
				echo 'no upload';
				echo '<br>';
			}
		} else {
			$_SESSION['error'] = 'Fehler: kein Model hochgeladen';
		}
	}
////C3_F3
	//recalls newest model in directory to display in ModelViewer
	protected function recallModel() {
		if ((isset($_SESSION['userDirectory']) && isset($_SESSION['modelName']))) {
			$directory = $_SESSION['userDirectory'].'glb';

			$files = scandir($directory, SCANDIR_SORT_DESCENDING);

			$fileName = 'uploads/default/glb/3DModelHochladen.glb';

			foreach ($files as $file) {
				$found = strpos($file, $_SESSION['modelName']);
				if ($found !== false) {
					$newest_file = $file;
					$fileName = $directory . '/' . $newest_file;
				}
			}

			$_SESSION['glbFile'] = $fileName; // Fehler

			echo "<script>displayModel(\"$fileName\")</script>";
		};
	}
//C3_F4
	//creates directory if is not exits
	protected function makeDirectory($directory) {
		if (!file_exists($directory)) {
			mkdir($directory, 0777);
			chmod($directory, 0777);
		}
	}
//C3_F5
	//calculates model based on userinput
	protected function calculateModel() {

		if (!empty(isset($_SESSION['modelName']))) {
			if (!empty($_POST['infill'])
				&& !empty($_POST['resolution'])
				&& !empty($_POST['filament'])
				&& !empty($_POST['amount'])) {


				$infill = $_POST['infill'];
				$resolution = $_POST['resolution'];
				$filamentColorCode = $_POST['filament'];
				$amount = $_POST['amount'];

				$userDirectory = $_SESSION['userDirectory'];
				$modelName = $_SESSION['modelName'];

//			echo $modelName;

				$file = $userDirectory.'stl'.'/'.$modelName.'-00.stl';

				$fileSize = filesize($file);

				$baseTime = 10;
				$size = $fileSize / 2500;


//			echo "<br>Size: ".$size."<br>";

				$faktor = 2.2;
				$summand = 1.4;
				$counter = 100;


				$printTime = pow(($counter/($infill*$size)), ($resolution*$faktor-$summand)) + $baseTime;


				$totalPrintTime = pow(($counter/($infill*$size)), ($resolution*$faktor-$summand)) * $amount + $baseTime;

				$_SESSION['printTime'] = round($totalPrintTime,2);

				$pricing = Pricing::find()[0];


				$shippting = $pricing['shipping'];
				$workPerGramm = $pricing['workPerGramm'];
				$energyPerHour = $pricing['energyPerHour'];
				$taxes = $pricing['taxes'];
				$grammsPerHour = $pricing['grammsPerHour'];
				$filaments = $_SESSION['filaments'];

				//vergessen was das macht
				foreach ($filaments as $filament) {
					if ($filament['rgba'] == $filamentColorCode) {
						$pricerPerGramm = $filament['pricePerGramm'];
						$_SESSION['filamentId'] = $filament['id'];
						$_SESSION['filamentColor'] = $filament['type'].': '.$filament['color'];
						$_SESSION['filamentColorCode'] = $filament['rgba'];
					}
				}

				$materialPrice = $printTime * $pricerPerGramm * ($grammsPerHour / ($resolution+1));
				$workPrice = $workPerGramm * ($grammsPerHour / ($resolution+1));
				$energyPrice = $printTime * $energyPerHour;

				$taxesPrice = ($materialPrice + $workPrice + $energyPrice) * $taxes;

				$totalPrintPrice = ($workPrice + $energyPrice + $shippting) * $amount + $taxesPrice;
				$modelPrice = $workPrice + $energyPrice + $taxesPrice;

				$_SESSION['printPrices'][0] = round($totalPrintPrice, 2);
				$_SESSION['printPrices'][1] = round($energyPerHour, 2);
				$_SESSION['printPrices'][2] = round($workPrice, 2);
				$_SESSION['printPrices'][3] = round($energyPrice, 2);
				$_SESSION['printPrices'][4] = round($shippting, 2);
				$_SESSION['printPrices'][5] = round($taxesPrice, 2);
				$_SESSION['printPrices'][6] = round($modelPrice, 2);
				$_SESSION['filamentColorCode'] = $filamentColorCode;
				$_SESSION['infill'] = $infill;
				$_SESSION['resolution'] = $resolution;
				$_SESSION['stlFileName'] = $file;
			} else {
				$_SESSION['error'] = 'Fehler: es müssen alle Datan angegeben sein';
			}
		} else {
			$_SESSION['error'] = 'Fehler: kein Model hochgeladen';
		}
	}
//C3_F6
	protected function saveConfiguration() {

		if(isset($_SESSION['modelName'])) {
			$this->calculateModel();
			$this->appendToShoppingCart();
			$link = 'index.php?c=order&a=shoppingCart';

			header("Location: $link ");
		} else {
			$_SESSION['error'] = 'Fehler: kein Model hochgeladen';
//			//TODO: errorHandling
//			echo "no Model selected <br>";
		}
	}
//C3_F7
	protected function appendToShoppingCart() {
		$orderModelName = $_SESSION['modelName'];
		$orderInfill = $_SESSION['infill'];
		$orderResolution = $_SESSION['resolution'];
		$filament = $_SESSION['filamentColor'];
		$orderPrintTime = $_SESSION['printTime'];
		$orderPrice = $_SESSION['printPrices'];
		$glbFile = $_SESSION['glbFile'];
		$stlFile = $_SESSION['stlFileName'];
		$filamentColorCode = $_SESSION['filamentColorCode'];
		$amount = isset($_POST['amount']) ? $_POST['amount'] : 1;

		$shoppingCartItem = [$orderModelName, $orderInfill, $orderResolution, $filament, $orderPrintTime, $orderPrice, $glbFile, $amount, $filamentColorCode, $stlFile];

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
//C3_F8
	protected function removeFromShoppingCart() {
		$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];
		foreach ($shoppingCart as $key => $item) {
			if (isset($_POST[$key])) {
				array_splice($shoppingCart, $key, 1);
			}
		}
		if (empty($shoppingCart)) {
			unset($_SESSION['shoppingCart']);
		} else {
			$_SESSION['shoppingCart'] = $shoppingCart;
		}


	}
//C3_F9
	//manages shoppinCart
	public function shoppingCart() {

		if (empty($_SESSION['shoppingCart'])) {
			unset($_SESSION['makeOrder']);
		}

		if (isset($_POST['submit'])) {

			$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];

			if (!empty($shoppingCart)) {
				$link = 'index.php?c=order&a=checkout';
				header("Location: $link ");
			} else {
				$_SESSION['error'] = 'Der Warenkorb ist leer';
			}
		}

		if (isset($_POST['submitDelete'])) {

			if (count($_POST) < 2) {
				$_SESSION['error'] = 'Zum Löschen, wählen Sie ein Model aus';
			} else {
				$this->removeFromShoppingCart();
			}
		}
	}
//C3_F10
	//manages checkout, checks reqiered userData
	public function checkout($subaction) {

		$_SESSION['makeOrder'] = true;

		if (!$this->loggedIn()) {
			$link = 'index.php?c=main&a=login';
			header("Location: $link ");
		} else {
			$customerData = $this->loadUserData();

			if (!isset($customerData['aid']) ) {
				$GLOBALS['currentView'] = 'addressData';
			}
            else if (!isset($customerData['pdid'])) {

				$paymentData = new ChangePaymentData();
				$paymentData->changePaymentData($subaction);
				$GLOBALS['currentView'] = 'paymentData';
			}
		}

		if (isset($_POST['submitOrder'])) {
			$this->makeOrder();
		}

		if (isset($_POST['editShoppingCart'])) {
			$link = 'index.php?c=order&a=shoppingCart';

			header("Location: $link ");
		}
	}
//C3_F11
	//manages orders
	public function makeOrder() {
		$userData = $this->loadUserData();

		$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];

		if (!empty($shoppingCart)) {

			$fullPrice = 0;
			foreach ($shoppingCart as $item) {
				$fullPrice += $item[5][0];

//				if ($userData['username'] != $_SESSION['uid']) {
//					echo $item[0];
//					echo '<br>';
//					echo $item[6];
//					echo '<br>';
//					$newDirectory = '..'.'/'.'uploads'.'/'.$userData['username'].'/'.'stl'
//
//					move_uploaded_file($item[6], $item[0]);
//				}

			}
			$order = new Order(['Customer_id' => $userData['cid'], 'price' => $fullPrice]);
			$order->insert($this->errors);

			$orderData = $this->loadOrders();
			$lastOrderID = end($orderData)['oid'];

			$this->loadFilaments();

			foreach ($shoppingCart as $item) {

				$filaments = $_SESSION['filaments'];

				$filamentId = 0;

				foreach ($filaments as $filament) {

					if ($filament['rgba'] == $item[8]) {
						$filamentId = $filament['id'];
					}
				}

				$fileName = $item[0] . '.stl';

				$sql = "BEGIN;
				
				INSERT INTO `PrintSettings` (`resolution`, `infill`) 
				VALUES ('".$item[2]."', '".($item[1]/100)."');
				SET @printSettingID = LAST_INSERT_ID();
				
				INSERT INTO `Models` (`fileName`, `modelPrice`) 
				VALUES ('".$fileName."', '".$item[5][6]."');
				SET @modelsID = LAST_INSERT_ID();
				
				INSERT INTO `PrintConfig` (`Filaments_id`, `Models_id`, `PrintSettings_id`, `Orders_id`, `amount`, `printTime`) 
				VALUES ('".$filamentId."', @modelsID, @printSettingID, '".$lastOrderID."', '".$item[7]."', '".$item[4]."');
				
				COMMIT;
				";

				echo '<br>' . $sql . '<br>';

				$order->sendSql($this->errors, $sql);


			}

			if (empty($this->errors)) {
				unset($_SESSION['shoppingCart']);
				unset($_SESSION['makeOrder']);
				$link = 'index.php?c=order&a=orderSuccess';

				header("Location: $link ");
			}

		}

//		$order = new Order(['Customer_id'=>$userData['cid'],
//			'price'=>$orderPrice]);
//
//		$printSettings = new PrintSetting(['resolution'=>$orderResolution, 'infill'=>$orderInfill]);
//
//		$models = new Model(['fileName'=>$orderModelName, 'modelPrice'=>$orderPrice]);
//
//
//
//		$printSettings->insert($this->errors);
//		$models->insert($this->errors);
//
//		$printSettingsId = $models->find(['resolution', 'infill'], [$orderResolution, $orderInfill])[0]['id'];
//		$modelId = $models->find(['fileName'], [$orderModelName])[0]['id'];
//
//
//
//		$order->insert($this->errors, ['INSERT INTO PrintConfig (Orders_id, Filaments_id, Models_id, PrintSettings_id, printTime)
//								VALUES (LAST_INSERT_ID(),'.$orderFilamentId.', '.$modelId.', '.$printSettingsId.', '.$orderPrintTime.')']);

//				echo json_encode($_SESSION['customerData']) . '<br>';
	}
//C3_F12
	protected function loadUserData() {

		$username = $_SESSION['username'];

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

		return $loadedData[0];
	}
//C3_F13
	protected function loadOrders()
	{
		$username = $_SESSION['username'];

		$orders = Order::findOnJoin(
			'orders',
			['o.id as oid',
				'm.modelPrice',
				'm.fileName',

				'o.createdAt',
				'o.processed',
				'o.payed',


				'pc.id as pcid',
				'pc.amount',
				'pc.printTime',

				'ps.infill',
				'ps.description',

				'f.color',
				'f.type',
				'o.cancelled'
			],

			['username'],

			[$username]); // Hier $username einfügen


		return $orders;
	}
//C3_F14
	protected function loadFilaments() {
		$filaments = Filament::find();

        $this->filaments = $filaments;

		$columns = array_column($filaments, 'type');
		array_multisort($columns, SORT_ASC, $filaments);


		$types = array_count_values($columns);

		$_SESSION['filaments'] = $filaments;
	}
//C3_F15
	//manages presets
	public function presets() {
		$this->loadPresets();

		echo 'preset: <br>' . json_encode($_SESSION['presets']) . '<br><br>';


	}
//C3_F16
	//loads and saves printSettings in sessin with filled preset attribute
	protected function loadPresets() {
		$data = PrintSetting::find();
		$presets = [];

		foreach($data as $key => $preset) {
			if (!empty($preset['description'])) {
				$presets[] = $preset;
			}
		}

		$_SESSION['presets'] = $presets;
	}

}