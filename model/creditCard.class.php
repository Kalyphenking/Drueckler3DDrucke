<?php

namespace DDDDD\model;

class CreditCard extends Model
{
	const TABLENAME = '`CreditCard`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'number' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 12],
		'type' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'owner' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'expiryDate' => ['type' => Model::TYPE_STRING],
		'securityCode' => ['type' => Model::TYPE_STRING, 'min' => 3, 'max' => 3]
	];
}