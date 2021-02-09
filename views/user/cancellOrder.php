<?php

$order = $GLOBALS['orderToCancell'];

$orderid = $order['id'];
$date = date_format(date_create($order['createdAt']),"d. m. Y");
$price = $order['modelPrice'] . '€';
$processed = $order['processed'];
$fileName = $order['fileName'];
$payed = $order['payed'];
$amount = $order['amount'];
$printTime = $order['printTime'];
$infill = $order['infill'];
$description = $order['description'];
$color = $order['color'];
$type = $order['type'];
$cancelled = $order['cancelled'];

$success = isset($GLOBALS['success']) ? $GLOBALS['success'] : true;

$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';


echo "<div class=\"userContent\">";

if ($success) {
	include_once(VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'successMessage.php');
	echo "<a href=\"index.php?c=$previousController&a=$previousAction\" >Zurück</a>";
} else {
	echo "
	
	Soll die Bestellung: \"$fileName\" wirklich storniert werden ?
	<form action = 'index.php?c=user&a=cancellOrder' method = 'POST'>
		<input type='hidden' name='orderId' value=$orderid>
		<input type='submit' name='submit' value='Nein'>
		<input type='submit' name='submit' value='Ja'>
	</form>
";

echo "</div>";
}



