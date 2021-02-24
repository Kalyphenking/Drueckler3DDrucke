<?php


namespace DDDDD\controller;
//C2
//manages management related functions

use DDDDD\controller\functions\Table;
use DDDDD\core\Controller;
use DDDDD\model\Customer;
use DDDDD\model\Employee;
use DDDDD\model\Order;

class ManagementController extends Controller
{
	protected $errors = null;
	protected $employeeId = null;
//C2_F1
	public function __construct($controller, $action, $subAction = null)
	{

		parent::__construct($controller, $action, $subAction);
		if (!isset($_SESSION['employeeData'])) {
//			echo 'load employeeData <br>';
			$this->loadEmployeeData();
		}
//		$this->loadAllEmployeeData();
		if (!isset($_SESSION['allEmployee']) && isset($_SESSION['admin'])) {
//			echo 'load employeeData';
			$this->loadAllEmployeeData();
		}

		$employeeData = $_SESSION['employeeData'];
//		echo json_encode($employeeData);
		$this->employeeId = $employeeData['empid'];


	}
//C2_F2
	public function admin($subAction) {
		$orders = $this->loadAllOrders();

	}
//C2_F3
	public function manageOrders($subAction) {

		if (isset($_POST['selectedEmployee'])) {
//			echo $_POST['orderId'] . ': ' . $_POST['selectedEmployee'];
			$order = new Order(['id' => $_POST['orderId'], 'Employee_id' => $_POST['selectedEmployee']]);
			$order->update($this->errors);
			unset($order);
		}

		if (isset($_POST['finishedOrder'])) {
//			echo $_POST['orderId'] . ': ' . $_POST['selectedEmployee'];
			$order = new Order(['id' => $_POST['orderId'], 'processed' => true]);
			$order->update($this->errors);
			unset($order);
		}

		$this->loadAllOrders();

		$this->loadCustomerData();

		$GLOBALS['selectedOrderList'] = $subAction;

		$employeeData = isset($_SESSION['allEmployee']) ? $_SESSION['allEmployee'] : null;

		$subAction = !empty($subAction) ? $subAction : 'openOrders';

		$orders = isset($_SESSION[$subAction]) ? $_SESSION[$subAction] : [];

		if (isset($_SESSION['employee'])) {
			$data = [];

			foreach ($orders as $order) {
				if ($order['Employee_id'] == $this->employeeId) {
					$data[] = $order;
				}
			}

			$orders = $data;
		}




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

		$input = [];

		if (isset($_SESSION['admin'])) {
			switch ($subAction) {
				case 'openOrders':
					if (!empty($employeeData)) {
						$input = [
							'action' => 'index.php?c=management&a=manageOrders/'.$subAction.'',
							'inputs' => [
								'
										<label>Mitarbeiter ID:</label>
										<input type="number"
					                   name="selectedEmployee"
					                   id="selectedEmployee"
					                   min="1"
					                   max="'.(count($employeeData)).'"
					                   placeholder="1"
					                   required>
				                ',
											' <input type="submit"
				                   name="submitEmployee"
				                   value="in Arbeit geben">
				                '
							],
							'inSubHeader' => true
						];
					}
					break;
				case 'ordersInProcess':
					$header['Employee_id'] = 'MitarbeiterNummer';
					$subHeader['Employee_id'] = 'MitarbeiterNummer';
					$dataRow['Employee_id'] = '';
					$footer[] = '';

					break;
				case 'finishedOrders':
					break;
			}
		} else {
			$input = [
				'action' => 'index.php?c=management&a=manageOrders/'.$subAction.'',
				'inputs' => [
					' <input type="submit"
	                   name="finishedOrder"
	                   value="Bestellung abschließen">
	                '
				],
				'inSubHeader' => true
			];
		}





		$table = new Table($orders, $header, $subHeader, $dataRow, $footer, $input);

		$GLOBALS['ordersTable'] = $table->render();

	}
//C2_F4
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
//C2_F5
	protected function loadAllOrders() {
		$orders = Order::findOnJoin(
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
		$finishedOrders = [];

		if (isset($_SESSION['employee'])) {
			$data = [];

			foreach ($orders as $order) {

				if ($order['Employee_id'] == $this->employeeId) {
//					echo json_encode($order) . '<br>';
					$data[] = $order;
				}
			}

			$orders = $data;
		}

		foreach ($orders as $order) {
//			echo json_encode($order) .  '<br>';
			if (!empty($order['oid'])) {
//				echo json_encode($order) .  '<br>';
				if ($order['processed'] == true) {
//					echo json_encode($order) .  '<br>';
					$finishedOrders[] = $order;
				} else if (!empty($order['Employee_id'])) {
//					echo json_encode($order) .  '<br>';
					$ordersInProcess[] = $order;
				} else {
//					echo json_encode($order) .  '<br>';
					$openOrders[] = $order;
				}

			} else {
//				echo json_encode($order) .  '<br>';
			}
		}

		$_SESSION['openOrders'] = $openOrders;
		$_SESSION['ordersInProcess'] = $ordersInProcess;
		$_SESSION['finishedOrders'] = $finishedOrders;
	}

//C2_F6
	protected function loadEmployeeData() {

		if ($this->loggedIn()) {
			$this->username = $_SESSION['username'];
//			echo json_encode($this->username);

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
//			echo json_encode($loadedData);

			$_SESSION['employeeData'] = $loadedData[0];
		}

		return;

	}
//C2_F7
	protected function loadAllEmployeeData() {

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

				]
			);

			$customerData = null;

			foreach ($loadedData as $key => $data) {

				if (!empty($data['empid'])) {
					$customerData[] = $data;
				}
			}

			$_SESSION['allEmployee'] = $customerData;
		}

		return;

	}
//C2_F8
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
//C2_F9
	public function manageEmployee() {

	}

}