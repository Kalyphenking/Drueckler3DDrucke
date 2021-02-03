<?php
    $contactData = $GLOBALS['customerData'];
    $customerId = $contactData['cid'];

    $preferedPaymentMethode = isset($GLOBALS['preferedPaymentMethod']) ? $GLOBALS['preferedPaymentMethod'] : 'Nicht hinterlegt';
?>

<div class="userMenuBar">
    <p class="">Kunden Nummer: <?=$customerId?></p>
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