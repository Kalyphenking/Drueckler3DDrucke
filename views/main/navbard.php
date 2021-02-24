<header class="header">

    <nav class="navBar" id="desktop">
        <a href="index.php" id="menu-button">
            <img src="<?=IMAGESPATH.'Logo.png'?>">
        </a>

        <?php

        $navbarItems = '<a  href="index.php" class="item">Home</a>';

        if (isset($_SESSION['admin'])) {
            $link = 'index.php?c=management&a=manageOrders';
            $label = 'Admin';
        } else if (isset($_SESSION['employee'])) {
            $link = 'index.php?c=management&a=manageOrders/ordersInProcess';
            $label = 'Mitarbeiter';
        } else if (isset($_SESSION['customerName'])) {
            $link = 'index.php?c=user&a=usermenu';
            $label = 'Kundenkonto';
            $navbarItems = '
                <a  href="index.php" class="item">Home</a>
                <a  href="index.php?c=order&a=configurator" class="item">Konfigurator</a>
                <a  href="index.php?c=main&a=contact" class="item">Kontakt</a>
                <a  href="index.php?c=order&a=shoppingCart" class="item">Warenkorb</a>
            ';
        } else {
            $link = 'index.php?c=main&a=login';
            $label = 'Login';
            $navbarItems = '
                <a  href="index.php" class="item">Home</a>
                <a  href="index.php?c=order&a=configurator" class="item">Konfigurator</a>
                <a  href="index.php?c=main&a=contact" class="item">Kontakt</a>
                <a  href="index.php?c=order&a=shoppingCart" class="item">Warenkorb</a>
            ';
        }
        ?>

        <div class="items">
            <?=$navbarItems?>
            <!--        <a  href="index.php?c=user&a=usermenu" class="item">Benutzer</a>-->
            <!--        <a  href="index.php?c=main&a=impressum" class="item">Impressum</a>-->
        </div>
        <!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->

        <!--    <a href="index.php?c=main&a=logout" class="item login">Logout</a>-->
        <!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->



        <a href=<?= $link ?> class="item register"><?= $label ?></a>
    </nav>


<!--    <nav id="desktop">-->
<!--        --><?//=$navbarItems?>
<!--        <ul>-->
<!--        <li><a  href="index.php" class="item">Home</a></li>-->
<!--        <li><a  href="index.php?c=order&a=configurator" class="item">Konfigurator</a></li>-->
<!--        <li><a  href="index.php?c=main&a=contact" class="item">Kontakt</a></li>-->
<!--        <li><a  href="index.php?c=order&a=shoppingCart" class="item">Warenkorb</a></li>-->
<!--        <li><a  href=--><?//= $link ?><!-- class="item register">--><?//= $label ?><!--</a></li>-->
<!--    </ul>-->
<!--    </nav>-->
<!---->
    <nav class="navBar" id="mobile">
        <div id="menu">Menü</div>
        <ul>
            <li><a  href="index.php" class="item">Home</a></li>
            <li><a  href="index.php?c=order&a=configurator" class="item">Konfigurator</a>></li>
            <li><a  href="index.php?c=main&a=contact" class="item">Kontakt</a></li>
            <li><a  href="index.php?c=order&a=shoppingCart" class="item">Warenkorb</a></li>
            <li><a  href=<?= $link ?> class="item register"><?= $label ?></a></li>
        </ul>
    </nav>
<!---->
<!---->
</header>