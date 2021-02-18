<?php


namespace DDDDD\controller;

//manages admin related functions

use DDDDD\controller\functions\Table;
use DDDDD\core\Controller;
use DDDDD\model\Customer;
use DDDDD\model\Employee;
use DDDDD\model\Order;

class AdminController extends Controller
{
	public function __construct($controller, $action, $subAction = null)
	{

		parent::__construct($controller, $action, $subAction);
		if (!isset($_SESSION['employeeData'])) {
			echo 'load employeeData';
			$this->loadEmployeeData();
		}
	}

	public function admin($subAction) {
		$orders = $this->loadAllOrders();

	}

	public function adminOrders($subAction) {
		$this->loadAllOrders();
		$this->loadCustomerData();
		$GLOBALS['selectedOrderList'] = $subAction;

		$subAction = !empty($subAction) ? $subAction : 'openOrders';


		$orders = isset($_SESSION[$subAction]) ? $_SESSION[$subAction] : [];

		$header = [
			'oid' => 'Bestellnummer',
			'createdAt' => 'Bestelldatum',
			'fileName' => 'Dateiname',
			'modelPrice' => 'Preis',
			'processed' => 'Status'
		];

		$subHeader = [
			'oid' => 'Bestellnummer',
			'createdAt' => 'Bestelldatum',
			'fileName' => '',
			'modelPrice' => '',
			'processed' => ''
		];

		$dataRow = [
			'oid' => '',
			'createdAt' => '',
			'fileName' => 'Dateiname',
			'modelPrice' => 'Preis',
			'processed' => 'Status'

		];

		$footer = [
			'Summe',
			'',
			'',
			'sum',
			''
		];

		$table = new Table($orders, $header, $subHeader, $dataRow, $footer);

		$GLOBALS['ordersTable'] = $table->render();

	}

	protected function loadCustomerData() {

		if ($this->loggedIn()) {
			$this->username = $_SESSION['username'];

			$loadedData = Customer::findOnJoin(
				'customerData',
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

				]
			);

			$_SESSION['customerData'] = $loadedData;
//			echo json_encode($_SESSION['customerData']);
		}
	}

	protected function loadAllOrders() {
		$data = Order::findOnJoin(
			'orders',
			[
				'o.id as oid',
				'o.createdAt',
				'o.processed',
				'o.payed',
				'o.Employee_id',
				'o.cancelled',

				'm.modelPrice',
				'm.fileName',

				'pc.id as pcid',
				'pc.amount',
				'pc.printTime',

				'ps.infill',
				'ps.description',

				'f.color',
				'f.type'
			]
		);

		$openOrders = [];
		$ordersInProcess = [];
		$doneOrders = [];

		foreach ($data as $order) {
			if (!empty($order['oid'])) {
//				echo json_encode($order) .  '<br>';
//				echo json_encode($order['Employee_id']). '<br>';

				if ($order['processed'] == true) {
					$doneOrders[] = $order;
				} else if (!empty($order['Employee_id'])) {
					$ordersInProcess[] = $order;
				} else {
					$openOrders[] = $order;
				}

			}
		}

		$_SESSION['openOrders'] = $openOrders;
		$_SESSION['ordersInProcess'] = $ordersInProcess;
		$_SESSION['finishedOrders'] = $doneOrders;
	}

	protected function loadEmployeeData() {

		if ($this->loggedIn()) {
			$this->username = $_SESSION['username'];

			$loadedData = Employee::findOnJoin(
				'contactData',
				[
					'emp.id as empid',

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
					'a.country'

				],

				['username'],

				[$this->username]);

			$_SESSION['employeeData'] = $loadedData[0];
		}

		return;

	}

	public function ordersInProcess() {
//		echo json_encode($_SESSION['ordersInProcess']) . '<br>';

		$header = [
			'oid' => 'Bestellnummer',
			'createdAt' => 'Datum',
			'fileName' => 'Dateiname',
			'modelPrice' => 'Preis',
			'processed' => 'Auftrag verarbeitet'
		];

		$table = new Table($_SESSION['ordersInProcess'], $header);

		$GLOBALS['table'] = $table->render();
	}

}