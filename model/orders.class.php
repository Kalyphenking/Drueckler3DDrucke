<?php

namespace DDDDD\model;

class Orders extends Model
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
		'processed' => ['type' => Model::TYPE_TINYINT]
	];
}