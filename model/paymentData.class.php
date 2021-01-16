<?php

namespace DDDDD\model;

class PaymentData extends Model
{
	const TABLENAME = '`PaymentData`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'iban' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 22],
		'bill' => ['type' => BaseModel::TYPE_BIT],
		'creditCard_id' => ['type' => BaseModel::TYPE_INT]
	];
}