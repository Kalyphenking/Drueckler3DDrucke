<?php
//M11

namespace DDDDD\model;


class Paypal extends Model
{
	const TABLENAME = '`Paypal`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'emailAddress' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 22],
		'password' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 70]
	];
}