<?php

namespace DDDDD\model;

class PaymentData extends Model
{
	const TABLENAME = '`PaymentData`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'iban' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 22],
		'bill' => ['type' => Model::TYPE_TINYINT],
		'CreditCard_id' => ['type' => Model::TYPE_INT]
	];
}