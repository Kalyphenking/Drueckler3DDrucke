<?php

namespace DDDDD\core;

class controller
{
	protected $controller  = 'main';
	protected $action 	   = 'main';

	function __constructor($controller, $action) {
		$this->action = $action;
		$this->controller = $controller;
	}

	function render() {

		$view = VIEWSPATH . DIRECTORY_SEPARATOR . $this->controller . DIRECTORY_SEPARATOR . $this->action . '.php';

		include $view;
	}
}