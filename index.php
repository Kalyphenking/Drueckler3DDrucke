<?php

    //load requierd files

    foreach(glob('config/*.php') as $configClass)
    {
        require_once $configClass;
    }

    foreach(glob(FUNCTIONSPATH.'*.php') as $function)
    {
        require_once $function;
    }

    foreach(glob('core/*.php') as $coreClass)
    {
        require_once $coreClass;
    }

    foreach(glob('model/*.php') as $modelClass)
    {
        require_once $modelClass;
    }

    session_start();

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
?>

<!DOCTYPE html>

<html lang="de" xml:lang="de">
<head>
    <title>Drückler 3D Drucke</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/default.css'?>">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/main.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/order.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/user.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/management.css'?>">


    <link rel="stylesheet" href="<?=ROOTPATH.'css/LogReg.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/menuStyles.css'?>">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/miscStyles.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/topBottom.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/LogReg.css'?>">
<!--    <link rel="stylesheet" href="--><?//=ROOTPATH.'css/configurator.css'?><!--">-->
    <link rel="stylesheet" href="<?=ROOTPATH.'css/slide.css'?>">

    <link rel="stylesheet" href="<?=ROOTPATH.'css/textBoxes.css'?>">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/inputStyles.css'?>">




<!--<nav id="mobile">-->
<!--    <div id="menu" Menü </div>-->
<!---->
<!--</nav>-->

    <!--requierd javascript-->
    <script src="<?=JSPATH.'fileUpload.js'?>"></script>
    <script src="<?=JSPATH.'checkForJavaScript.js'?>"></script>
    <script src="<?=JSPATH.'register.js'?>"></script>
    <script src="<?=JSPATH.'changeAddress.js'?>"></script>
    <script src="<?=JSPATH.'changeContactData.js'?>"></script>
<!---->
    <!--Color Picker-->
    <script src="https://rawgit.com/Sphinxxxx/vanilla-picker/master/dist/vanilla-picker.min.js"></script>
<!---->
    <!--3D model viewer-->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    <script nomodule src="https://unpkg.com/@google/model-viewer/dist/model-viewer-legacy.js"></script>

</head>

<?php
    if(file_exists(CONTROLLERSPATH.$controllerName.'Controller.php'))
    {
        //calls required controller class

        require_once CONTROLLERSPATH.$controllerName.'Controller.php';

        $controllerClass = '\\DDDDD\\controller\\' . ucfirst($controllerName).'Controller';

	    $directorySeperatorPosition = strpos($actionName, DIRECTORY_SEPARATOR);

	    if ($directorySeperatorPosition !== false) {
		    $mainActionName = substr($actionName, 0, $directorySeperatorPosition);
		    $subActionName = substr($actionName, $directorySeperatorPosition + 1);
	    } else {
		    $mainActionName = $actionName;
		    $subActionName = null;
	    }

        $controller = new $controllerClass($controllerName, $mainActionName, $subActionName);

        if(method_exists($controller, $mainActionName))
        {
            $controller->{$mainActionName}($subActionName);
        }

    } else {
	    $link = '404.html';
	    header("Location: $link ");
//        die('404 Controller you call does not exists');
    }

    $error = Array();
?>

<body>
    <?php
        $controller->render();
    ?>
</body>

</html>
