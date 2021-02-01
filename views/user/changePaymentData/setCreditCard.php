
<div class="paymentData">
	<h1>CreditCard</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];

	if (!empty($paymentData)) {
		$type = $paymentData['type'];
		$owner = $paymentData['owner'];
		$expiryDate = $paymentData['expiryDate'];
		$numberShort = $paymentData['numberShort'];
	} else {
		$type = '';
		$owner = '';
		$expiryDate = '';
		$numberShort = '';
	}


	?>

    <form action=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setCreditCard"?> method = 'POST'>
        Kartentyp:
        <br>
            <input type="text" name="type" required>
        <br>
        Kartennummer:
        <br>
            <input type="text" name="mandate" required>
        <br>
        Name des Eigentümers:
        <br>
            <input type="text" name="owner" required>
        <br>
        Ablaufdatum:
        <br>
            <input type="date" name="expiryDate" required>
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="Speichern">
    </form>
</div>
