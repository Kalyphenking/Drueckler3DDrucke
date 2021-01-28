<?php
$preferedPaymentMethod = isset($_SESSION['preferedPaymentMethod']) ? $_SESSION['preferedPaymentMethod'] : 'setDirectDebit';

//echo "preferedPaymentMethod: $preferedPaymentMethod <br>";

//echo '<br>' . $paymentMethode . '<br>';

?>



<div class="userMenuContent">
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setDirectDebit"?>>Lastschrift</a>
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setCreditCard"?>>Kreditkarte</a>
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setBill"?>>Rechnung</a>
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setPayPal"?>>PayPal</a>

	<?php
	$selectedView = isset($GLOBALS['selectedPaymentMethod']) ? $GLOBALS['selectedPaymentMethod'] : $preferedPaymentMethod;

	$path = VIEWSPATH . 'user' . DIRECTORY_SEPARATOR . 'changePaymentData' . DIRECTORY_SEPARATOR . $selectedView . '.php';

	include($path);
	?>
</div>

