<?php
$orders = isset($GLOBALS['orders']) ? $GLOBALS['orders'] : [];

//echo json_encode($orders);

include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');


function headerRow() {
	$output = "
        <tr>
            <th>OrderID</th>
            <th>Datum</th>
            <th>Dateiname</th>
            <th>Preis</th>
            <th>Status</th>
            <th colspan=\"2\">Options</th>

        </tr>
    ";

	return $output;
}

function orderHeadRow($orderid, $date) {
	$output = "
        <tr>
            <td>$orderid</td>
            <td>$date</td>
            <td></td>
            <td></td>
            <td></td>						
            <td></td>
            <td></td>
            
        </tr>
    ";

	return $output;
}

function orderRow($fileName, $price, $processed, $suborderId) {
	$selectedOrderList = isset($GLOBALS['selectedOrderList']) ? $GLOBALS['selectedOrderList'] : 'openOrders';

	$output = "
         <tr>
            <td></td>
            <td></td>
            <td>$fileName</td>
            <td>$price €</td>
            <td>$processed</td>
            
                <td>
                     <form action='index.php?c=admin&a=adminOrders".DIRECTORY_SEPARATOR.$selectedOrderList." method = 'POST'>
                        <input type='hidden' name=\"orderId\" value=$suborderId>
                        <input type='submit' name=\"submit\" value='stornieren'>
                    </form>
                </td>
                <td>
                    <form action = 'index.php?c=user&a=details' method = 'POST'>
                        <input type='hidden' name=\"orderId\" value=$suborderId>
                        <input type='submit' name=\"submit\" value='Details'>
                    </form>
                </td>
        </tr>";

	return $output;
}

function summRow($summe) {

	$output = "
        <tr id='summe'>
            <td>Summe:</td>
            <td></td>
            <td></td>
            <td>$summe €</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    ";

	return $output;
}

function presentOrders($orderList) {
	echo headerRow();

	$previousId = 0;
	$summe = 0.0;

	foreach ($orderList as $key => $order)
	{

		$orderid = $order['oid'];
		$suborderId = $order['pcid'];
		$date = date_format(date_create($order['createdAt']),"d. m. Y");
		$price = $order['modelPrice'];
		$processed = $order['processed'] ? 'Ja' : 'Nein';
		$fileName = $order['fileName'];

		if ($orderid == $previousId) {

			echo orderRow($fileName, $price, $processed, $suborderId);

		} else {

			if ($summe > 0.0) {
				echo summRow($summe);

			}
			$summe = 0.0;

			echo orderHeadRow($orderid, $date);

			echo orderRow($fileName, $price, $processed, $suborderId);

		}
		$summe = $summe + $price;

		$previousId = $orderid;
	}
	echo summRow($summe);
}

$table = $GLOBALS['ordersTable'];

?>



<div class="userContent">
    <table id="ordersTable">
		<?php
//		presentOrders($orders);

        echo $table;

		?>

    </table>
</div>