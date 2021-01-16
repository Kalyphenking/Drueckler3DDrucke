<?php

namespace DDDDD\model;

class Address extends Model
{
	const TABLENAME = '`Address`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'street' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'number' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 5],
		'postalCode' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 5],
		'city' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 70],
		'country' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50]
	];
}