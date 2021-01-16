<?php

namespace DDDDD\model;

class Employee extends Model
{
	const TABLENAME = '`Employee`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'admin' => ['type' => BaseModel::TYPE_BIT],
		'ContactData_id' => ['type' => BaseModel::TYPE_INT]
	];
}