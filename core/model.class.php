<?php

namespace DDDDD\model;

class Model
{
	const TYPE_INT = 'int';
//	const TYPE_FLOAT = 'float';
	const TYPE_STRING = 'string';
	const TYPE_TINYINT = 'tinyint';
	const TYPE_DECIMAL  = 'dec';


	protected $shema = [];
	protected $data = [];

	public function __construct($params) {
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

	public function constructFromUserData($data) {

		echo json_encode($data) . '<br><br>';

		foreach ($this->shema as $key => $value) {
			echo "$key <br>";
			echo json_encode($value) . " <br>";
			echo "<br>";
		}



	}

	public function save(&$errors = null) {
		if($this->id === null) {
			$this->insert($errors);
		} else {
			$this->update($errors);
		}
	}

	public function insert(&$errors) {
		try {
			$sql = 'INSERT INTO ' . self::tablename() . '(';
			$valueString = ' VALUES (';

			$db = $GLOBALS['db'];

			foreach ($this->shema as $key => $shemaOptions) {
				$sql .= '`' . $key . '`, ';

				echo $sql . '<br>';
//				echo '<br><br></br>läuft<br><br>';

				if($this->data[$key] === null) {
					$valueString .= 'null, ';
				} else {
					$valueString .= $db->quote($this->data[$key]) . ',';
				}

			}
			echo $sql . '1 <br>';
			$sql = trim($sql, ', ');
			echo $sql . '2 <br>';
			$valueString = trim($valueString, ',');
			$sql .= ')' . $valueString . ')';

			echo $sql . ' <br>';

			$statement = $db->prepare($sql);
			$statement->execute();

			return true;
		} catch (\PDOException $e) {
//			die('Error inserting customer: ' . $e->getMessage());
			$errors[] = 'Error inserting ' . get_called_class();
		}
		return false;
	}

	public function update(&$errors) {
		$db = $GLOBALS['db'];

		try {
			$sql = 'update ' . self::tablename() . ' set';

			foreach ($this->shema as $key => $shemaOptions) {
				if ($this->data[$key] !== null) {
					$sql .= $key . ' = ' . $db->quote($this->data[$key]) . ',';
				}
			}

			$sql = trim($sql, ',');
			$sql .= ' where id = ' . $this->data['id'];

			$statement = $db->prepare($sql);
			$statement->execute();

			return true;

		} catch (\PDOException $e) {
//			die('Error inserting customer: ' . $e->getMessage());
			$errors[] = 'Error updating ' . get_called_class();
		}
		return false;
	}

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

	public function validateValue($attribute, &$value, &$shemaOptions) {
		$type = $shemaOptions['type'];
		$errors = [];

		switch ($type) {
			case BaseModel::TYPE_INT:
				break;
			case BaseModel::TYPE_FLOAT:
				break;
			case BaseModel::TYPE_STRING: {
				if(isset($shemaOptions['min']) && mb_strlen($value) < $shemaOptions['min']) {
					$errors[] = $attribute . ': String needs min. ' . $shemaOptions['min'] . ' characters!';
				}

				if(isset($shemaOptions['max']) && mb_strlen($value) < $shemaOptions['max']) {
					$errors[] = $attribute . ': String can have max. ' . $shemaOptions['max'] . ' characters!';
				}
			}
				break;
		}
		return coun($errors) > 0 ? $errors : true;
	}

	public function validate(&$errors = nul) {
		foreach ($this->shema as $key => $shemaOptions) {
			if(isset($this->data[$key]) && is_array($shemaOptions)) {
				$valueErrors = $this->validateValue($key, $this->data[$key], $shemaOptions);

				if($valueErrors !== true) {
					array_push($errors, ...$valueErrors);
				}
			}
		}

		if (count($errors) === 0) {
			return true;
		} else {
			return false;
		}
	}

	public static function tablename() {
		$class = get_called_class();
		if(defined($class . '::TABLENAME')) {
			return $class::TABLENAME;
		}
		return null;
	}



	public static function find($keys = [], $values = []) {
		$db = $GLOBALS['db'];
		$result = null;

		try {
			$sql = 'select * from ' . self::tablename();

			if (!empty($values) && !empty($keys)) {
				$sql .= ' where ';


				for ($index = 0; $index < count($keys); $index ++) {
					$sql .= '`'.$keys[$index].'`' . ' = ' . '\''.$values[$index].'\'' . 'or';
				}
				$sql = trim($sql, 'or');
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

	public static function findEmployee($attributs = [], $keys = [], $values = []) {
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

//		join $employee e on cd.id = e.ContactData_id
//		join $employee emp on o.Employee_id = emp.id

//		$sql = "select * from $address a
//			join $contactData cd on a.id = cd.Address_id
//			join $customer c on cd.id = c.ContactData_id
//			join $paymentData pd on c.paymentData_ID = pd.id
//			join $creditCard cc on pd.CreditCard_id = cc.id
//			join $orders o on c.id = o.Customer_id
//			join $printConfig pc on o.id = pc.Orders_id
//			join $printSettings ps on pc.PrintSettings_id = ps.id
//			join $models m on pc.Models_id = m.id
//			join $filament f on pc.Filaments_id = f.id
//			";
	}



}