<?php
//C4
namespace DDDDD\controller;

use DDDDD\controller\functions\ChangePaymentData;
use DDDDD\controller\functions\PaymentFunction;
use DDDDD\controller\functions\Table;
use DDDDD\core\Controller;

use DDDDD\model\Address;
use DDDDD\model\ContactData;
use DDDDD\model\CreditCard;
use DDDDD\model\Customer;
use DDDDD\model\DirectDebit;
use DDDDD\model\Order;
use DDDDD\model\PaymentData;
use DDDDD\model\Paypal;
use DDDDD\model\PrintConfig;


class UserController extends Controller
{

	protected $errors = [];
	protected $customerData = NULL;
//	protected $preferedPaymentMethod = NULL;
	protected $username = NULL;
//C4_F1
	public function __construct($controller, $action, $subAction = null)
	{
		parent::__construct($controller, $action, $subAction);
		if (!isset($_SESSION['customerData'])) {
			$this->loadCustomerData();
		}

	}
//C4_F2
	public function usermenu($subAction) {

		$this->loadCustomerData();

		if (isset($_POST['submitContactData']) && isset($_POST['firstName'])) {

			$this->changeUserData();
		}
		if (isset($_POST['submitAddress']) && isset($_POST['street'])) {

			$this->changeAddressData();
		}
	}
//C4_F3
	public function changePaymentData($subAction) {

		$this->loadCustomerData();

		if (isset($_POST['preferedPaymentMethod'])) {
			$preferedPaymentMthod = $_POST['preferedPaymentMethod'];
		} else {
			$preferedPaymentMthod = '';
		}

		$paymentData = new ChangePaymentData();
		$paymentData->changePaymentData($subAction, $preferedPaymentMthod);

	}
//C4_F4
	public function addressInput() {
		$this->loadCustomerData();
	}
//C4_F5
	protected function loadCustomerData() {

		if ($this->loggedIn()) {
			$this->username = $_SESSION['username'];

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

				[$this->username]);

//		echo json_encode($_SESSION['customerData']);

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

//		$GLOBALS['customerData'] = $loadedData[0];

			$this->customerData = $_SESSION['customerData'];
		}

		return;

	}
//C4_F6
	protected function changeUserData() {
		$contactDataId = $this->customerData['cdid'];
		$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : $this->customerData['firstName'];
		$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : $this->customerData['lastName'];
		$emailAddress = !empty($_POST['emailAddress']) ? $_POST['emailAddress'] : $this->customerData['emailAddress'];
		$phoneNumber = !empty($_POST['phoneNumber']) ? $_POST['phoneNumber'] : $this->customerData['phoneNumber'];

		$contactData = new ContactData(['id'=>$contactDataId, 'firstName'=>$firstName, 'lastName'=>$lastName, 'emailAddress'=>$emailAddress, 'phoneNumber'=>$phoneNumber]);


		$contactData->validate($this->errors);

		if (empty($this->errors)) {
			$contactData->update($this->errors);

			$_SESSION['customerData']['firstName'] = $firstName;
			$_SESSION['customerData']['lastName'] = $lastName;
			$_SESSION['customerData']['emailAddress'] = $emailAddress;
			$_SESSION['customerData']['phoneNumber'] = $phoneNumber;
		} else {
			$_SESSION['error'] = '';
			foreach ($this->errors as $item) {
				$_SESSION['error'] .= $item[0];
				$_SESSION['error'] .= '<br>';
			}
		}



	}
//C4_F7
	protected function changeAddressData() {

		if (isset($_POST['addressId'])) {
			$contactDataId = $_POST['addressId'];
		} else {
			$this->loadCustomerData();
			$contactDataId = $this->customerData['cdid'];
		}

		$addressDataId = $this->customerData['aid'];
		$street = !empty($_POST['street']) ? $_POST['street'] : $this->customerData['street'];
		$number = !empty($_POST['number']) ? $_POST['number'] : $this->customerData['number'];
		$postalCode = !empty($_POST['postalCode']) ? $_POST['postalCode'] : $this->customerData['postalCode'];
		$city = !empty($_POST['city']) ? $_POST['city'] : $this->customerData['city'];
		$country = !empty($_POST['country']) ? $_POST['country'] : $this->customerData['country'];

		$addressData = new Address(['id'=>$addressDataId, 'street'=>$street, 'number'=>$number, 'postalCode'=>$postalCode, 'city'=>$city, 'country'=>$country]);

		$addressData->validate($this->errors);

		if (empty($this->errors)) {
			$loadedData = $addressData->find(['id'], [$addressDataId]);

			if (empty($loadedData)) {
				$addressData->insert($this->errors, ['UPDATE ContactData SET Address_id = LAST_INSERT_ID() where id = ' . $contactDataId . ' ;']);
			} else {
				$addressData->update($this->errors);
			}

			$_SESSION['customerData']['street'] = $street;
			$_SESSION['customerData']['number'] = $number;
			$_SESSION['customerData']['postalCode'] = $postalCode;
			$_SESSION['customerData']['city'] = $city;
			$_SESSION['customerData']['country'] = $country;

			if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
				$link = 'index.php?c=order&a=checkout';
				header("Location: $link ");
			}
		} else {
			$_SESSION['error'] = '';
			foreach ($this->errors as $item) {
				$_SESSION['error'] .= $item[0];
				$_SESSION['error'] .= '<br>';
			}
			if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
				$link = 'index.php?c=order&a=checkout';
				header("Location: $link ");
			}
		}





	}
