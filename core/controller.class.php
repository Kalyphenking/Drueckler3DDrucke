<?php
//Co1
namespace DDDDD\core;

//controller parent class
class Controller
{
	protected $controller  = null;
	protected $action 	   = null;
	protected $subAction   = null;

//Co1_F1
	function __construct($controller, $action, $subAction = null) {

//		if (isset($_SESSION['makeOrder']) && $_SESSION['makeOrder'] == true) {
			unset($_SESSION['error']);
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
				if ($_SESSION['currentAction'] != 'login' && $action != 'login' && $_SESSION['currentAction'] != 'register' && $action != 'register') {
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
//Co1_F2
	function loggedIn() {
//		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true && isset($_SESSION['customerName']));
		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true);
	}
//Co1_F3
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

//		$this->debug();

		$view = VIEWSPATH . $this->controller . '/' . $this->action . '.php';
		if (file_exists($view)) {
			echo '<div class="parent">';

			echo '<div class="rechts"></div>';
			echo '<div class="links"></div>';


			include_once(VIEWSPATH . 'main' . '/' . 'navbard.php');

//			echo '<div class="content" >';

			switch ($this->controller) {
				case 'main':

					echo "<div class=\"main-container\">";


					break;
				case 'management':

					echo "<div class=\"management-container\">";
					include_once (VIEWSPATH.'management'.'/'.'managementMenuBar.php');

					break;
				case 'order':
					echo "<div class=\"order-container\">";
//					if ($this->action == 'shoppingCart') {
//						echo "<div class=\"shoppingCart-container\">";
//					} else if($this->action == 'checkout') {
//						echo "<div class=\"checkout-container\">";
//					}  else if($this->action == 'configurator') {
//						echo "<div class=\"configurator-container\">";
//					} else {
//						echo "<div class=\"order-container\">";
//					}
//						include_once (VIEWSPATH.'order'.'/'.'orderProgressBar.php');


					break;
				case 'user':
					echo '<div class="user-container">';

					include_once VIEWSPATH.'user/userMenuBar.php';


					break;
			}

			include $view;


			echo "<script>javaScriptEnabled()</script>";

//			echo "</div>";
			echo "</div>";

			include_once(VIEWSPATH . 'main/infoBar.php');
			echo '</div>';

		} else {

			$link = 'html/404.html';
//			header("Location: $link ");

			die('404 action you call does not exists');
		}



//		echo $view;


	}

//Co1_F4
	//TODO: delete session variables used in previous controller
	function clear() {
		if (isset($_SESSION['filaments'])) {
			unset ($_SESSION['filaments']);
		}

	}
//Co1_F5
	public function __destruct()
	{
		$this->controller = null;
		$this->action = null;
	}
}