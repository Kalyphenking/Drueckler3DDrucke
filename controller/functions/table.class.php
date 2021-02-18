<?php


namespace DDDDD\controller\functions;


class Table
{

	protected $dataSource = null;
	protected $header = null;
	protected $subHeader = null;
	protected $footer = null;
	protected $rows = null;


	function __construct($dataSource = [], $header = [], $subHeader = [], $rows = [], $footer = []) {
		$this->dataSource = $dataSource;
		$this->header = $header;
		$this->subHeader = $subHeader;
		$this->footer = $footer;
		$this->rows = $rows;
	}

	public function render() {
		$output = '<table id="ordersTable">';

		$output .= $this->labelRow($this->header);

		$previousId = 0;
		$summe = 0.0;

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

		$output .= '</tr>';

		return $output;
	}

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

		if ($filledCount == 3) {
			$output .= '
			<td>
                <form action="index.php?c=user&a=cancellOrder" method = "POST">
                	<input type="hidden" name="orderId" value='.$data['oid'].'>
                    <input type="submit" name="submitDelete" value="stornieren">
                </form>
            </td>
        ';
		}

		$filledCount = 0;

		$output .= '</tr>';

		return $output;
	}

}