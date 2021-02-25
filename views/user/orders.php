<?php
$orders = isset($GLOBALS['orders']) ? $GLOBALS['orders'] : [];

//echo json_encode($orders);

$ordersExist = false;

foreach ($orders as $data) {
	if (!empty($data['oid'])) {
		$ordersExist = true;
	}
}

$table = $GLOBALS['ordersTable'];

?>



<div class="userContent">
<!--    <table id="ordersTable">-->
		<?php
//		presentOrders($orders);

        if ($ordersExist) {
	        echo $table;
        } else {
            echo '<h3>Keine Bestellungen vorhanden</h3>';
        }



		?>

<!--    </table>-->
</div>