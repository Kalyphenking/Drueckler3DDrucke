<?php
//$openOrders = isset($_SESSION['openOrders']) ? $_SESSION['openOrders'] : [];
//$ordersInProcess = isset($_SESSION['ordersInProcess']) ? $_SESSION['ordersInProcess'] : [];
//$finishedOrders = isset($_SESSION['finishedOrders']) ? $_SESSION['finishedOrders'] : [];
//
////echo '<br>openOrders: <br>'.json_encode($openOrders).'<br>';
////echo '<br>ordersInProcess: <br>'.json_encode($ordersInProcess).'<br>';
////echo '<br>doneOrders: <br>'.json_encode($doneOrders).'<br>';

$selectedOrderList = isset($GLOBALS['selectedOrderList']) && isset($_SESSION['admin']) ? $GLOBALS['selectedOrderList'] : 'openOrders';

$orders = isset($_SESSION[$selectedOrderList]) ? $_SESSION[$selectedOrderList] : [];

?>
<?php

$table = $GLOBALS['ordersTable'];

if (isset($_SESSION['admin'])) {
    $link = '<a href="index.php?c=management&a=manageOrders/openOrders" class="">Offene Bestellungen</a>';
} else {
    $link = '';
}

$ordersExist = false;

//echo json_encode($orders);

foreach ($orders as $data) {
	if (!empty($data['oid'])) {
		$ordersExist = true;
	}
}


?>
<div class="orderBar">
    <?=$link?>
    <a href="index.php?c=management&a=manageOrders/ordersInProcess" class="">Bestellungen in Arbeit</a>
    <a href="index.php?c=management&a=manageOrders/finishedOrders" class=""">Abgeschlossene Bestellungen</a>
</div>

<div class="managementContent overflow">
    <table id="ordersTabe">
	    <?php
	    //		presentOrders($orders);

	    if ($ordersExist) {
		    echo $table;
	    } else {
		    echo '<h3>Ihnen wurden keine Bestellungen zugeteilt</h3>';
	    }

	    ?>

    </table>
</div>