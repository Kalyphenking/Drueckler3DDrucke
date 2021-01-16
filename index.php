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



?>

<!DOCTYPE html>

<html lang="de" xml:lang="de">
<head>
    <title>Drückler 3D Drucke</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?=ROOTPATH.'css/default.css'?>">
    <script src="<?=ROOTPATH.'js/default.js'?>"></script>

</head>

<body>
    <?php
        include(VIEWSPATH . 'administration' . DIRECTORY_SEPARATOR . 'mainPage.php');
    ?>
</body>
</html>
