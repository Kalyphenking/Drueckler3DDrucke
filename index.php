<?php
    require_once 'config'.DIRECTORY_SEPARATOR.'paths.php';

    foreach(glob('core/*.php') as $coreClass)
    {
        require_once $coreClass;
    }

    foreach(glob('model/*.php') as $modelClass)
    {
        require_once $modelClass;
    }

    if(isset($_GET['c']))
    {
        $controllerName = $_GET['c'];
    } else {
	    $controllerName = 'main';
    }

    // check an action is given
    if(isset($_GET['a']))
    {
        $actionName = $_GET['a'];
    } else {
	    $actionName = 'main';
    }

    echo CONTROLLERSPATH.$controllerName.'Controller.php <br>';

    if(file_exists(CONTROLLERSPATH.$controllerName.'Controller.php'))
    {


	    require_once CONTROLLERSPATH.$controllerName.'Controller.php';

	    $controllerClass = '\\DDDDD\\controller\\' . ucfirst($controllerName).'Controller';



        $controller = new $controllerClass($controllerName, $actionName);


    } else {

	    die('404 Controller you call does not exists');
    }

?>

<!DOCTYPE html>

<html lang="de" xml:lang="de">
<head>
    <title>Drückler 3D Drucke</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/default.css'?>">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/menuStyles.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/miscStyles.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/topBottom.css'?>">

    <script src="<?=ROOTPATH.'js/default.js'?>"></script>

</head>

<body>
<!--    <div class = "Top">-->
<!--        <div><img src = "" alt = "3D Drückler Text"></div>-->
<!---->
<!--    </div>-->

<nav class="menu">
    <a href="/" class="menu-button">
        <img src="<?=IMAGESPATH.'Logo.png'?>">
    </a>

    <div class="items">
        <a  href="index.php" class="item">Home</a>
        <a  href="index.php?c=order&a=modelConfiguration" class="item">Shop</a>
        <a  href="index.php?c=main&a=kontakt" class="item">Kontakt</a>
        <a  href="index.php?c=user&a=usermenu" class="item">Benutzer</a>
        <a  href="index.php?c=main&a=impressum" class="item">Impressum</a>
    </div>
    <a href="index.php?c=main&a=login" class="item login">Login / Registrierung</a>
</nav>
    <?php
        $controller->render();
    ?>
</body>
</html>
