<?php

namespace DDDDD\controller\functions;

use DDDDD\model\Address;
use DDDDD\model\CreditCard;
use DDDDD\model\DirectDebit;
use DDDDD\model\PaymentData;
use DDDDD\model\Paypal;

//class to access functions for paymentdata changes

class PaymentFunction
{

	protected $username = null;
	protected $customerData = null;
	protected $errors = null;

	//calls functions selected by url (a=orderController/setDirectDebit)

	function __construct($function) {
		$this->username = $_SESSION['username'];
		$this->customerData = $_SESSION['customerData'];

		$this->{$function}();
	}


	protected function setDirectDebit() {
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

				//TODO: errorHandling

				$loadedData = $directDebitData->find(['id'], [$directDebitId]);


				if (empty($loadedData)) {

					$db = $GLOBALS['db'];
					if (empty($paymentDataId)) {

						//inserts directDebitData in database and inserts newest DirectDebit_id into PaymentData
						//updates Customer with newest PaymentData_id
						//to reduce database request, this will processed in one request

						$directDebitData->insert($this->errors,
							['INSERT INTO PaymentData (DirectDebit_id)	
								VALUES (LAST_INSERT_ID());',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {

						//inserts directDebitData in database and updates newest DirectDebit_id into PaymentData

						$directDebitData->insert($this->errors,
							['UPDATE PaymentData set DirectDebit_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					}


				} else {
					$directDebitData->update($this->errors);
				}

			} else {
				//TODO errorHandling
			}
		}
		$loadedData = $this->loadDirectDebitData();
		$GLOBALS['paymentData'] = $loadedData[0];
	}

	protected function setCreditCard() {
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
				$numberShort = '************' . substr($_POST['number'], 12, 4);
				$type = $_POST['type'];
				$owner = $_POST['owner'];
				$expiryDate = $_POST['expiryDateMonth'] . '/' . $_POST['expiryDateYear'];
				$securityCode = $_POST['securityCode'];


				$creditCardData = new CreditCard(['id'=>$creditCardId,
					'number'=>$number,
					'numberShort'=>$numberShort,
					'type'=>$type,
					'owner'=>$owner,
					'expiryDate'=>$expiryDate,
					'securityCode'=>$securityCode]);

				$loadedData = $creditCardData->find(['id'], [$creditCardId]);

				if (empty($loadedData)) {

					$db = $GLOBALS['db'];
					if (empty($paymentDataId)) {

						//inserts creditCardData in database and inserts newest CreditCard_id into PaymentData
						//updates Customer with newest PaymentData_id
						//to reduce database request, this will processed in one request

						$creditCardData->insert($this->errors,
							['INSERT INTO PaymentData (CreditCard_id)	
								VALUES (LAST_INSERT_ID());',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {

						//inserts creditCardData in database and updates newest creditCardData into PaymentData

						$creditCardData->insert($this->errors,
							['UPDATE PaymentData set CreditCard_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					}
				} else {
					$creditCardData->update($this->errors);
				}

			} else {
				//TODO errorHandling
			}
		}
		$loadedData = $this->loadCreditCardData();
		$GLOBALS['paymentData'] = $loadedData[0];
	}

	protected function setBill() {
		$GLOBALS['selectedPaymentMethod'] = 'setBill';

		$loadedData = $this->loadBillData();
		$GLOBALS['paymentData'] = $loadedData[0];


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

					//inserts billAddressData in database and inserts newest Bill_id into PaymentData
					//updates Customer with newest PaymentData_id
					//to reduce database request, this will processed in one request

					$billAddressData->insert($this->errors,
						['INSERT INTO PaymentData (Bill_id)	
								VALUES (LAST_INSERT_ID());',

							'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
				} else {

					//inserts billAddressData in database and updates newest Bill_id into PaymentData

					$billAddressData->insert($this->errors,
						['INSERT INTO Bill (Address_id) VALUES (LAST_INSERT_ID());',
							'UPDATE PaymentData set Bill_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
				}
			} else {
				$billAddressData->update($this->errors);
			}

			$GLOBALS['paymentData']['street'] = $street;
			$GLOBALS['paymentData']['number'] = $number;
			$GLOBALS['paymentData']['postalCode'] = $postalCode;
			$GLOBALS['paymentData']['city'] = $city;
			$GLOBALS['paymentData']['country'] = $country;

		}

	}

	protected function setPayPal() {
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

						//inserts paypalData in database and inserts newest Paypal_id into PaymentData
						//updates Customer with newest PaymentData_id
						//to reduce database request, this will processed in one request

						$paypalData->insert($this->errors,
							['INSERT INTO PaymentData (Paypal_id)	
								VALUES (LAST_INSERT_ID());',

								'UPDATE Customer SET PaymentData_id = LAST_INSERT_ID() where id = ' . $customerId . ' ;']);
					} else {

						//inserts paypalData in database and updates newest Paypal_id into PaymentData

						$paypalData->insert($this->errors,
							['UPDATE PaymentData set Paypal_id = LAST_INSERT_ID() where id = '
								. $customerId .
								' ;']);
					}
				} else {
					$paypalData->update($this->errors);
				}

			} else {
				//TODO errorHandling
			}
		}

		$payPalData = $this->loadPayPalData()[0];
		$GLOBALS['paymentData'] = $payPalData;
	}


	protected function loadDirectDebitData() {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
				'pd.id as pdid',

				'dd.ibanShort',
				'dd.owner',
				'dd.mandate',
				'dd.id as ddid'

			], ['username'], [$this->username]);

		return $loadedData;
	}

	protected function loadCreditCardData() {

		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
				'pd.id as pdid',

				'cc.type',
				'cc.owner',
				'cc.expiryDate',
				'cc.numberShort',
				'cc.id as ccid'

			], ['username'], [$this->username]);

		return $loadedData;
	}

	protected function loadBillData() {

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

			], ['username'], [$this->username]);

		return $loadedData;
	}

	protected function loadPayPalData() {



		$loadedData = PaymentData::findOnJoin(
			'paymentData',
			['pd.preferedPaymentMethod',
				'pd.id as pdid',

				'pp.emailAddress',
				'pp.id as ppid'

			], ['username'], [$this->username]);

		return $loadedData;
	}
}