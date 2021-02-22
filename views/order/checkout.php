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

$fullPrice = 0;

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
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
			    $itemPrice = $item[5][0];
			    $itemName = $item[0];
			    $itemAmount = $item[7];

			    $fullPrice += $itemPrice;

			    echo "Preis: $itemPrice Euro<br>";
			    echo "Name: $itemName <br>";
			    echo "Menge: $itemAmount Stk.<br><br>";
		    }
		    echo "Gesamtpreis: $fullPrice <br>";
            echo '<form action="index.php?c=order&a=checkout" method="POST" enctype="multipart/form-data">';
		    echo '<input type="submit" name="submitOrder" value="Bestellung absenden">';
		    echo '<input type="submit" name="editShoppingCart" value="Warenkorb bearbeiten">';
		    echo '</form>';
	    }
	    ?>
        <label class="errorMessage"><?=$error?></label>


</div>