<?php

namespace DDDDD\core;

class Controller
{
	protected $controller  = NULL;
	protected $action 	   = NULL;


	function __construct($controller, $action) {

		if (isset($_SESSION['currentControllerName']) && ($_SESSION['currentControllerName'] != $controller)) {
			echo 'not the same <br>';
			$this->clear();
		}
		$_SESSION['currentControllerName'] = $controller;

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
}