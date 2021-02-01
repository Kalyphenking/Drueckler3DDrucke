
<div class="paymentData">
	<h1>Bill</h1>

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
        Straße:
        <br>
            <input type="text" name="street" required value = <?=$street?>>
        <br>
        Hausnummer:
        <br>
            <input type="text" name="number" required value = <?=$number?>>
        <br>
        Postleitzahl:
        <br>
            <input type="text" name="postalCode" required value = <?=$postalCode?>>
        <br>
        Stadt:
        <br>
            <input type="text" name="city" required value = <?=$city?>>
        <br>
        Land:
        <br>
            <input type="text" name="country" required value = <?=$country?>>
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="Speichern">
    </form>
</div>
