<?php
$orders = isset($GLOBALS['orders']) ? $GLOBALS['orders'] : [];
$suborders = isset($GLOBALS['suborders']) ? $GLOBALS['suborders'] : [];


include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');
?>



<table>
	<tr>
		<th>OrderID</th>
		<th>Datum</th>
		<th>Dateiname</th>
		<th>Preis</th>
		<th>Bearbeitet</th>
		<th></th>
		<th></th>

	</tr>
	<?php
		$previousId = 0;
		$summe = 0.0;

		foreach ($orders as $key => $order)
		{

			$orderid = $order['id'];
			$suborderId = $suborders[$key]['id'];
			$date = date_format(date_create($order['createdAt']),"d. m. Y");
			$price = $order['modelPrice'];
			$processed = $order['processed'] ? 'Ja' : 'Nein';
			$fileName = $order['fileName'];

			if ($orderid == $previousId) {
				echo '<tr>';

					echo"<th></th>";
					echo"<th></th>";
					echo"<th>$fileName</th>";
					echo"<th>$price €</th>";
					echo"<th>$processed</th>";
					echo"
					<th>
						<form action = 'index.php?c=user&a=cancellOrder' method = 'POST'>
							<input type='hidden' name=\"orderId\" value=$suborderId>
							<input type='submit' name=\"submit\" value='stornieren'>
						</form>
					</th>
					
					<th>
						<form action = 'index.php?c=user&a=details' method = 'POST'>
							<input type='hidden' name=\"orderId\" value=$suborderId>
							<input type='submit' name=\"submit\" value='Details'>
						</form>
					</th>
					";
					echo"<th></th>";

				echo'</tr>';
			} else {

				if ($summe > 0.0) {
					echo"
					<tr>
						<th>Summe:</th>
						<th></th>
						<th></th>
						<th>$summe €</th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
					";
					echo"
					<tr>
						<th>-------------------</th>
						<th>-------------------</th>
						<th>-------------------</th>
						<th>-------------------</th>
						<th>-------------------</th>
						<th>-------------------</th>
						<th>-------------------</th>
					</tr>
					";
				}
				$summe = 0.0;

				echo"
					<tr>
						<th>$orderid</th>
						<th>$date</th>
						<th></th>
						<th></th>
						<th></th>						
						<th></th>
						<th></th>
						
					</tr>
				";
				echo '<tr>';

					echo"<th></th>";
					echo"<th></th>";
					echo"<th>$fileName</th>";
					echo"<th>$price €</th>";
					echo"<th>$processed</th>";
					echo"
					<th>
						<form action = 'index.php?c=user&a=cancellOrder' method = 'POST'>
							<input type='hidden' name=\"orderId\" value=$suborderId>
							<input type='submit' name=\"submit\" value='stornieren'>
						</form>
					</th>
					<th>
						<form action = 'index.php?c=user&a=details' method = 'POST'>
							<input type='hidden' name=\"orderId\" value=$suborderId>
							<input type='submit' name=\"submit\" value='Details'>
						</form>
					</th>
					";
					echo"<th></th>";

				echo'</tr>';
			}
			$summe = $summe + $price;

			$previousId = $orderid;






		}
			echo"
				<tr>
					<th>Summe:</th>
					<th></th>
					<th></th>
					<th>$summe €</th>
					<th></th>
					<th></th>
					<th></th>
				</tr>
				";
			echo"
				<tr>
					<th>-------------------</th>
					<th>-------------------</th>
					<th>-------------------</th>
					<th>-------------------</th>
					<th>-------------------</th>
					<th>-------------------</th>
					<th>-------------------</th>
				</tr>
				";
	?>
</table>