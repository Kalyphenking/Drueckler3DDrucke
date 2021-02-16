<?php

namespace DDDDD\controller;

use DDDDD\controller\functions\ChangePaymentData;
use DDDDD\controller\functions\PaymentFunction;
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

	public function usermenu($subAction) {
		$this->loadUserData();

		if (isset($_POST['submit']) && isset($_POST['firstName'])) {

			$this->changeUserData();
		}
		if (isset($_POST['submitAddress']) && isset($_POST['street'])) {

			$this->changeAddressData();
		}
	}

	public function changePaymentData($subAction) {
		$this->loadUserData();

		if (isset($_POST['preferedPaymentMethod'])) {
			$preferedPaymentMthod = $_POST['preferedPaymentMethod'];
		} else {
			$preferedPaymentMthod = '';
		}

		$paymentData = new ChangePaymentData();
		$paymentData->changePaymentData($subAction, $preferedPaymentMthod);

	}

	public function addressInput() {
		$this->loadUserData();
	}

	protected function loadUserData() {

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

	protected function changeUserData() {
		$contactDataId = $this->customerData['cdid'];
		$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : $this->customerData['firstName'];
		$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : $this->customerData['lastName'];
		$emailAddress = !empty($_POST['emailAddress']) ? $_POST['emailAddress'] : $this->customerData['emailAddress'];
		$phoneNumber = !empty($_POST['phoneNumber']) ? $_POST['phoneNumber'] : $this->customerData['phoneNumber'];



		$contactData = new ContactData(['id'=>$contactDataId, 'firstName'=>$firstName, 'lastName'=>$lastName, 'emailAddress'=>$emailAddress, 'phoneNumber'=>$phoneNumber]);

		$contactData->update($this->errors);

		$_SESSION['customerData']['firstName'] = $firstName;
		$_SESSION['customerData']['lastName'] = $lastName;
		$_SESSION['customerData']['emailAddress'] = $emailAddress;
		$_SESSION['customerData']['phoneNumber'] = $phoneNumber;

	}

	protected function changeAddressData() {
		$this->loadUserData();
		$contactDataId = $this->customerData['cdid'];

		$addressDataId = $this->customerData['aid'];
		$street = !empty($_POST['street']) ? $_POST['street'] : $this->customerData['street'];
		$number = !empty($_POST['number']) ? $_POST['number'] : $this->customerData['number'];
		$postalCode = !empty($_POST['postalCode']) ? $_POST['postalCode'] : $this->customerData['postalCode'];
		$city = !empty($_POST['city']) ? $_POST['city'] : $this->customerData['city'];
		$country = !empty($_POST['country']) ? $_POST['country'] : $this->customerData['country'];

		$addressData = new Address(['id'=>$addressDataId, 'street'=>$street, 'number'=>$number, 'postalCode'=>$postalCode, 'city'=>$city, 'country'=>$country]);

		$loadedData = $addressData->find(['id'], [$addressDataId]);

		if (empty($loadedData)) {
			$addressData->insert($this->errors, ['UPDATE ContactData SET Address_id = LAST_INSERT_ID() where id = ' . $contactDataId . ' ;']);
		} else {
			$addressData->update($this->errors);
		}

//		echo json_encode($this->errors);

		$_SESSION['customerData']['street'] = $street;
		$_SESSION['customerData']['number'] = $number;
		$_SESSION['customerData']['postalCode'] = $postalCode;
		$_SESSION['customerData']['city'] = $city;
		$_SESSION['customerData']['country'] = $country;

		if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
			$link = 'index.php?c=order&a=checkout';
			header("Location: $link ");
		}
	}

	public function changeUserPassword($subAction) {
		$this->loadUserData();

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

					$contactData->update($this->errors);

					unset($contactData);

					//TODO successMessage

				} else {
					//TODO errorHandling
				}
			} else {
				//TODO errorHandling
			}
		}
		//TODO errorHandling
		if (!empty($errors)) {
			echo json_encode($errors) . '<br>';
		}


	}

	public function orders($subAction)
	{
		$this->loadUserData();
		$GLOBALS['orders'] = $this->loadOrders();

//		echo 'orders: <br>' . json_encode($_SESSION['orders']) . '<br><br>';
	}

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

	public function cancellOrder($subAction)
	{

		$errors = NULL;
		$GLOBALS['success'] = false;
		$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

		$orderToCancell = $this->getSelectedOrder();
		$GLOBALS['orderToCancell'] = $orderToCancell;

//		echo json_encode($orderToCancell);

		$id = isset($_POST['orderId']) ? $_POST['orderId'] : NULL;

//		echo "<br><br>id: $id <br><br>";

		if (isset($_POST['submit']) && $_POST['submit'] == 'Ja') {


			$printConfig = new PrintConfig([
				'id'=>$id
			]);

			if ($printConfig->delete($errors)) {
				$GLOBALS['success'] = true;
			};



		} else if (isset($_POST['submit']) && $_POST['submit'] == 'Nein') {
			$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

			header("Location: $link ");

		} else {

		}
	}

	public function details($subAction)
	{

		$GLOBALS['detailedOrder'] = $this->getSelectedOrder();
	}

	protected function getSelectedOrder() {

		$orders = $this->loadOrders('pc');
		$value = [];

		$id = isset($_POST['orderId']) ? $_POST['orderId'] : NULL;

		foreach ($orders as $order) {
			if ($order['id'] == $id) {
				$value = $order;
			}
		}

//		echo json_encode($value);

		return $value;
	}

}