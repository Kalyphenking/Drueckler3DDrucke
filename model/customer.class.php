<?php

namespace DDDDD\model;

class Customer extends Model
{
	const TABLENAME = '`Customer`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'paymentID' => ['type' => BaseModel::TYPE_INT],
		'guest' => ['type' => BaseModel::TYPE_BIT],
		'contactID' => ['type' => BaseModel::TYPE_INT]
	];
}