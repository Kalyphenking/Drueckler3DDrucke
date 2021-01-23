<?php

$contactData = $GLOBALS['contactData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$firstName = $contactData['firstName'];
$lastName = $contactData['lastName'];
$emailAddress = $contactData['emailAddress'];
$phoneNumber = $contactData['phoneNumber'];

//echo "contactData: <br>" .  json_encode($contactData);

?>
<br>
<br>

<form action="index.php?c=user&a=usermenu">
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
