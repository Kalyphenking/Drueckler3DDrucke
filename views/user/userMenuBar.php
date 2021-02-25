<?php
$customerData = $_SESSION['customerData'];


$customerId = $customerData['cid'];
$contactDataId = $customerData['cdid'];
$preferedPaymentMethode = isset($_SESSION['preferedPaymentMethod']) ? $GLOBALS['preferedPaymentMethod'] : 'Nicht hinterlegt';

//echo json_encode($customerData);
?>


<div class="userMenuBar">
    <label id="contactDataId" hidden><?=$contactDataId?></label>
    <p class="">Kundennummer: <?=$customerId?></p>
    <p class="">Bevorzugte Zahlungsmethode: <?=$preferedPaymentMethode?></p>
    <br>
<!--    <p class="">Standardadresse:</p>-->
<!--    <br>-->
    <a href="index.php?c=user&a=userMenu" class="">Persönliche Daten</a>
    <br>
    <br>
    <a href="index.php?c=user&a=orders" class="">Bestellungen</a>
    <br>
    <br>
    <a href="index.php?c=user&a=changePaymentData" class=""">Zahlungsmethode</a>
    <br>
    <br>
    <a href="index.php?c=user&a=changeUserPassword" class="">Passwort</a>
    <br>
    <br>
    <a href="index.php?c=main&a=logout" class="">Logout</a>
    <br>
</div>