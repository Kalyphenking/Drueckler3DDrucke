<?php

namespace DDDDD\model;

class CreditCard extends Model
{
	const TABLENAME = '`CreditCard`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'number' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 12],
		'type' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'owner' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'expiryDate' => ['type' => BaseModel::TYPE_STRING],
		'securityCode' => ['type' => BaseModel::TYPE_STRING, 'min' => 3, 'max' => 3]
	];
}