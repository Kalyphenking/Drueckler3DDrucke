<?php

unset($_SESSION['loggedIn']);
unset($_SESSION['username']);

echo'<h1>logout</h1>';

$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';


if (isset($_POST['testing']) && $_POST['testing'] == 'destroy') {
	session_destroy();
}

if (!isset($_POST['testing']) || $_POST['testing'] == 'true') {
	$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

	header("Location: $link ");
}