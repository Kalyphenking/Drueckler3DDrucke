
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

    <form action=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setDirectDebit"?> method = 'POST'>
        Iban:
        <br>
            <input type="text" name="iban" required>
        <br>
        Kontoinhaber:
        <br>
            <input type="text" name="owner" required>
        <br>
        Lastschriftmandat erteilen:
        <br>
            <input type="checkbox" name="mandate" required>
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="Speichern">
    </form>
</div>


