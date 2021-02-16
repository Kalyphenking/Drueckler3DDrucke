<?php
$openOrders = isset($_SESSION['openOrders']) ? $_SESSION['openOrders'] : [];
$ordersInProcess = isset($_SESSION['ordersInProcess']) ? $_SESSION['ordersInProcess'] : [];
$doneOrders = isset($_SESSION['doneOrders']) ? $_SESSION['doneOrders'] : [];

echo '<br>openOrders: <br>'.json_encode($openOrders).'<br>';
echo '<br>ordersInProcess: <br>'.json_encode($ordersInProcess).'<br>';
echo '<br>doneOrders: <br>'.json_encode($doneOrders).'<br>';


?>

<div class="adminMenuBar">

</div>


<?php


function headerRow() {
	$output = "
        <tr>
            <th>OrderID</th>
            <th>Datum</th>
            <th>Dateiname</th>
            <th>Preis</th>
            <th>Auftrag Verarbeitet</th>
            <th colspan=\"2\">Options</th>

        </tr>
    ";

	return $output;
}

function orderRow($orderid, $date) {
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

function suborderRow($fileName, $price, $processed, $suborderId) {
	$output = "
         <tr>
            <td></td>
            <td></td>
            <td>$fileName</td>
            <td>$price €</td>
            <td>$processed</td>
            
                <td>
                    <form action = 'index.php?c=user&a=cancellOrder' method = 'POST'>
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

?>

<div class="adminContent">
	<table id="ordersTabe">
		<?php
		echo headerRow();

		$previousId = 0;
		$summe = 0.0;

		foreach ($openOrders as $key => $order)
		{

			$orderid = $order['oid'];
			$suborderId = $order['pcid'];
			$date = date_format(date_create($order['createdAt']),"d. m. Y");
			$price = $order['modelPrice'];
			$processed = $order['processed'] ? 'Ja' : 'Nein';
			$fileName = $order['fileName'];

			if ($orderid == $previousId) {

				echo suborderRow($fileName, $price, $processed, $suborderId);

			} else {

				if ($summe > 0.0) {
					echo summRow($summe);

				}
				$summe = 0.0;

				echo orderRow($orderid, $date);

				echo suborderRow($fileName, $price, $processed, $suborderId);

			}
			$summe = $summe + $price;

			$previousId = $orderid;
		}
		echo summRow($summe);

		?>

	</table>
</div>