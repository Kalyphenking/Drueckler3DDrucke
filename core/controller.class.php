<?php

namespace DDDDD\core;

class Controller
{
	protected $controller  = NULL;
	protected $action 	   = NULL;


	function __construct($controller, $action) {

//		if (isset($_SESSION['currentController']) && ($_SESSION['currentController'] != $controller)) {
//			echo 'not the same <br>';
//			$this->clear();
//		} else (isset($_SESSION['currentController']) && ($_SESSION['currentController'] == $controller)) {
//			$_SESSION['previousController'] = $controller;
//			$_SESSION['previousAction'] = $action;
//		}


		if (isset($_SESSION['currentAction']))
		{
			if($_SESSION['currentAction'] != $action)
			{
				$_SESSION['previousAction'] = $_SESSION['currentAction'];
				$_SESSION['currentAction'] = $action;
			}
		} else {
			$_SESSION['currentAction'] = $action;
		}

		if (isset($_SESSION['currentController']))
		{
			if($_SESSION['currentController'] != $action)
			{
				$_SESSION['previousController'] = $_SESSION['currentController'];
				$_SESSION['currentController'] = $controller;
				echo 'not the same <br>';
				$this->clear();
			}
		} else {
			$_SESSION['currentController'] = $controller;
			$_SESSION['currentAction'] = $action;
		}

		$pc = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
		$pa = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

		echo 'prevController: ' . $pc;
		echo '<br>';
		echo 'prevAction: ' . $pa;
		echo '<br>';

		$this->action = $action;
		$this->controller = $controller;

	}

	function render() {

		$view = VIEWSPATH . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.php';

//		echo $view;

		include $view;
	}

	// delete session variables used in previous controller

	function clear() {

		echo 'clear <br>';

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