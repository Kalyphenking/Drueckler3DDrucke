
<div class="paymentData">
	<h1>DirectDebit</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];

	if (!empty($paymentData)) {
		$ibanShort = $paymentData['ibanShort'];
		$owner = $paymentData['owner'];
		$mandate = $paymentData['mandate'];
	} else {
		$ibanShort = '';
		$owner = '';
		$mandate = '';
	}


	?>
</div>


