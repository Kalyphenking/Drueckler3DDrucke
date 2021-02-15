

<!--<div class="userContent">-->
<!--    --><?php
//
//        include_once VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'changePaymentDataContent.php';
//
//    ?>
<!--</div>-->

<div class="userContent">
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setDirectDebit"?>>Lastschrift</a>
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setCreditCard"?>>Kreditkarte</a>
    <a href=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setPayPal"?>>PayPal</a>

	<?php
	$selectedView = isset($GLOBALS['selectedPaymentMethod']) ? $GLOBALS['selectedPaymentMethod'] : 'setDirectDebit';

	$path = VIEWSPATH . 'user' . DIRECTORY_SEPARATOR . 'changePaymentData' . DIRECTORY_SEPARATOR . $selectedView . '.php';


	include($path);
	?>
</div>

