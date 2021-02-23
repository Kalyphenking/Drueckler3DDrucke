<?php

namespace DDDDD\core;

//controller parent class
class Controller
{
	protected $controller  = null;
	protected $action 	   = null;
	protected $subAction   = null;


	function __construct($controller, $action, $subAction = null) {


		unset($_SESSION['error']);
//		if (!isset($_SESSION['makeOrder']) || empty($_SESSION['makeOrder'])) {
//			echo 'NO ORDER <br>';
//
//		} else {
//			echo 'ORDER <br>';
//
//		}

		$this->subAction = $subAction;

		if (!isset($_SESSION['uid'])) {
			$uniqid = uniqid();
			$_SESSION['uid'] = $uniqid;
		}

		if (isset($_SESSION['currentAction']))
		{
			if($_SESSION['currentAction'] != $action)
			{
				if ($_SESSION['currentAction'] != 'login' && $action != 'register') {
					$_SESSION['previousController'] = $_SESSION['currentController'];
					$_SESSION['currentController'] = $controller;

					$_SESSION['previousAction'] = $_SESSION['currentAction'];
					$_SESSION['currentAction'] = $action;
					$this->clear();
				}

			}
		}
		$_SESSION['currentAction'] = $action;
		$_SESSION['currentController'] = $controller;


		// prevent not loggedIn user to access page part "user"
		if ($controller == 'user') {
			if ($this->loggedIn()) {
				$this->action = $action;
				$this->controller = $controller;
			} else {
				$this->action = 'main';
				$this->controller = 'main';
			}
		} else {
			$this->action = $action;
			$this->controller = $controller;
		}

//		echo 'previousController: ' . $_SESSION['previousController'];
//		echo '<br>';
//		echo 'currentController: ' . $_SESSION['currentController'];
//		echo '<br>';
//		echo '<br>';
//		echo 'previousAction: ' . $_SESSION['previousAction'];
//		echo '<br>';
//		echo 'currentAction: ' . $_SESSION['currentAction'];
//		echo '<br>';
//		echo '<br>';
	}

	function loggedIn() {
//		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && isset($_SESSION['customerName']));
		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true);
	}

	function debug() {
		$loggedIn = isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;
            $username = isset($_SESSION['customerName']) ? $_SESSION['customerName'] : '';


            echo 'controllerName: ' . $this->controller;
            echo '<br>';
            echo 'actionName: ' . $this->action;
            echo '<br>';
			echo '<br>';
			echo 'currentController: ' . $_SESSION['currentController'];
            echo '<br>';
			echo 'currentAction: ' . $_SESSION['currentAction'];
			echo '<br>';
			echo '<br>';
			echo 'previousController: ' . $_SESSION['previousController'];
			echo '<br>';
			echo 'previousAction: ' . $_SESSION['previousAction'];
			echo '<br>';
			echo '<br>';
            echo 'loggedIn: ' . $loggedIn;
            echo '<br>';
            echo 'username: ' . $username;
            echo '<br>';
            echo '<br>';
	}

	function render() {
		$view = VIEWSPATH . $this->controller . '/' . $this->action . '.php';
		if (file_exists($view)) {
			echo '<div class="mainContainer">';

			include_once(VIEWSPATH . 'main' . '/' . 'navbard.php');

			echo '<div class="content" >';

			switch ($this->controller) {
				case 'main':

//					echo "<div class=\"mainGrid-container\">";


					break;
				case 'management':

//					echo "<div class=\"management-container\">";
					include_once (VIEWSPATH.'management'.'/'.'managementMenuBar.php');

					break;
				case 'order':

					if ($this->action == 'shoppingCart') {
//						echo "<div class=\"shoppingCart-container\">";
					} else if($this->action == 'checkout') {
//						echo "<div class=\"checkoutGrid-container\">";
					} else {
//						echo "<div class=\"orderGrid-container\">";
					}
//						include_once (VIEWSPATH.'order'.'/'.'orderProgressBar.php');


					break;
				case 'user':
//					echo "<div class=\"userGrid-container\">";
					include_once (VIEWSPATH.'user'.'/'.'userMenuBar.php');

					break;
			}

			include $view;

			echo "<script>javaScriptEnabled()</script>";

//			echo "</div>";
			echo "</div>";

			include_once(VIEWSPATH . 'main/infoBar.php');
			echo '</div>';

		} else {

			$link = '404.html';
			header("Location: $link ");

			die('404 action you call does not exists');
		}



//		echo $view;


	}


	//TODO: delete session variables used in previous controller
	function clear() {
		if (isset($_SESSION['filaments'])) {
			unset ($_SESSION['filaments']);
		}

	}

	public function __destruct()
	{
		$this->controller = null;
		$this->action = null;
	}
}