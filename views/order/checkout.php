<?php

$view = isset($GLOBALS['currentView']) ? $GLOBALS['currentView'] : '';

//echo json_encode($_SESSION['customerData']['aid']) .'<br><br>';
//echo ($_SESSION['customerData']['aid']) .'<br><br>';
//echo 'view: '.$view . '<br>';

$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];

if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
	$label = 'Weiter';
	//        $_SESSION['guest'] = true;
} else {
	$label = 'Registrieren';
}


?>

<div class="orderContent">

	<?php
	if ($view == 'addressData') {
		include_once VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'addressInput.php';
	} else if ($view == 'paymentData') {
		echo '<div class="userContent">';
		echo '<a href="index.php?c=order&a=checkout'. DIRECTORY_SEPARATOR .'setDirectDebit">Lastschrift</a>';
		echo '<a href="index.php?c=order&a=checkout'. DIRECTORY_SEPARATOR .'setCreditCard">Kreditkarte</a>';
		echo '<a href="index.php?c=order&a=checkout'. DIRECTORY_SEPARATOR .'setPayPal">PayPal</a>';

		$selectedView = isset($GLOBALS['selectedPaymentMethod']) ? $GLOBALS['selectedPaymentMethod'] : 'setDirectDebit';

		$path = VIEWSPATH . 'user' . DIRECTORY_SEPARATOR . 'changePaymentData' . DIRECTORY_SEPARATOR . $selectedView . '.php';


		include($path);
		echo '</div>';
	} else {
		foreach ($shoppingCart as $item) {
            echo $item[5] . '<br>';
	    }
    }
	?>

</div>