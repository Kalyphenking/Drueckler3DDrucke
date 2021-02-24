<?php
//M10
namespace DDDDD\model;

class PaymentData extends Model
{
	const TABLENAME = '`PaymentData`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'CreditCard_id' => ['type' => Model::TYPE_INT],
		'DirectDebit_id' => ['type' => Model::TYPE_INT],
		'Paypal_id' => ['type' => Model::TYPE_INT],
		'preferedPaymentMethod' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 2],
	];

	public static function findTest($attributs = [], $keys = [], $values = [])
	{
		$db = $GLOBALS['db'];
		$result = null;
		$select = '';

		$address = Address::TABLENAME;
		$contactData = ContactData::TABLENAME;
		$customer = Customer::TABLENAME;
		$paymentData = PaymentData::TABLENAME;
		$creditCard = CreditCard::TABLENAME;
		$paypal = Paypal::TABLENAME;
		$directDebit = DirectDebit::TABLENAME;

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
			left join $creditCard cc on pd.CreditCard_id = cc.id
			
			left join $paypal pp on pd.Paypal_id = pp.id
			left join $directDebit dd on pd.DirectDebit_id = dd.id	
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