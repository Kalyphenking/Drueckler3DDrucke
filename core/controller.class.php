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

		if (isset($_SESSION['currentController']))
		{
			if ($_SESSION['currentController'] != $controller)
			{
				$_SESSION['previousController'] = $_SESSION['currentController'];
				$_SESSION['currentController'] = $controller;
				$this->clear();
			}
		}
		$_SESSION['currentController'] = $controller;
		$this->controller = $controller;



		if (isset($_SESSION['currentAction']))
		{
			if($_SESSION['currentAction'] != $action)
			{
				$_SESSION['previousController'] = $_SESSION['currentController'];
				$_SESSION['currentController'] = $controller;
				$_SESSION['previousAction'] = $_SESSION['currentAction'];
				$_SESSION['currentAction'] = $action;
			}
		}
		$_SESSION['currentAction'] = $action;
		$this->action = $action;


	}

	function loggedIn() {
		return (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true);
	}

	function render() {


		if (isset($_POST['testing'])) {

            $loggedIn = isset($_SESSION['loggedIn']) ? $_SESSION['loggedIn'] : false;
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';


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

		$view = VIEWSPATH . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.php';

		if (file_exists($view)) {
			include $view;
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