//C4_F8
	public function changeUserPassword($subAction) {
		$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

		$this->loadCustomerData();

		if (isset($_POST['submit'])) {

			$newPassword = isset($_POST['newPasswort']) ? $_POST['newPasswort'] : '';
			$newPasswortVerified = isset($_POST['newPasswortVerified']) ? $_POST['newPasswortVerified'] : '';

			if ($newPassword === $newPasswortVerified) {

				$contactData = new ContactData();
				$currentPassword = $_POST['currentPassword'];
				$passwordData = $contactData->find(['username'], [$this->customerData['username']]);

				if (!empty($passwordData) && password_verify($currentPassword, $passwordData[0]["password"])) {


					$options = [
						'cost' => 12,
					];
					$password = password_hash($newPassword,PASSWORD_BCRYPT, $options);

					$contactData->{'id'} = $this->customerData['cdid'];
					$contactData->{'password'} = $password;

					$contactData->validate($this->errors);

					if (empty($this->errors)) {
						$contactData->update($this->errors);

						unset($contactData);
//						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
//
//						header("Location: $link ");
						$_SESSION['error'] = 'Passwort erfolgreich geänder';
					} else {
						$_SESSION['error'] = '';
						foreach ($this->errors as $item) {
//								echo json_encode($this->errors);
							$_SESSION['error'] .= $item[0];
							$_SESSION['error'] .= '<br>';
						}
					}

				} else {
					$_SESSION['error'] = 'Altes Passwort stimmt nicht';
				}
			} else {
				$_SESSION['error'] = 'Eingaben stimmen nicht überein';
			}
		}
	}
//C4_F9
	public function orders($subAction)
	{
		if (isset($_POST['submitDelete'])) {
//			echo "Delete ?";
			$this->cancellOrder();
		}

		$this->loadTable();
	}
//C4_F10
	protected function loadTable() {
		$this->loadCustomerData();
		$GLOBALS['orders'] = $this->loadOrders();

		$orders = $this->loadOrders();

		$header = [
			'oid' => 'Bestellnummer',
			'createdAt' => 'Bestelldatum',
			'fileName' => 'Dateiname',
			'modelPrice' => 'Preis',
			'status' => 'Status'
		];

		$subHeader = [
			'oid' => 'Bestellnummer',
			'createdAt' => 'Bestelldatum',
			'fileName' => '',
			'modelPrice' => '',
			'status' => ''
		];

		$dataRow = [
			'oid' => '',
			'createdAt' => '',
			'fileName' => 'Dateiname',
			'modelPrice' => 'Preis',
			'status' => 'Status'

		];

		$footer = [
			'Summe',
			'',
			'',
			'sum',
			''
		];

		$input = [
			'action' => 'index.php?c=user&a=cancellOrder',
			'inputs' => [
				'<input type="submit" name="submitDelete" value="stornieren">'
			],
			'inSubHeader' => false
		];

		$table = new Table($orders, $header, $subHeader, $dataRow, $footer, $input);

		$GLOBALS['ordersTable'] = $table->render();
	}
//C4_F11
	protected function loadOrders()
	{
		if ($this->loggedIn()) {
			$username = $_SESSION['username'];

			$orders = Order::findOnJoin(
				'orders',
				[   'o.id as oid',
					'm.modelPrice',
					'm.fileName',

					'o.createdAt',
					'o.processed',
					'o.payed',
					'o.Employee_id',


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

			foreach ($orders as $key => $order) {
				if (!empty($order['oid'])) {
//				echo json_encode($order) .  '<br>';
//				echo json_encode($order['Employee_id']). '<br>';

					if ($order['processed'] == true) {
//						$doneOrders[] = $order;
						$orders[$key]['status'] = 'verarbeitet und versand';
					} else if (!empty($order['Employee_id'])) {
//						$ordersInProcess[] = $order;
						$orders[$key]['status'] = 'in Arbeit';
					} else {
//						$openOrders[] = $order;
						$orders[$key]['status'] = 'noch nicht in Arbeit';
					}

				}
			}


			return $orders;
		} else {
			return [];
		}


	}
//C4_F12
	public function cancellOrder()
	{

		$errors = NULL;
		$GLOBALS['success'] = false;
		$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

		$orderToCancell = $this->getSelectedOrder();
		$GLOBALS['orderToCancell'] = $orderToCancell;

//		echo json_encode($orderToCancell);

		$printConfigId = isset($_POST['printConfigId']) ? $_POST['printConfigId'] : NULL;

//		echo "<br><br>id: $id <br><br>";

		if (isset($_POST['submit']) && $_POST['submit'] == 'Ja') {


			$printConfig = new PrintConfig([
				'id'=>$printConfigId
			]);

			if ($printConfig->delete($this->errors)) {
				$GLOBALS['success'] = true;
			}

			$remainingOrders = $this->loadOrders();

			foreach ($remainingOrders as $remainingOrder) {
				if (empty($remainingOrder['pcid'])) {
					$delteOrder = new Order(['id' => $remainingOrder['oid']]);
					$delteOrder->delete($this->errors);
					unset($delteOrder);

				}
			}



		} else if (isset($_POST['submit']) && $_POST['submit'] == 'Nein') {
			$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

			header("Location: $link ");

		} else {

		}
	}
//C4_F13
	public function details($subAction)
	{

		$GLOBALS['detailedOrder'] = $this->getSelectedOrder();
	}
//C4_F14
	protected function getSelectedOrder() {

		$orders = $this->loadOrders();
		$value = [];

//		echo json_encode($orders);

		$id = isset($_POST['orderId']) ? $_POST['orderId'] : null;

//		echo json_encode($id);



		foreach ($orders as $order) {
			if ($order['oid'] == $id) {
				$value = $order;
			}
		}

		return $value;
	}

}