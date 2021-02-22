<?php
$customerData = $_SESSION['customerData'];

//echo json_encode($customerData);

$addressId = $customerData['aid'];
$street = $customerData['street'];
$number = $customerData['number'];
$postalCode = $customerData['postalCode'];
$city = $customerData['city'];
$country = $customerData['country'];
$customerId = $customerData['cid'];

//echo json_encode($addressId);

if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
	$label = 'Weiter';
//        $_SESSION['guest'] = true;
} else {
	$label = 'Speichern';
}

?>

<label id="addressId" hidden><?=$addressId?></label>
<label id="customerId" hidden><?=$customerId?></label>

<form action="index.php?c=user&a=usermenu" method = 'POST'>

	Straße:
	<input id="street" type="text" name="street" value=<?=$street?> >
	<br>
	Hausnummer:
	<input id="number" type="text" name="number" value=<?=$number?> >
	<br>
	Postleitzahl:
	<input id="postalCode" type="text" name="postalCode" value=<?=$postalCode?> >
	<br>
	Stadt:
	<input id="city" type="text" name="city" value=<?=$city?> >
	<br>
	Land:
	<input id="country" type="text" name="country" value=<?=$country?> >
	<br>
	<input id="submitAddress" type="submit" name="submitAddress" value="<?=$label?>">
</form>
