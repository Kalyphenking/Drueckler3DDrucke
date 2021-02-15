<?php

$customerData = $_SESSION['customerData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$firstName = $customerData['firstName'];
$lastName = $customerData['lastName'];
$emailAddress = $customerData['emailAddress'];
$phoneNumber = $customerData['phoneNumber'];

$street = $customerData['street'];
$number = $customerData['number'];
$postalCode = $customerData['postalCode'];
$city = $customerData['city'];
$country = $customerData['country'];

//echo "contactData: <br>" .  json_encode($contactData);

?>
<div class="userContent">
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

    <?php
        include_once VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'addressInput.php'
    ?>
</div>
