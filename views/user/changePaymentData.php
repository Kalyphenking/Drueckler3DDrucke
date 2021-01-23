<?php

$contactData = $GLOBALS['contactData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$bill = $contactData['bill'];
$iban = $contactData['ibanShort'];
$creditCard = $contactData['CreditCard_id'];

if (!empty($bill)) {
	$paymentMethode = 'Rechnung';
} else if (!empty($iban)) {
	$paymentMethode = 'Bankeinzug';
} else if (!empty($creditCard)) {
	$paymentMethode = 'Kreditkarte';
}

echo '<br>' . $paymentMethode . '<br>';

?>

<!--<form action="index.php?c=user&a=usermenu">-->
<!--	Vorname:-->
<!--	<input type="text" name="firstName" value=--><?//=$firstName?><!-- >-->
<!--	<br>-->
<!--	Nachname:-->
<!--	<input type="text" name="lastName" value=--><?//=$lastName?><!-- >-->
<!--	<br>-->
<!--	Emailadresse:-->
<!--	<input type="text" name="emailAddress" value=--><?//=$emailAddress?><!-- >-->
<!--	<br>-->
<!--	Telefonnummer:-->
<!--	<input type="text" name="phoneNumber" value=--><?//=$phoneNumber?><!-- >-->
<!--	<br>-->
<!--	<input type="submit" name="submit" value="Speichern">-->
<!--</form>-->
