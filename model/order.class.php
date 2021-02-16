<?php

namespace DDDDD\model;

class Order extends Model
{
	const TABLENAME = '`Orders`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'Customer_id' => ['type' => Model::TYPE_INT],
		'price' => ['type' => Model::TYPE_DECIMAL],
		'payed' => ['type' => Model::TYPE_TINYINT],
		'Employee_id' => ['type' => Model::TYPE_INT],
		'processed' => ['type' => Model::TYPE_TINYINT],
		'cancelled' => ['type' => Model::TYPE_TINYINT]
	];


	public static function findOrder($attributs = [], $keys = [], $values = [])
	{
		$db = $GLOBALS['db'];
		$result = null;
		$select = '';

		$contactData = ContactData::TABLENAME;
		$customer = Customer::TABLENAME;
		$filament = Filament::TABLENAME;
		$orders = Order::TABLENAME;
		$printConfig = PrintConfig::TABLENAME;
		$printSettings = PrintSetting::TABLENAME;
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
			join $orders o on c.id = o.Customer_id
			join $printConfig pc on o.id = pc.Orders_id
			join $printSettings ps on pc.PrintSettings_id = ps.id
			join $models m on pc.Models_id = m.id
			join $filament f on pc.Filaments_id = f.id			
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