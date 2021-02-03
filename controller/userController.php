<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;

use DDDDD\model\Address;
use DDDDD\model\Bill;
use DDDDD\model\ContactData;
use DDDDD\model\CreditCard;
use DDDDD\model\Customer;
use DDDDD\model\DirectDebit;
use DDDDD\model\Orders;
use DDDDD\model\PaymentData;
use DDDDD\model\Paypal;
use DDDDD\model\PrintConfig;


class UserController extends Controller
{

	protected $errors = [];
	protected $customerData = NULL;
	protected $preferedPaymentMethod = NULL;

	public function usermenu($subAction) {
		$this->loadContactData();

		if (isset($_POST['submit']) && isset($_POST['firstName'])) {

			$this->changeUserData();
		}
		if (isset($_POST['submit']) && isset($_POST['street'])) {

			$this->changeAddressData();
		}
	}

	public function changePaymentData($subAction) {
		$username = $_SESSION['username'];
		$action = '';

		if (!empty($subAction)) {
			$action = $subAction;
		} else if(isset($_SESSION['preferedPaymentMethod'])) {
			$action = $_SESSION['preferedPaymentMethod'];
		}

//		$this->customerData = $this->loadContactData()[0];
		$this->loadContactData();
//		echo "<br><br><br>" . json_encode($this->contactData) . "<br><br><br>";

		if (method_exists($this, $action)) {



			if (isset($_POST['submit'])) {
				if (!empty($_POST['preferedPaymentMethod'])) {
					switch ($action) {
						case 'setDirectDebit':
							$this->preferedPaymentMethod = 'dd';
							break;
						case 'setCreditCard':
							$this->preferedPaymentMethod = 'cc';
							break;
						case 'setBill':
							$this->preferedPaymentMethod = 'bl';
							break;
						case 'setPayPal':
							$this->preferedPaymentMethod = 'pp';
							break;
					}
				} else {
					$this->preferedPaymentMethod = $this->customerData['preferedPaymentMethod'];
				}

				//TODO errorHandling
			}

			$this->{$action}($username);
		}

	}

