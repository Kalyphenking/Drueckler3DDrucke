<?php
$customerData = $_SESSION['customerData'];

//echo json_encode($customerData);

$street = $customerData['street'];
$number = $customerData['number'];
$postalCode = $customerData['postalCode'];
$city = $customerData['city'];
$country = $customerData['country'];

if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
	$label = 'Weiter';
//        $_SESSION['guest'] = true;
} else {
	$label = 'Speichern';
}

?>

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
	<input type="submit" name="submitAddress" value="<?=$label?>">
</form>
