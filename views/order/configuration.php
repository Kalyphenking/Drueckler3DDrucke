<?php


//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];


echo json_encode($filaments);