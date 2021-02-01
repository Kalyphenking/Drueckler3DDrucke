<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;

use DDDDD\model\ContactData;
use DDDDD\model\Customer;
use DDDDD\model\Orders;
use DDDDD\model\PaymentData;
use DDDDD\model\Paypal;
use DDDDD\model\PrintConfig;


class UserController extends Controller
{

	protected $errors = NULL;

	public function usermenu($subAction) {
		$loadedData = $this->loadContactData();

//		echo "<br><br><br>" . json_encode($loadedData) . "<br><br><br>";
		$_SESSION['customerData'] = $loadedData[0];
		$preferedPaymentMethod = $loadedData[0]['preferedPaymentMethod'];
//		$_SESSION['customerID'] = $loadedData[0]['cid'];

		switch ($preferedPaymentMethod) {
			case 'dd':
				$name = 'setDirectDebit';
				break;
			case 'cc':
				$name = 'setCreditCard';
				break;
			case 'bl':
				$name = 'Bill';
				break;
			case 'pp':
				$name = 'setPayPal';
				break;
			default:
				$name = 'setDirectDebit';
				break;
		}

		$_SESSION['preferedPaymentMethod'] = $name;

	}

	public function changePaymentData($subAction) {
		$username = $_SESSION['username'];
		$action = '';

		if (!empty($subAction)) {
			$action = $subAction;
		} else if(isset($_SESSION['preferedPaymentMethod'])) {
			$action = $_SESSION['preferedPaymentMethod'];
		}



		if (method_exists($this, $action)) {

			$this->{$action}($username);



			if (isset($_POST['submit'])) {
				if (!empty($_POST['preferedPaymentMethod'])) {

					$loadedPaymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];

					echo json_encode($loadedPaymentData) . '<br><br>';

					switch ($action) {
						case 'setDirectDebit':
							$preferedPaymentMethod = 'dd';
							break;
						case 'setCreditCard':
							$preferedPaymentMethod = 'cc';
							break;
						case 'setBill':
							$preferedPaymentMethod = 'bl';
							break;
						case 'setPayPal':
							$preferedPaymentMethod = 'pp';
							break;
					}




					echo $preferedPaymentMethod . '<br><br>';


					$paymentData = new PaymentData(['preferedPaymentMethod'=>$preferedPaymentMethod,
													'id'=>$loadedPaymentData['pdid']]);


					$loadedData = $paymentData->find(['preferedPaymentMethod'],
													 [$loadedPaymentData['preferedPaymentMethod']]);


					if(empty($loadedData)) {
						$paymentData->insert($this->errors);
					} else {
						$paymentData->update($this->errors);
					}

				} else {
					//TODO errorHandling
				}
			}
		}




	}

	protected function setDirectDebit($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setDirectDebit';
		$loadedData = $this->loadDirectDebitData($username);
		$GLOBALS['paymentData'] = $loadedData[0];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['iban'])
				&& !empty($_POST['owner'])
				&& !empty($_POST['mandate']))
			{

			} else {
				//TODO errorHandling
			}
		}
	}
	protected function setCreditCard($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setCreditCard';
		$loadedData = $this->loadCreditCardData($username);
		$GLOBALS['paymentData'] = $loadedData[0];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['type'])
				&& !empty($_POST['mandate'])
				&& !empty($_POST['owner'])
				&& !empty($_POST['expiryDate']))
			{

			} else {
				//TODO errorHandling
			}
		}
	}
	protected function setBill($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setBill';
		$loadedData = $this->loadBillData($username);
		$GLOBALS['paymentData'] = $loadedData[0];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['street'])
				&& !empty($_POST['number'])
				&& !empty($_POST['postalCode'])
				&& !empty($_POST['city'])
				&& !empty($_POST['country']))
			{

			} else {
				//TODO errorHandling
			}
		}
	}
	protected function setPayPal($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setPayPal';
		$loadedData = $this->loadPayPalData($username);
		$GLOBALS['paymentData'] = $loadedData[0];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['emailAddress'])
				&& !empty($_POST['password']))
			{
				$emailAddress = $_POST['emailAddress'];
				$previousEmailAddress = $loadedData[0]['emailAddress'];
				$payPalId = $loadedData[0]['ppid'];

				$options = [
					'cost' => 12,
				];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT, $options);

				$paypalData = new Paypal(['emailAddress'=>$emailAddress, 'password'=>$password, 'id'=>$payPalId]);

				$loadedData = $paypalData->find(['emailAddress'], [$previousEmailAddress]);

				if (empty($loadedData)) {

					$paypalData->insert($this->errors);
				} else {
					$paypalData->update($this->errors);
				}

				echo json_encode($this->errors) . '<br><br>';

			} else {
				//TODO errorHandling
			}
		}
	}

	protected function loadDirectDebitData($username) {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
			'pd.id as pdid',

			'dd.ibanShort',
			'dd.owner',
			'dd.mandate',
			'dd.id as ddid'

		], ['username'], [$username]);

		return $loadedData;
	}

	protected function loadCreditCardData($username) {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
			'pd.id as pdid',

			'cc.type',
			'cc.owner',
			'cc.expiryDate',
			'cc.numberShort',
			'cc.id as ccid'

		], ['username'], [$username]);

		return $loadedData;
	}

	protected function loadBillData($username) {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
			'pd.id as pdid',

			'ba.street',
			'ba.number',
			'ba.postalCode',
			'ba.city',
			'ba.country',
			'ba.id as baid'

		], ['username'], [$username]);

		return $loadedData;
	}

	protected function loadPayPalData($username) {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
				'pd.id as pdid',

				'pp.emailAddress',
				'pp.id as ppid'

		], ['username'], [$username]);

		return $loadedData;
	}


	protected function loadContactData() {
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

			'a.street',
			'a.number',
			'a.postalCode',
			'a.city',
			'a.country',

			'pd.preferedPaymentMethod',
			'pd.id as pdid'
			],

			['username'],

			[$username]);

		return $loadedData;

	}

	protected function changeUserData() {
		$username = $_SESSION['username'];
		$contactData = new ContactData();
		$loadedData = $contactData::find(['username'], [$username]);

		foreach ($loadedData[0] as $key => $data) {
			$contactData->{$key} = $data;
		}
	}

	public function changeUserPassword($subAction) {


		if (isset($_POST['submit'])) {
			$newPassword = isset($_POST['newPasswort']) ? $_POST['newPasswort'] : '';
			$newPasswortVerified = isset($_POST['newPasswortVerified']) ? $_POST['newPasswortVerified'] : '';

			$customerData = $_SESSION['customerData'];

			if ($newPassword === $newPasswortVerified) {
				$contactData = new ContactData();
				$currentPassword = $_POST['currentPassword'];
				$passwordData = $contactData::find(['username'], [$customerData['username']]);


				if (!empty($passwordData) && password_verify($currentPassword, $passwordData[0]["password"])) {
					$options = [
						'cost' => 12,
					];
					$password = password_hash($newPassword,PASSWORD_BCRYPT, $options);



					$contactData->{'id'} = $customerData['cdid'];
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
		$GLOBALS['orders'] = $this->loadOrders();

//		echo 'orders: <br>' . json_encode($_SESSION['orders']) . '<br><br>';
	}


	protected function loadOrders()
	{
		$username = $_SESSION['username'];

		$orders = Orders::findOnJoin(
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