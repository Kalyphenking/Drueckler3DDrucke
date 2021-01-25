<?php

namespace DDDDD\core;


class Controller
{
	protected $controller  = NULL;
	protected $action 	   = NULL;


	function __construct($controller, $action) {

//		echo 'controller: ' . $controller;
//		echo '<br>';
//		echo 'action: ' . $action;
//		echo '<br>';
//		echo '<br>';

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
		$this->action = $action;
		$_SESSION['currentController'] = $controller;
		$this->controller = $controller;

	}

	function loggedIn() {
		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true);
	}

	function render() {
//		if (isset($_POST['testing'])) {

            $loggedIn = isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';


//            echo 'controllerName: ' . $this->controller;
//            echo '<br>';
//            echo 'actionName: ' . $this->action;
//            echo '<br>';
//			echo '<br>';
//			echo 'currentController: ' . $_SESSION['currentController'];
//            echo '<br>';
//			echo 'currentAction: ' . $_SESSION['currentAction'];
//			echo '<br>';
//			echo '<br>';
//			echo 'previousController: ' . $_SESSION['previousController'];
//			echo '<br>';
//			echo 'previousAction: ' . $_SESSION['previousAction'];
//			echo '<br>';
//			echo '<br>';
//            echo 'loggedIn: ' . $loggedIn;
//            echo '<br>';
//            echo 'username: ' . $username;
//            echo '<br>';
//            echo '<br>';
//        }

		$view = VIEWSPATH . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.php';

		if (file_exists($view)) {

			if ($this->action != 'login' && $this->action != 'register') {
				echo "<div class=\"grid-container\">";

				include_once(VIEWSPATH . 'main' . DIRECTORY_SEPARATOR . 'navbard.php');

				include $view;

				if ($this->controller == 'user') {
					include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');
				}

				echo "</div>";
			} else {
				include_once(VIEWSPATH . 'main' . DIRECTORY_SEPARATOR . 'navbard.php');
				include $view;
			}



		} else {
			die('404 action you call does not exists');
		}



//		echo $view;


	}

	// delete session variables used in previous controller

	function clear() {

//		echo 'clear <br>';

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