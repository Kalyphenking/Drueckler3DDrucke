<?php

namespace DDDDD\model;

require_once '../config/databaseService.php';




$myfile = fopen("../log/userErrors.txt", "w");

$txt = 'POST: '.json_encode($_POST) . "\n\n";
fwrite($myfile, $txt);

$db = $GLOBALS['db'];




$addressDataId = $_POST['aid'];
//$txt = 'aid: '. "\n\n";
//fwrite($myfile, $txt);
$street = $_POST['street'];
//$txt = 'street: '. "\n\n";
//fwrite($myfile, $txt);
$number = $_POST['number'];
//$txt = 'number: '. "\n\n";
//fwrite($myfile, $txt);
$postalCode = $_POST['postalCode'];
//$txt = 'postalCode: '. "\n\n";
//fwrite($myfile, $txt);
$city = $_POST['city'];
//$txt = 'city: '. "\n\n";
//fwrite($myfile, $txt);
$country = $_POST['country'];
//$txt = 'country: '. "\n\n";
//fwrite($myfile, $txt);
$contactDataId = $_POST['cid'];
//$txt = 'cid: '. "\n\n";
//fwrite($myfile, $txt);

if (empty($addressDataId)) {
	$sql = 'BEGIN;';
	$sql .= '
		INSERT INTO `Address`(`id`, `street`, `number`, `postalCode`, `city`, `country`) 
		VALUES ('.$addressDataId.','.$street.','.$number.','.$postalCode.','.$city.','.$country.')
	';
	$sql .= '
		UPDATE ContactData SET Address_id = LAST_INSERT_ID() where id = '.$contactDataId.'
	';

	$sql .= 'COMMIT;';

} else {
	$sql = '
		UPDATE 
		Address SET 
		street='.$db->quote($street).',
		number='.$db->quote($number).',
		postalCode='.$db->quote($postalCode).',
		city='.$db->quote($city).',
		country='.$db->quote($country).'
		WHERE id = '.$db->quote($addressDataId).'
	';
}

$txt = 'SQL: '. $sql . "\n\n";
fwrite($myfile, $txt);

$statement = $db->prepare($sql);
$statement->execute();

$txt = 'Works: '. "\n\n";
fwrite($myfile, $txt);

$txt = 'Works: '. "\n\n";
fwrite($myfile, $txt);


//if (empty($loadedData)) {
//	$addressData->insert($this->errors, ['UPDATE ContactData SET Address_id = LAST_INSERT_ID() where id = ' . $contactDataId . ' ;']);
//} else {
//	$addressData->update($this->errors);
//}



fclose($myfile);