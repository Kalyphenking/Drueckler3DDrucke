<?php

namespace DDDDD\model;

require_once '../config/databaseService.php';




$myfile = fopen("../log/userErrors.txt", "w");

$txt = 'POST: '.json_encode($_POST) . "\n\n";
fwrite($myfile, $txt);

$db = $GLOBALS['db'];


$contactDataId = $_POST['cdid'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$phoneNumber = $_POST['phoneNumber'];
$emailAddress = $_POST['emailAddress'];


$sql = '
	UPDATE 
	ContactData SET 
	firstName='.$db->quote($firstName).',
	lastName='.$db->quote($lastName).',
	phoneNumber='.$db->quote($phoneNumber).',
	emailAddress='.$db->quote($emailAddress).'
	WHERE id = '.$db->quote($contactDataId).'
';


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