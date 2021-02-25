<?php

$customerData = $_SESSION['customerData'];

//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');

$firstName = $customerData['firstName'];
$lastName = $customerData['lastName'];
$emailAddress = $customerData['emailAddress'];
$phoneNumber = $customerData['phoneNumber'];
$contactDataId = $customerData['cdid'];
//$addressId = $customerData['aid'];
$street = $customerData['street'];
$number = $customerData['number'];
$postalCode = $customerData['postalCode'];
$city = $customerData['city'];
$country = $customerData['country'];
$customerId = $customerData['cid'];
//$preferedPaymentMethode = isset($_SESSION['preferedPaymentMethod']) ? $GLOBALS['preferedPaymentMethod'] : 'Nicht hinterlegt';

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
}

if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
	$label = 'Weiter';
//        $_SESSION['guest'] = true;
} else {
	$label = 'Speichern';
}

?>
<div class="usermenu-container">
    <?php
        include_once VIEWSPATH.'user/changeUserData.php';
        include_once VIEWSPATH.'user/addressInput.php';
//    ?>
</div>
