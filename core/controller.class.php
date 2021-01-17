<?php

namespace DDDDD\core;

class Controller
{
	protected $controller  = NULL;
	protected $action 	   = NULL;


	function __construct($controller, $action) {
		$this->action = $action;
		$this->controller = $controller;

	}

	function render() {

		$view = VIEWSPATH . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.php';

		echo $view;

		include $view;
	}
}