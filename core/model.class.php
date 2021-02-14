<?php

namespace DDDDD\model;

//model parrent class
class Model
{
	const TYPE_INT = 'int';
	const TYPE_STRING = 'string';
	const TYPE_TINYINT = 'tinyint';
	const TYPE_DECIMAL  = 'dec';


	protected $shema = [];
	protected $data = [];

	public function __construct($params = []) {
		foreach ($this->shema as $key => $value) {
//			echo ();
			if(isset($params[$key])) {
				$this->{$key} = $params[$key];
			} else {
				$this->{$key} = null;
			}
		}
	}

	public function __get($key) {


//		echo json_encode($this->shema);

		if(array_key_exists($key, $this->data)) {
			return $this->data[$key];
		}
		throw new \Exception('You can not acces to property "' . $key . '"" for the class "' . get_called_class());

	}

	public function __set($key, $value) {
		if(array_key_exists($key, $this->shema)) {
			$this->data[$key] = $value;
			return;
		}
		throw new \Exception('You can not write to property "' . $key . '"" for the class "' . get_called_class());
	}

	//inserts objectData in new database row
	public function insert(&$errors, $extraSql = []) {
		try {
			$sql = 'BEGIN; INSERT INTO ' . self::tablename() . '(';
			$valueString = ' VALUES (';

			$db = $GLOBALS['db'];

			foreach ($this->shema as $key => $shemaOptions) {
				$sql .= '`' . $key . '`,';

//				echo $sql . '<br>';
//				echo '<br><br></br>läuft<br><br>';

				if($this->data[$key] === null) {
					$valueString .= 'null,';
				} else {
					$valueString .= $db->quote($this->data[$key]) . ',';
				}

			}
			$sql = trim($sql, ',');
			$valueString = trim($valueString, ',');
			$sql .= ')' . $valueString . ');';

			if (!empty($extraSql)) {

				foreach ($extraSql as $extra) {
					$sql .= $extra;
				}
			}



//			$sql .= 'INSERT INTO Customer (guest, ContactData_id)
//					VALUES (0, LAST_INSERT_ID());';

			$sql .= 'COMMIT;';

//			echo "<br><br> $sql <br><br>";

			$statement = $db->prepare($sql);
			$statement->execute();

			return true;
		} catch (\PDOException $e) {
//			die('Error inserting customer: ' . $e->getMessage());
			$errors[] = 'Error inserting ' . get_called_class();
		}
		return false;
	}

	//updates objectData in existing databse row
	public function update(&$errors) {
		$db = $GLOBALS['db'];

		try {
			$sql = 'update ' . self::tablename() . ' set ';

			foreach ($this->shema as $key => $shemaOptions) {
				if ($this->data[$key] !== null) {
					$sql .= $key . ' = ' . $db->quote($this->data[$key]) . ',';
				}
			}
//			echo '<br>';

			$sql = trim($sql, ',');
			$sql .= ' where id = ' . $this->data['id'];


//			echo "sql: <br> $sql <br><br>";


			$statement = $db->prepare($sql);
			$statement->execute();

			return true;

		} catch (\PDOException $e) {
//			die('Error inserting customer: ' . $e->getMessage());
			$errors[] = 'Error updating ' . get_called_class();
		}
		return false;
	}

	//deletes database row
	public function delete(&$errors = null) {
		$db = $GLOBALS['db'];

//		echo '<br><br><br>' .json_encode($this->data['id']) . '<br><br><br>';

		try {
			$sql = 'delete from '  . self::tablename() . ' where id = ' .$this->data['id'];

			$db->exec($sql);
			return true;


		} catch (\PDOException $e) {
			$errors[] = 'Error deleting ' . get_called_class();
		}
		return false;
	}

	//checks for correct input value
	public function validateValue($attribute, &$value, &$shemaOptions) {
		$type = $shemaOptions['type'];
		$errors = [];


		switch ($type) {
			case Model::TYPE_INT:
				break;
			case Model::TYPE_DECIMAL:
				break;
			case Model::TYPE_STRING: {
				if(isset($shemaOptions['min']) && mb_strlen($value) < $shemaOptions['min']) {
					$errors[] = $attribute . ': String needs min. ' . $shemaOptions['min'] . ' characters!';
				}
				if(isset($shemaOptions['max']) && mb_strlen($value) > $shemaOptions['max']) {
					$errors[] = $attribute . ': String can have max. ' . $shemaOptions['max'] . ' characters!';
				}
			}
				break;
		}
		return count($errors) > 0 ? $errors : true;
	}

