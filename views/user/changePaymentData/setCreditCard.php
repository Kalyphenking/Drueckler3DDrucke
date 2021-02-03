
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

	?>





    <form action=<?="index.php?c=user&a=changePaymentData" . DIRECTORY_SEPARATOR . "setCreditCard"?> method = 'POST'>
        Kartentyp:
        <br>
            <input type="text" name="type" >
        <br>
        Kartennummer:
        <br>
            <input type="text" name="number" >
        <br>
        Name des Eigentümers:
        <br>
            <input type="text" name="owner" >
        <br>
        Ablaufdatum:
        <br>
            <input type="text" name="expiryDateMonth"  placeholder="12">
            /
            <input type="text" name="expiryDateYear"  placeholder="21">
        <br>
        Sicherheitscode:
        <br>
        <input type="text" name="securityCode" >
        <br>
        Als bevorzugte Zahlungsmethode festlegen? :
        <br>
        <input type="checkbox" name="preferedPaymentMethod">
        <br>
            <input type="submit" name="submit" value="Speichern">
    </form>
</div>
