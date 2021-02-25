
<div class="paymentData">
	<h1>Kreditkarte</h1>

	<?php

	$paymentData = isset($GLOBALS['paymentData']) ? $GLOBALS['paymentData'] : [];

	if (!empty($paymentData['ccid'])) {
		$type = $paymentData['type'];
		$owner = $paymentData['owner'];
		$expiryDate = $paymentData['expiryDate'];
		$numberShort = $paymentData['numberShort'];

		echo "<p>Typ: $type</p>

              <p>Karteneigentümer: $owner</p>
        
              <p>Nummer: $numberShort</p>
        ";

	} else {
		$type = '';
		$owner = '';
		$expiryDate = '';
		$numberShort = '';
	}

	$label = isset($_SESSION['makeOrder']) ? 'Weiter' : 'Speichern';

	?>

    <form action=<?="index.php?c=user&a=changePaymentData" . '/' . "setCreditCard"?> method = 'POST'>
        Kartentyp:
        <br>
            <input type="text" name="type" value="<?= (isset($_POST['type']) ? $_POST['type'] : ''); //default Values?>">
        <br>
        Kartennummer:
        <br>
            <input type="text" name="number" value="<?= (isset($_POST['number']) ? $_POST['number'] : ''); //default Values?>">
        <br>
        Name des Eigentümers:
        <br>
            <input type="text" name="owner" value="<?= (isset($_POST['owner']) ? $_POST['owner'] : ''); //default Values?>">
        <br>
        Ablaufdatum:
        <br>
            <input type="text" name="expiryDateMonth"  placeholder="12" value="<?= (isset($_POST['expiryDateMonth']) ? $_POST['expiryDateMonth'] : ''); //default Values?>">
            /
            <input type="text" name="expiryDateYear"  placeholder="21" value="<?= (isset($_POST['expiryDateYear']) ? $_POST['expiryDateYear'] : ''); //default Values?>">
        <br>
        Sicherheitscode:
        <br>
        <input type="text" name="securityCode" >
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" class="btn" name="submit" value="<?=$label?>">
    </form>
</div>
