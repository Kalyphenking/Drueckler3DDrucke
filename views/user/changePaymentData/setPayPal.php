
<div class="paymentData">
	<h1>PayPal</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];



	if (!empty($paymentData)) {
		$emailAddress = $paymentData['emailAddress'];
	} else {
		$emailAddress = '';
	}

	echo $emailAddress;

	?>
</div>