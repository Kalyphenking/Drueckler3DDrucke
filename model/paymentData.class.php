<?php

namespace DDDDD\model;

class PaymentData extends Model
{
	const TABLENAME = '`PaymentData`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'iban' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 22],
		'bill' => ['type' => Model::TYPE_TINYINT],
		'CreditCard_id' => ['type' => Model::TYPE_INT]
	];

	public static function findPaymentData($attributs = [], $keys = [], $values = [])
	{
		$db = $GLOBALS['db'];
		$result = null;
		$select = '';

		$address = Address::TABLENAME;
		$contactData = ContactData::TABLENAME;
		$creditCard = CreditCard::TABLENAME;
		$customer = Customer::TABLENAME;
		$employee = Employee::TABLENAME;
		$filament = Filament::TABLENAME;
		$orders = Orders::TABLENAME;
		$paymentData = PaymentData::TABLENAME;
//		$pricing = Pricing::TABLENAME;
		$printConfig = PrintConfig::TABLENAME;
		$printSettings = PrintSettings::TABLENAME;
		$models = Dddmodel::TABLENAME;

		try {

			if (!empty($attributs)) {
				foreach ($attributs as $attribut) {
					$select .= ' '.$attribut.',';
				}

				$select = trim($select, ',');
			} else {
				$select = '*';
			}

			$sql = "select $select from $contactData cd
			join $customer c on cd.id = c.ContactData_id
			join $address a on cd.Address_id = a.id
			join $paymentData pd on c.PaymentData_ID = pd.id
			join $creditCard cc on pd.CreditCard_id = cc.id		
			";


			if (!empty($keys) && !empty($values)) {
				$sql .= ' where ';
				for ($index = 0; $index < count($keys); $index ++) {
					$sql .= '`'.$keys[$index].'`' . ' = ' . '\''.$values[$index].'\'' . 'or';
				}
				$sql = trim($sql, 'or');
				$sql .= ';';
			}
			$result = $db->query($sql)->fetchAll();
		}
		catch (\PDOException $e) {
			die('Select statement failed: ' . $e->getMessage());
		}
		return $result;
	}
}