<?php

//CF3
namespace DDDDD\controller\functions;


class Table
{

	protected $dataSource = null;
	protected $header = null;
	protected $subHeader = null;
	protected $footer = null;
	protected $rows = null;
	protected $inputs = null;
	protected $subHeaderLabelsCount = null;
	protected $dataRowLabelCount = null;

//CF3_F1
	function __construct($dataSource = [], $header = [], $subHeader = [], $rows = [], $footer = [], $inputs = []) {

		foreach ($dataSource as $key => $data) {
			if (empty($data['oid'])) {
				array_splice($dataSource, $key, 1);
			}
		}

		$count = 0;
		foreach ($subHeader as $item) {
			if (!empty($item)) {
				$count ++;
			}
		}
		$this->subHeaderLabelsCount = $count;


		$count = 0;
		foreach ($rows as $item) {
			if (!empty($item)) {
				$count ++;
			}
		}


		$this->dataRowLabelCount = $count;


		$this->dataSource = $dataSource;
		$this->header = $header;
		$this->subHeader = $subHeader;
		$this->footer = $footer;
		$this->rows = $rows;
		$this->inputs = $inputs;
	}
//CF3_F2
	public function render() {
		$output = '<table id="ordersTable">';

		$output .= $this->labelRow($this->header);

		$previousId = 0;
		$summe = 0.0;
		$outputSumme = 0.0;

		foreach ($this->dataSource as $key => $order)
		{

			$orderId = $order['oid'];
			$date = date_format(date_create($order['createdAt']),"d. m. Y");
			$price = $order['modelPrice'];

			if ($orderId == $previousId) {

				$output .= $this->dataRow($order, $this->rows);

			} else {

				if ($summe > 0.0) {
					$output .= $this->labelRow($this->footer, $summe);

				}
				$summe = 0.0;

				$output .= $this->dataRow($order, $this->subHeader);
				$output .= $this->dataRow($order, $this->rows);

			}
			$summe = $summe + $price;
			$outputSumme = number_format($summe, 2, ',', '.');

			$previousId = $orderId;
		}
		$output .= $this->labelRow($this->footer, $outputSumme);

		$output .= '</table>';

		return $output;
	}

//CF3_F3
	protected function labelRow($header, $sum = 0) {
//		$data = $this->dataSource;
		$output = '<tr>';

		foreach ($header as $key => $item) {

			if ($item == 'sum') {
				$output .= '
		            <th>'.$sum.'</th>
		
				';
			} else {
				$output .= '
		            <th>'.$item.'</th>
		
				';
			}
		}

		$inputs = $this->inputs;


		if (!empty($inputs)) {
			if ($sum == 0) {
				$output .= '
		            <th colspan="'.count($this->inputs['inputs']).'">Optionen</th>
		
				';
			} else {
				$output .= '
		            <th colspan="'.count($this->inputs['inputs']).'"></th>
		
				';
			}
		}

		$output .= '</tr>';

		return $output;
	}
//CF3_F4
	protected function dataRow($data = [], $dataRow = []) {
//		$data = $this->dataSource;
		$output = '<tr>';
		$filledCount = 0;

		foreach ($dataRow as $key => $item) {
			if ($item === '') {
				$output .= '
		            <td></td>
		
				';
			} else {
				$output .= '
		            <td>'.$data[$key].'</td>
		
				';
				$filledCount ++;
			}
		}

		$inputs = $this->inputs;

		if (!empty($inputs)) {

			if ($inputs['inSubHeader']) {
				$number = $this->subHeaderLabelsCount;
			} else {
				$number = $this->dataRowLabelCount;
			}

			if ($filledCount == $number) {

				$output .= '
				<td>
	                <form action="'.$inputs['action'].'" method = "POST">
	                    <input type="hidden" name="orderId" value='.$data['oid'].'>';

				foreach ($inputs['inputs'] as $input) {
					$output .= $input;
				}

				$output .= '
		                </form>
		            </td>
		        ';
			} else {
				$output .= '
		            <td colspan="'.count($this->inputs['inputs']).'"></td>
		
				';
			}
		}

		$filledCount = 0;

		$output .= '</tr>';

		return $output;
	}

}