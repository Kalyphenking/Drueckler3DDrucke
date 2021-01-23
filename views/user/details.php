<?php

$order = $GLOBALS['detailedOrder'];

//echo json_encode($order);

$orderid = $order['id'];
$date = date_format(date_create($order['createdAt']),"d. m. Y");
$price = $order['price'] . '€';
$processed = $order['processed'];
$fileName = $order['fileName'];
$payed = $order['payed'];
$amount = $order['amount'];
$printTime = $order['printTime'];
$infill = $order['infill'];
$description = $order['description'];
$fileName = $order['color'];
$type = $order['type'];
$cancelled = $order['cancelled'];

