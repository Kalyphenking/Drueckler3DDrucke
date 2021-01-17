<?php

namespace DDDDD\model;

class Address extends Model
{
	const TABLENAME = '`Address`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'street' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'number' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 5],
		'postalCode' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 5],
		'city' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 70],
		'country' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50]
	];
}