<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Orders;

class UserController extends Controller
{

	public function orders()
	{
		$this->loadOrders();

		echo 'orders: <br>' . json_encode($_SESSION['orders']) . '<br><br>';
	}


	public function loadOrders()
	{
		$orders = Orders::find();

		$_SESSION['orders'] = $orders;
	}

}