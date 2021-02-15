<?php


namespace DDDDD\controller\functions;


use DDDDD\model\PaymentData;

class ChangePaymentData
{

	function __construct() {
		$this->username = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['uid'];
		$this->customerData = $_SESSION['customerData'];

//		$this->{$function}();
	}

	public function changePaymentData($subAction = 'setDirectDebit', $preferedPaymentMthod = '') {
		$action = 'setDirectDebit';

		if (!empty($subAction)) {
			$action = $subAction;
			$GLOBALS['selectedPaymentMethod'] = $subAction;
		}

		$paymentFunction = new PaymentFunction($action);
//		$GLOBALS['selectedPaymentMethod'] = $action;

		if (method_exists($paymentFunction, $action)) {
//			if (isset($_POST['submit'])) {

//				if (isset($_POST['preferedPaymentMethod'])) {
				if (!empty($preferedPaymentMthod)) {
					switch ($action) {
						case 'setDirectDebit':
							$preferedPaymentMethod = 'dd';
							break;
						case 'setCreditCard':
							$preferedPaymentMethod = 'cc';
							break;
						case 'setPayPal':
							$preferedPaymentMethod = 'pp';
							break;
					}
					$paymentData = new PaymentData(['id'=>$this->customerData['pdid'], 'preferedPaymentMethod'=>$preferedPaymentMethod]);

					$paymentData->update($this->errors);
				}

//			}
		}
	}
}