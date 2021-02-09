<nav class="navBar">
    <a href="index.php" class="menu-button">
        <img src="<?=IMAGESPATH.'Logo.png'?>">
    </a>

    <div class="items">
        <a  href="index.php" class="item">Home</a>
        <a  href="index.php?c=order&a=modelUpload" class="item">Konfigurator</a>
        <a  href="index.php?c=main&a=contact" class="item">Kontakt</a>
<!--        <a  href="index.php?c=user&a=usermenu" class="item">Benutzer</a>-->
<!--        <a  href="index.php?c=main&a=impressum" class="item">Impressum</a>-->
    </div>
<!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->

<!--    <a href="index.php?c=main&a=logout" class="item login">Logout</a>-->
<!--    <a href="index.php?c=main&a=login" class="item login">Login</a>-->


    <a href=<?php echo (isset($_SESSION['loggedIn']) ? 'index.php?c=user&a=usermenu' : 'index.php?c=main&a=login') ?> class="item register"><?php echo (isset($_SESSION['loggedIn']) ? 'Kundenkonto' : 'Login') ?></a>
</nav>