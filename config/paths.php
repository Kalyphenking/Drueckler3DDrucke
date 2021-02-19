<?php

// setup pahts to directories

define('ROOTPATH', strlen(dirname($_SERVER['SCRIPT_NAME'])) > 1 ? dirname($_SERVER['SCRIPT_NAME']) . '/' : '/');
define('JSPATH',  'js'.'/');
define('CSSPATH',  'css'.'/');
define('COREPATH',  'core'.'/');
define('VIEWSPATH',  'views'.'/');
define('FUNCTIONSPATH', 'controller'.'/'.'functions'.'/');
define('CONTROLLERSPATH',  'controller'.'/');
define('MODELSPATH',  'models'.'/');
define('IMAGESPATH',  'ressources'.'/'.'images'.'/');
define('UPLOADSPATH',  'uploads'.'/');


//define('STL2GLTFPATH',  'stl2gltf'.'/');

//define('SLICER', 'Prusa_Slicer'.'/'.'buildScript.sh');
