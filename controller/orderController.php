<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\Filaments;
use DDDDD\model\PrintSettings;


class OrderController extends Controller
{

	protected $filaments = NULL;

	public function configurator() {

		if (!isset($GLOBALS['filaments']) || empty($GLOBALS['filaments']) || empty($this->filaments)) {
//			echo 'request <br>';
			$this->loadFilaments();
		}



		if (isset($_POST['submit'])) {
			$this->calculateModel();
		}
	}

	protected function calculateModel() {
		$infill = isset($_POST['infill']) ? $_POST['infill'] : 0.7;
		$resolution = isset($_POST['resolution']) ? $_POST['resolution'] : 0.2;
		$filament = isset($_POST['filament']) ? $this->filaments[$_POST['filament']] : $this->filaments[0];

//		echo 'infill: ' . $infill;
//		echo '<br>';
//		echo 'resolution: ' . $resolution;
//		echo '<br>';
//		echo 'filament: ' . json_encode($filament);
//		echo '<br>';



	}

	protected function loadFilaments() {
		$this->filaments = Filaments::find();

		$GLOBALS['filaments'] = $this->filaments;
	}




	public function presets() {
		$this->loadPresets();




		echo 'preset: <br>' . json_encode($_SESSION['presets']) . '<br><br>';


	}

	protected function loadPresets() {
		$data = PrintSettings::find();
		$presets = [];

		foreach($data as $key => $preset) {
			if (!empty($preset['description'])) {
				$presets[] = $preset;
			}
		}

		$_SESSION['presets'] = $presets;
	}

	protected function loadPricing() {
		return 'KLAPPT';
	}


}