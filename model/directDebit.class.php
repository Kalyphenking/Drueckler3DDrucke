<?php


namespace DDDDD\model;


class DirectDebit extends Model
{
	const TABLENAME = '`DirectDebit`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'iban' => ['type' => Model::TYPE_STRING, 'min' => 22, 'max' => 22],
		'ibanShort' => ['type' => Model::TYPE_STRING],
		'owner' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'mandate' => ['type' => Model::TYPE_TINYINT]
	];
}