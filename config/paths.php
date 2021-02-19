<?php

// setup pahts to directories

define('ROOTPATH', strlen(dirname($_SERVER['SCRIPT_NAME'])) > 1 ? dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR : DIRECTORY_SEPARATOR);
define('JSPATH',  'js'.DIRECTORY_SEPARATOR);
define('CSSPATH',  'css'.DIRECTORY_SEPARATOR);
define('COREPATH',  'core'.DIRECTORY_SEPARATOR);
define('VIEWSPATH',  'views'.DIRECTORY_SEPARATOR);
define('FUNCTIONSPATH', 'controller'.DIRECTORY_SEPARATOR.'functions'.DIRECTORY_SEPARATOR);
define('CONTROLLERSPATH',  'controller'.DIRECTORY_SEPARATOR);
define('MODELSPATH',  'models'.DIRECTORY_SEPARATOR);
define('IMAGESPATH',  'ressources'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR);
define('UPLOADSPATH',  'uploads'.DIRECTORY_SEPARATOR);


//define('STL2GLTFPATH',  'stl2gltf'.DIRECTORY_SEPARATOR);

//define('SLICER', 'Prusa_Slicer'.DIRECTORY_SEPARATOR.'buildScript.sh');
