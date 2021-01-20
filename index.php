<?php
//    require_once 'config'.DIRECTORY_SEPARATOR.'paths.php';

    foreach(glob('config/*.php') as $configClass)
    {
        require_once $configClass;
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


//    echo CONTROLLERSPATH.$controllerName.'Controller.php <br>';

    if(file_exists(CONTROLLERSPATH.$controllerName.'Controller.php'))
    {
	    require_once CONTROLLERSPATH.$controllerName.'Controller.php';

	    $controllerClass = '\\DDDDD\\controller\\' . ucfirst($controllerName).'Controller';

        $controller = new $controllerClass($controllerName, $actionName);

//	    $actionMethod = 'action'.ucfirst($actionName);
	    if(method_exists($controller, $actionName))
	    {
		    $controller->{$actionName}();
	    }


    } else {

	    die('404 Controller you call does not exists');
    }

    $error = Array();

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

    <?php
        if (!($controllerName == 'main' && ($actionName == 'register' || $actionName == 'login'))) {
            echo $controllerName;
            echo '<br>';
            echo $actionName;
	        echo '<br>';
            include_once(VIEWSPATH . 'main' . DIRECTORY_SEPARATOR . 'navbard.php');
        }

        $controller->render();
    ?>
</body>
</html>