	protected function setDirectDebit($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setDirectDebit';

		$directDebitId = $this->customerData['ddid'];
		$customerId = $this->customerData['cid'];
		$paymentDataId = $this->customerData['pdid'];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['iban'])
				&& !empty($_POST['owner'])
				&& !empty($_POST['mandate']))
			{

				$iban = $_POST['iban'];
				$ibanShort = substr($_POST['iban'], 0, 2) . '****************' . substr($_POST['iban'], 18, 4);
				$owner = $_POST['owner'];
				$mandate = $_POST['mandate'] == 'on' ? '1' : '0';



				$directDebitData = new DirectDebit(['id'=>$directDebitId,
													'iban'=>$iban,
													'ibanShort'=>$ibanShort,
													'owner'=>$owner,
													'mandate'=>$mandate]);

				$directDebitData->validate($this->errors);

				$loadedData = $directDebitData->find(['id'], [$directDebitId]);



				if (empty($loadedData)) {

					$db = $GLOBALS['db'];
					if (empty($paymentDataId)) {

						echo "<h1>pd Leer</h1>";

						$directDebitData->insert($this->errors,
							['INSERT INTO PaymentData (DirectDebit_id, preferedPaymentMethod)	
								VALUES (LAST_INSERT_ID(),'.$db->quote($this->preferedPaymentMethod).');',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {
						$directDebitData->insert($this->errors,
							['UPDATE PaymentData set DirectDebit_id = LAST_INSERT_ID(), preferedPaymentMethod = '.$db->quote($this->preferedPaymentMethod).' where id = ' . $customerId . ' ;']);
					}


				} else {
					$directDebitData->update($this->errors);
				}

//				echo 'Error: ' . json_encode($this->errors) . '<br><br>';

			} else {
				//TODO errorHandling
			}
		}
		$loadedData = $this->loadDirectDebitData($username);
		$GLOBALS['paymentData'] = $loadedData[0];
	}
	protected function setCreditCard($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setCreditCard';

		$creditCardId = $this->customerData['ccid'];
		$customerId = $this->customerData['cid'];
		$paymentDataId = $this->customerData['pdid'];



		if (isset($_POST['submit'])) {

			if(!empty($_POST['number'])
				&& !empty($_POST['type'])
				&& !empty($_POST['owner'])
				&& !empty($_POST['expiryDateMonth'])
				&& !empty($_POST['expiryDateYear'])
				&& !empty($_POST['securityCode']))
			{


				$number = $_POST['number'];
				$type = $_POST['type'];
				$owner = $_POST['owner'];
				$expiryDate = $_POST['expiryDateMonth'] . '/' . $_POST['expiryDateYear'];
				$securityCode = $_POST['securityCode'];


				$creditCardData = new CreditCard(['id'=>$creditCardId,
												  'number'=>$number,
												  'type'=>$type,
												  'owner'=>$owner,
												  'expiryDate'=>$expiryDate,
												  'securityCode'=>$securityCode]);

				$loadedData = $creditCardData->find(['id'], [$creditCardId]);

				if (empty($loadedData)) {

					$db = $GLOBALS['db'];
					if (empty($paymentDataId)) {

						echo "<h1>pd Leer</h1>";

						$creditCardData->insert($this->errors,
							['INSERT INTO PaymentData (CreditCard_id, preferedPaymentMethod)	
								VALUES (LAST_INSERT_ID(),'.$db->quote($this->preferedPaymentMethod).');',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {
						$creditCardData->insert($this->errors,
							['UPDATE PaymentData set CreditCard_id = LAST_INSERT_ID(), preferedPaymentMethod = '.$db->quote($this->preferedPaymentMethod).' where id = ' . $customerId . ' ;']);
					}
				} else {
					$creditCardData->update($this->errors);
				}

//				echo 'Error: ' . json_encode($this->errors) . '<br><br>';

			} else {
				//TODO errorHandling
			}
		}
		$loadedData = $this->loadCreditCardData($username);
		$GLOBALS['paymentData'] = $loadedData[0];
	}
	protected function setBill($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setBill';

		$loadedData = $this->loadBillData($username);
		$GLOBALS['paymentData'] = $loadedData[0];

		echo json_encode($loadedData);

		$billId = $this->customerData['blid'];

		$billAddressId = $loadedData[0]['baid'];

		$customerId = $this->customerData['cid'];
		$paymentDataId = $this->customerData['pdid'];
		$addressId = $this->customerData['aid'];



		if (isset($_POST['submit'])) {

			if(isset($_POST['sameAsShipping']) && !empty($_POST['sameAsShipping']))
			{

				if (!empty($addressId)) {

					$street = $this->customerData['street'];
					$number = $this->customerData['number'];
					$postalCode = $this->customerData['postalCode'];
					$city = $this->customerData['city'];
					$country = $this->customerData['country'];

					echo "country: $country <br>";
				} else {
					//TODO errorHandling
					echo 'error, keine Lieferadresse bekannt';
					return;
				}

			} else if(!empty($_POST['street'])
					&& !empty($_POST['number'])
					&& !empty($_POST['postalCode'])
					&& !empty($_POST['city'])
					&& !empty($_POST['country']))
			{

				$street = $_POST['street'];
				$number = $_POST['number'];
				$postalCode = $_POST['postalCode'];
				$city = $_POST['city'];
				$country = $_POST['country'];

			} else {
				//TODO errorHandling
				echo 'error, alle alle';
				return;
			}

			$billAddressData = new Address(['id'=>$billAddressId,
				'street'=>$street,
				'number'=>$number,
				'postalCode'=>$postalCode,
				'city'=>$city,
				'country'=>$country]);

			$loadedData = $billAddressData->find(['id'], [$billId]);

			if (empty($loadedData)) {
				$db = $GLOBALS['db'];
				if (empty($paymentDataId)) {

					$billAddressData->insert($this->errors,
						['INSERT INTO PaymentData (Bill_id, preferedPaymentMethod)	
								VALUES (LAST_INSERT_ID(),'.$db->quote($this->preferedPaymentMethod).');',

							'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
				} else {
					$billAddressData->insert($this->errors,
						['INSERT INTO Bill (Address_id) VALUES (LAST_INSERT_ID());',
							'UPDATE PaymentData set Bill_id = LAST_INSERT_ID(), preferedPaymentMethod = '.$db->quote($this->preferedPaymentMethod).' where id = ' . $customerId . ' ;']);
				}
			} else {
				$billAddressData->update($this->errors);
			}

//				echo 'Error: ' . json_encode($this->errors) . '<br><br>';

			$GLOBALS['paymentData']['street'] = $street;
			$GLOBALS['paymentData']['number'] = $number;
			$GLOBALS['paymentData']['postalCode'] = $postalCode;
			$GLOBALS['paymentData']['city'] = $city;
			$GLOBALS['paymentData']['country'] = $country;

		}

	}
	protected function setPayPal($username) {
		$GLOBALS['selectedPaymentMethod'] = 'setPayPal';

		$payPalId = $this->customerData['ppid'];
		$customerId = $this->customerData['cid'];
		$paymentDataId = $this->customerData['pdid'];

		if (isset($_POST['submit'])) {
			if(!empty($_POST['emailAddress'])
				&& !empty($_POST['password']))
			{
				$emailAddress = $_POST['emailAddress'];

				$options = [
					'cost' => 12,
				];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT, $options);

				$paypalData = new Paypal(['emailAddress'=>$emailAddress, 'password'=>$password, 'id'=>$payPalId]);

				$loadedData = $paypalData->find(['id'], [$payPalId]);

				if (empty($loadedData)) {
					$db = $GLOBALS['db'];
					if (empty($paymentDataId)) {

						echo "<h1>pd Leer</h1>";

						$paypalData->insert($this->errors,
							['INSERT INTO PaymentData (Paypal_id, preferedPaymentMethod)	
								VALUES (LAST_INSERT_ID(),'.$db->quote($this->preferedPaymentMethod).');',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {
						$paypalData->insert($this->errors,
							['UPDATE PaymentData set Paypal_id = LAST_INSERT_ID(), preferedPaymentMethod = '
							.$db->quote($this->preferedPaymentMethod).' where id = '
							. $customerId .
							' ;']);
					}
				} else {
					$paypalData->update($this->errors);
				}

//				echo 'Error: ' . json_encode($this->errors) . '<br><br>';

			} else {
				//TODO errorHandling
			}
		}

		$payPalData = $this->loadPayPalData($username)[0];
		$GLOBALS['paymentData'] = $payPalData;
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

//		echo '<br>' . json_encode($loadedData) . '<br>';

		$preferedPaymentMethod = $loadedData[0]['preferedPaymentMethod'];
//		$_SESSION['customerID'] = $loadedData[0]['cid'];


		switch ($preferedPaymentMethod) {
			case 'dd':
				$name = 'setDirectDebit';
				$output = 'Lastschrift';
				break;
			case 'cc':
				$name = 'setCreditCard';
				$output = 'Lastschrift';
				break;
			case 'bl':
				$name = 'setBill';
				$output = 'Lastschrift';
				break;
			case 'pp':
				$name = 'setPayPal';
				$output = 'Lastschrift';
				break;
			default:
				$name = 'setDirectDebit';
				$output = 'Nicht hinterlegt';
				break;
		}

		$GLOBALS['customerData'] = $loadedData[0];
		$GLOBALS['customerData']['preferedPaymentMethod'] = $output;

		$_SESSION['preferedPaymentMethod'] = $name;

		$this->customerData = $loadedData[0];
		return $loadedData;

	}

	protected function changeUserData() {
		$username = $_SESSION['username'];

//		echo '<br>' . json_encode($this->customerData);


		$contactDataId = $this->customerData['cdid'];
		$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : $this->customerData['firstName'];
		$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : $this->customerData['lastName'];
		$emailAddress = !empty($_POST['emailAddress']) ? $_POST['emailAddress'] : $this->customerData['emailAddress'];
		$phoneNumber = !empty($_POST['phoneNumber']) ? $_POST['phoneNumber'] : $this->customerData['phoneNumber'];



		$contactData = new ContactData(['id'=>$contactDataId, 'firstName'=>$firstName, 'lastName'=>$lastName, 'emailAddress'=>$emailAddress, 'phoneNumber'=>$phoneNumber]);

		$contactData->update($this->errors);

		$GLOBALS['customerData']['firstName'] = $firstName;
		$GLOBALS['customerData']['lastName'] = $lastName;
		$GLOBALS['customerData']['emailAddress'] = $emailAddress;
		$GLOBALS['customerData']['phoneNumber'] = $phoneNumber;

	}

	protected function changeAddressData() {
		$username = $_SESSION['username'];
		$contactDataId = $this->customerData['cdid'];
//		echo '<br>' . json_encode($this->customerData);


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

		echo json_encode($this->errors);

		$GLOBALS['customerData']['street'] = $street;
		$GLOBALS['customerData']['number'] = $number;
		$GLOBALS['customerData']['postalCode'] = $postalCode;
		$GLOBALS['customerData']['city'] = $city;
		$GLOBALS['customerData']['country'] = $country;
	}

	public function changeUserPassword($subAction) {
		$this->loadContactData();

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
		$this->loadContactData();
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