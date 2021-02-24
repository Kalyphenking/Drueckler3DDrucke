<?php

//CF1
namespace DDDDD\controller\functions;


use DDDDD\model\PaymentData;

class ChangePaymentData
{
//CF1_F1
	function __construct() {
		$this->username = isset($_SESSION['customerName']) ? $_SESSION['customerName'] : $_SESSION['uid'];
		$this->customerData = $_SESSION['customerData'];

//		$this->{$function}();
	}
//CF1_F2
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

					$paymentData->validate($this->errors);

					if (empty($this->errors)) {
						$paymentData->update($this->errors);

					} else {
						$_SESSION['error'] = '';
						foreach ($this->errors as $item) {
//								echo json_encode($this->errors);
							$_SESSION['error'] .= $item[0];
							$_SESSION['error'] .= '<br>';
						}
					}


				}

//			}
		}


	}
}