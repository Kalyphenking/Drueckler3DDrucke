
<div class="paymentData">
	<h1>Lastschriftverfahren</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];


	if (!empty($paymentData['ddid'])) {
		$ibanShort = $paymentData['ibanShort'];
		$owner = $paymentData['owner'];
		$mandate = $paymentData['mandate'];

		echo "<p>Iban: $ibanShort</p>

              <p>Kontoinhaber: $owner</p>
        ";
	} else {
		$ibanShort = '';
		$owner = '';
		$mandate = '';
	}

	$label = isset($_SESSION['makeOrder']) ? 'Weiter' : 'Speichern';

	?>

    <form action=<?="index.php?c=user&a=changePaymentData" . '/' . "setDirectDebit"?> method = 'POST'>
        Iban:
        <br>
            <input type="text" name="iban" value="<?= (isset($_POST['iban']) ? $_POST['iban'] : ''); //default Values?>">
        <br>
        Kontoinhaber:
        <br>
            <input type="text" name="owner" value="<?= (isset($_POST['owner']) ? $_POST['owner'] : ''); //default Values?>">
        <br>
        Lastschriftmandat erteilen:
        <br>
            <input type="checkbox" name="mandate" >
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" class="btn" name="submit" value="<?=$label?>">
    </form>
</div>


