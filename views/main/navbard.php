<nav class="navBar">
    <a href="index.php" class="menu-button">
        <img src="<?=IMAGESPATH.'Logo.png'?>">
    </a>

	<?php
	if (isset($_SESSION['admin'])) {
		$link = 'index.php?c=management&a=manageOrders';
		$label = 'Admin';
	} else if (isset($_SESSION['employee'])) {
		$link = 'index.php?c=management&a=manageOrders';
		$label = 'Mitarbeiter';
    } else if (isset($_SESSION['customerName'])) {
		$link = 'index.php?c=user&a=usermenu';
		$label = 'Kundenkonto';
	} else {
		$link = 'index.php?c=main&a=login';
		$label = 'Login';
	}
	?>

    <div class="items">
        <a  href="index.php" class="item">Home</a>
        <a  href="index.php?c=order&a=configurator" class="item">Konfigurator</a>
        <a  href="index.php?c=main&a=contact" class="item">Kontakt</a>
        <a  href="index.php?c=order&a=shoppingCart" class="item">Warenkorb</a>
<!--        <a  href="index.php?c=user&a=usermenu" class="item">Benutzer</a>-->
<!--        <a  href="index.php?c=main&a=impressum" class="item">Impressum</a>-->
    </div>
<!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->

<!--    <a href="index.php?c=main&a=logout" class="item login">Logout</a>-->
<!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->



    <a href=<?= $link ?> class="item register"><?= $label ?></a>
</nav>