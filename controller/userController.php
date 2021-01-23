<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;
use DDDDD\model\Customer;
use DDDDD\model\Orders;
use DDDDD\model\PrintConfig;

class UserController extends Controller
{

	public function usermenu() {
		$this->loadUserData();
	}

	public function loadUserData() {




		if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
			$username = $_SESSION['username'];

			$userdata = ContactData::find(['username'], [$username]);

			ContactData::constructFromUserData($userdata);


		}

	}


	public function orders()
	{


		$GLOBALS['orders'] = $this->loadOrders('o');
		$GLOBALS['suborders'] = $this->loadOrders('pc');

//		echo 'orders: <br>' . json_encode($_SESSION['orders']) . '<br><br>';
	}


	public function loadOrders($idFrom)
	{
		$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

		$orders = Orders::findOrder([
			$idFrom.'.id',
			'o.createdAt',
			'm.modelPrice',
			'o.processed',
			'm.fileName',
			'o.payed'

			,
			'pc.amount',
			'pc.printTime',
			'ps.infill',
			'ps.description',
			'f.color',
			'f.type',
			'o.cancelled'
			],

			['username'],

			['habe']); // Hier $username einfügen


		return $orders;
	}

	public function cancellOrder()
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

	public function details()
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