
<div class="paymentData">
	<h1>Rechnung</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];

	if (!empty($paymentData)) {
		$street = $paymentData['street'];
		$number = $paymentData['number'];
		$postalCode = $paymentData['postalCode'];
		$city = $paymentData['city'];
		$country = $paymentData['country'];
	} else {
		$street = '';
		$number = '';
		$postalCode = '';
		$city = '';
		$country = '';
	}


	?>

    <form action=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setBill"?> method = 'POST'>
        Wie Lieferadresse?
        <br>
        <input type="checkbox" name="sameAsShipping">
        <br>
        <br>
        Straße:
        <br>
            <input type="text" name="street" value = <?=$street?>>
        <br>
        Hausnummer:
        <br>
            <input type="text" name="number" value = <?=$number?>>
        <br>
        Postleitzahl:
        <br>
            <input type="text" name="postalCode" value = <?=$postalCode?>>
        <br>
        Stadt:
        <br>
            <input type="text" name="city" value = <?=$city?>>
        <br>
        Land:
        <br>
            <input type="text" name="country" value = <?=$country?>>
        <br>
        Als bevorzugte Zahlungsmethode festlegen?
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="Speichern">
    </form>
</div>
