
<div class="paymentData">
	<h1>PayPal</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];



	if (!empty($paymentData)) {
		$emailAddress = $paymentData['emailAddress'];

		echo "<p>PayPal: $emailAddress</p>
        ";

	} else {
		$emailAddress = '';
	}

	$label = isset($_SESSION['makeOrder']) ? 'Weiter' : 'Speichern';

	?>

    <form action=<?="index.php?c=user&a=changePaymentData/setPayPal"?> method="POST">
        Emailadresse:
        <br>
            <input type="email" name="emailAddress">
        <br>
        Passwort:
        <br>
            <input type="password" name="password" >
        <br>
        PayPal AGB:
        <br>
            <input type="checkbox" name="mandate" >
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="<?=$label?>">
    </form>
</div>