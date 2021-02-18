<?php
$contactData = $_SESSION['employeeData'];
$employeeId = $contactData['empid'];



?>

<div class="adminMenuBar">
	<p class="">Mitarbeiternummer: <?=$employeeId?></p>
	<br>
	<!--    <p class="">Standardadresse:</p>-->
	<!--    <br>-->
	<a href="index.php?c=admin&a=adminOrders/openOrders" class="">Offene Bestellungen</a>
	<br>
	<br>
	<a href="index.php?c=admin&a=adminOrders/ordersInProcess" class="">Bestellungen in Arbeit</a>
	<br>
	<br>
	<a href="index.php?c=admin&a=adminOrders/finishedOrders" class=""">Abgeschlossene Bestellungen</a>
	<br>
<!--	<br>-->
<!--	<a href="index.php?c=admin&a=changeUserPassword" class="">Passwort</a>-->
<!--	<br>-->
	<br>
	<a href="index.php?c=main&a=logout" class="">Logout</a>
	<br>
</div>