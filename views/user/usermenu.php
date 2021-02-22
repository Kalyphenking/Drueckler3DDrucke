<?php

$customerData = $_SESSION['customerData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$firstName = $customerData['firstName'];
$lastName = $customerData['lastName'];
$emailAddress = $customerData['emailAddress'];
$phoneNumber = $customerData['phoneNumber'];
$contactDataId = $customerData['cdid'];

$street = $customerData['street'];
$number = $customerData['number'];
$postalCode = $customerData['postalCode'];
$city = $customerData['city'];
$country = $customerData['country'];

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
}

//echo "contactData: <br>" .  json_encode($contactData);

?>
<div class="userContent">
    <label id="contactDataId" hidden><?=$contactDataId?></label>

    <form action="index.php?c=user&a=usermenu" method = 'POST'>
		Vorname:
		<input id="firstName" type="text" name="firstName" value=<?=$firstName?> >
		<br>
		Nachname:
		<input id="lastName" type="text" name="lastName" value=<?=$lastName?> >
		<br>
		Emailadresse:
		<input id="emailAddress" type="text" name="emailAddress" value=<?=$emailAddress?> >
		<br>
		Telefonnummer:
		<input id="phoneNumber" type="text" name="phoneNumber" value=<?=$phoneNumber?> >
		<br>
		<input id="submitContactData" type="submit" name="submitContactData" value="Speichern">
	</form>

    <?php
        include_once VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'addressInput.php'
    ?>
</div>
