<?php

namespace DDDDD\model;

class Customer extends Model
{
	const TABLENAME = '`Customer`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'PaymentData_ID' => ['type' => Model::TYPE_INT],
		'guest' => ['type' => Model::TYPE_TINYINT],
		'ContactData_id' => ['type' => Model::TYPE_INT]
	];


}