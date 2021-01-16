<?php

namespace DDDDD\model;

class Orders extends Model
{
	const TABLENAME = '`Orders`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'Customer_id' => ['type' => BaseModel::TYPE_INT],
		'price' => ['type' => BaseModel::TYPE_DECIMAL],
		'payed' => ['type' => BaseModel::TYPE_BIT],
		'Employee_id' => ['type' => BaseModel::TYPE_INT]
	];
}