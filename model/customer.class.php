<?php
//M4
namespace DDDDD\model;

class Customer extends Model
{
	const TABLENAME = '`Customer`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'PaymentData_id' => ['type' => Model::TYPE_INT],
		'guest' => ['type' => Model::TYPE_TINYINT],
		'ContactData_id' => ['type' => Model::TYPE_INT]
	];
//M4_F1
	public static function findTest($attributs = [], $keys = [], $values = [])
	{
		$db = $GLOBALS['db'];
		$result = null;
		$select = '';

		$address = Address::TABLENAME;
		$contactData = ContactData::TABLENAME;
		$customer = Customer::TABLENAME;
		$paymentData = PaymentData::TABLENAME;

		try {

			if (!empty($attributs)) {
				foreach ($attributs as $attribut) {
					$select .= ' '.$attribut.',';
				}

				$select = trim($select, ',');
			} else {
				$select = '*';
			}

			$sql = "select $select from $customer c
			left join $contactData cd on c.ContactData_id = cd.id
			left join $address a on cd.Address_id = a.id
			left join $paymentData pd on c.PaymentData_ID = pd.id
			
				
			";


			if (!empty($keys) && !empty($values)) {
				$sql .= ' where ';
				for ($index = 0; $index < count($keys); $index ++) {
					$sql .= '`'.$keys[$index].'`' . ' = ' . '\''.$values[$index].'\'' . 'or';
				}
				$sql = trim($sql, 'or');
				$sql .= ';';
			}

//			echo "SQL: <br><br> $sql <br><br>";

			$result = $db->query($sql)->fetchAll();
		}
		catch (\PDOException $e) {
			die('Select statement failed: ' . $e->getMessage());
		}
		return $result;
	}

}