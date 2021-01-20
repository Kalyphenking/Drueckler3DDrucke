<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Filaments;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	public function configuration() {



		if (!isset($_SESSION['filaments']) || empty($_SESSION['filaments'])) {
//			echo 'request <br>';
			$this->loadFilaments();
		}


		if (isset($_POST['submit'])) {

		}
	}

	public function loadFilaments() {
		$filaments = Filaments::find();

		$_SESSION['filaments'] = $filaments;
	}

	public function calcPrice() {

	}

	public function presets() {
		$this->loadPresets();



		echo 'preset: <br>' . json_encode($_SESSION['presets']) . '<br><br>';


	}

	function loadPresets() {
		$data = PrintSettings::find();
		$presets = [];

		foreach($data as $key => $preset) {
			if (!empty($preset['description'])) {
				$presets[] = $preset;
			}
		}

		$_SESSION['presets'] = $presets;
	}

	public function loadPricing() {
		return 'KLAPPT';
	}

	public function unsetSession() {
		if (isset($_SESSION['filaments'])) {
			unset ($_SESSION['filaments']);
		}
	}



}