	//cheks objectdata
	public function validate(&$errors) {
		foreach ($this->shema as $key => $shemaOptions) {
			if(isset($this->data[$key]) && is_array($shemaOptions)) {
				$valueErrors = $this->validateValue($key, $this->data[$key], $shemaOptions);

				if($valueErrors !== true) {
//					array_push($errors, $valueErrors);
					$errors[] = $valueErrors;
				}
			}
		}

		if (count($errors) === 0) {
			return true;
		} else {
			return false;
		}
	}

	//returns name of related database table
	public static function tablename() {
		$class = get_called_class();
		if(defined($class . '::TABLENAME')) {
			return $class::TABLENAME;
		}
		return null;
	}

	//searchs for data with specific attributes
	public static function find($keys = [], $values = [], $method = 'and') {

		$db = $GLOBALS['db'];
		$result = null;

		try {
			$sql = 'select * from ' . self::tablename();

			if (!empty($values) && !empty($keys)) {
				$sql .= ' where ';


				for ($index = 0; $index < count($keys); $index ++) {
					$sql .= '`'.$keys[$index].'`' . ' = ' . '\''.$values[$index].'\'' . $method;
				}
				$sql = trim($sql, $method);
				$sql .= ';';
			}
//			echo $sql . '<br><br>';
			$result = $db->query($sql)->fetchAll();
		}
		catch (\PDOException $e) {
			die('Select statement failed: ' . $e->getMessage());
		}
		return $result;
	}

	//searchs for data with specific attributes on multiple tables
	public static function findOnJoin($dataType = "", $attributs = [], $keys = [], $values = [])
	{
		$db = $GLOBALS['db'];
		$result = null;
		$select = '';

		$address = Address::TABLENAME;
		$contactData = ContactData::TABLENAME;
		$customer = Customer::TABLENAME;
		$filament = Filament::TABLENAME;
		$orders = Orders::TABLENAME;
		$paymentData = PaymentData::TABLENAME;
		$creditCard = CreditCard::TABLENAME;
		$paypal = Paypal::TABLENAME;
		$directDebit = DirectDebit::TABLENAME;
		$bill = Bill::TABLENAME;
		$printConfig = PrintConfig::TABLENAME;
		$printSettings = PrintSettings::TABLENAME;
		$models = Dddmodel::TABLENAME;

		if (!empty($attributs)) {
			foreach ($attributs as $attribut) {
				$select .= ' '.$attribut.',';
			}

			$select = trim($select, ',');
		} else {
			$select = '*';
		}

//		echo $select;

		$sql = "select $select from $customer c 
				right join $contactData cd on c.ContactData_id = cd.id ";

		switch ($dataType) {
			case 'contactData': {
				$sql .= "left join $address a on cd.Address_id = a.id
						left join $paymentData pd on c.paymentData_ID = pd.id";
			} break;
			case 'paymentData': {
				$sql .= "left join $paymentData pd on c.paymentData_ID = pd.id
						left join $creditCard cc on pd.CreditCard_id = cc.id
						left join $paypal pp on pd.Paypal_id = pp.id
						left join $directDebit dd on pd.DirectDebit_id = dd.id
						left join $bill bl on pd.Bill_id = bl.id
						left join $address ba on bl.Address_id = ba.id";
			} break;
			case 'orders'; {
				$sql .= "left join $orders o on c.id = o.Customer_id
						left join $printConfig pc on o.id = pc.Orders_id
						left join $printSettings ps on pc.PrintSettings_id = ps.id
						left join $models m on pc.Models_id = m.id
						left join $filament f on pc.Filaments_id = f.id";
			}
		}

//		$sql .= " left join $contactData cd on c.ContactData_id = cd.id
//				left join $address a on cd.Address_id = a.id
//
//				left join $paymentData pd on c.paymentData_ID = pd.id
//				left join $creditCard cc on pd.CreditCard_id = cc.id
//				left join $paypal pp on pd.Paypal_id = pp.id
//				left join $directDebit dd on pd.DirectDebit_id = dd.id
//				left join $bill bl on pd.Bill_id = bl.id
//				left join $address ba on bl.Address_id = ba.id
//
//				left join $orders o on c.id = o.Customer_id
//				left join $printConfig pc on o.id = pc.Orders_id
//				left join $printSettings ps on pc.PrintSettings_id = ps.id
//				left join $models m on pc.Models_id = m.id
//				left join $filament f on pc.Filaments_id = f.id";

		try {

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