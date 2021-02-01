
<div class="paymentData">
	<h1>PayPal</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];



	if (!empty($paymentData)) {
		$emailAddress = $paymentData['emailAddress'];
	} else {
		$emailAddress = '';
	}


	?>

    <form action=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setPayPal"?> method = 'POST'>
        Emailadresse:
        <br>
            <input type="email" name="emailAddress" required value = <?=$emailAddress?>>
        <br>
        Passwort:
        <br>
            <input type="password" name="password" required>
        <br>
        PayPal AGB:
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