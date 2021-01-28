<?php
$orders = isset($GLOBALS['orders']) ? $GLOBALS['orders'] : [];
$suborders = isset($GLOBALS['orders']) ? $GLOBALS['orders'] : [];

include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

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

<div class="userMenuContent">
    <table id="ordersTabe">
		<?php
            echo headerRow();

            $previousId = 0;
            $summe = 0.0;

            foreach ($orders as $key => $order)
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