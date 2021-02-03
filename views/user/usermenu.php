<?php

$contactData = $GLOBALS['customerData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$firstName = $contactData['firstName'];
$lastName = $contactData['lastName'];
$emailAddress = $contactData['emailAddress'];
$phoneNumber = $contactData['phoneNumber'];

$street = $contactData['street'];
$number = $contactData['number'];
$postalCode = $contactData['postalCode'];
$city = $contactData['city'];
$country = $contactData['country'];

//echo "contactData: <br>" .  json_encode($contactData);

?>
<br>
<br>

<div class="userMenuContent">
	<form action="index.php?c=user&a=usermenu" method = 'POST'>
		Vorname:
		<input type="text" name="firstName" value=<?=$firstName?> >
		<br>
		Nachname:
		<input type="text" name="lastName" value=<?=$lastName?> >
		<br>
		Emailadresse:
		<input type="text" name="emailAddress" value=<?=$emailAddress?> >
		<br>
		Telefonnummer:
		<input type="text" name="phoneNumber" value=<?=$phoneNumber?> >
		<br>
		<input type="submit" name="submit" value="Speichern">
	</form>

    <form action="index.php?c=user&a=usermenu" method = 'POST'>
        Straße:
        <input type="text" name="street" value=<?=$street?> >
        <br>
        Hausnummer:
        <input type="text" name="number" value=<?=$number?> >
        <br>
        Postleitzahl:
        <input type="text" name="postalCode" value=<?=$postalCode?> >
        <br>
        Stadt:
        <input type="text" name="city" value=<?=$city?> >
        <br>
        Land:
        <input type="text" name="country" value=<?=$country?> >
        <br>
        <input type="submit" name="submit" value="Speichern">
    </form>
</div>
