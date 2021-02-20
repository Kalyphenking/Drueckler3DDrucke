<?php
$contactData = $_SESSION['employeeData'];
$employeeId = $contactData['empid'];

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;

?>

<div class="managementMenuBar">
	<p class="">Mitarbeiternummer: <?=$employeeId?></p>
	<br>
	<!--    <p class="">Standardadresse:</p>-->
	<!--    <br>-->
	<a href="index.php?c=management&a=manageOrders" class="">Bestellungen</a>
	<br>
	<br>
	<a href="index.php?c=management&a=manageEmployee" class="">Mitarbeiter verwalten</a>
	<br>
<!--	<br>-->
<!--	<a href="index.php?c=admin&a=adminOrders/finishedOrders" class=""">Abgeschlossene Bestellungen</a>-->
<!--	<br>-->
<!--	<br>-->
<!--	<a href="index.php?c=admin&a=changeUserPassword" class="">Passwort</a>-->
<!--	<br>-->
	<br>
	<a href="index.php?c=main&a=logout" class="">Logout</a>
	<br>
</div>