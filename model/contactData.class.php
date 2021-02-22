<?php

namespace DDDDD\model;

class ContactData extends Model
{
	const TABLENAME = '`ContactData`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'Address_id' => ['type' => Model::TYPE_INT],
		'firstName' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'lastName' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'phoneNumber' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'emailAddress' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'username' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'password' => ['type' => Model::TYPE_STRING, 'min' => 8, 'max' => 70]
	];

//	public function insert(&$errors, $isGuest = 0) {
//		try {
//			$sql = 'BEGIN; INSERT INTO ' . self::tablename() . '(';
//			$valueString = ' VALUES (';
//
//			$db = $GLOBALS['db'];
//
//			foreach ($this->shema as $key => $shemaOptions) {
//				$sql .= '`' . $key . '`, ';
//
//				echo $sql . '<br>';
////				echo '<br><br></br>läuft<br><br>';
//
//				if($this->data[$key] === null) {
//					$valueString .= 'null, ';
//				} else {
//					$valueString .= $db->quote($this->data[$key]) . ',';
//				}
//
//			}
//			echo $sql . '1 <br>';
//			$sql = trim($sql, ', ');
//			echo $sql . '2 <br>';
//			$valueString = trim($valueString, ',');
//			$sql .= ')' . $valueString . ');';
//
//			$sql .= 'INSERT INTO Customer (guest, ContactData_id)
//					VALUES (0, LAST_INSERT_ID()); COMMIT;';
//
//			echo $sql . ' <br>';
//
//			$statement = $db->prepare($sql);
//			$statement->execute();
//
//			return true;
//		} catch (\PDOException $e) {
////			die('Error inserting customer: ' . $e->getMessage());
//			$errors[] = 'Error inserting ' . get_called_class();
//		}
//		return false;
//	}
}