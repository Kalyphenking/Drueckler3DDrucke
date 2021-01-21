<?php


//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

//$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];
$filaments = $GLOBALS['filaments'];

echo 'filaments: ' .  json_encode($filaments) . '<br>';

//echo json_encode($filaments);