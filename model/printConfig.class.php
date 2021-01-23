<?php


namespace DDDDD\model;


class PrintConfig extends Model
{
	const TABLENAME = '`PrintConfig`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'Filaments_id' => ['type' => Model::TYPE_INT],
		'Models_id' => ['type' => Model::TYPE_INT],
		'PrintSettings_id' => ['type' => Model::TYPE_INT],
		'Orders_id' => ['type' => Model::TYPE_INT],
		'amount' => ['type' => Model::TYPE_INT],
		'printTime' => ['type' => Model::TYPE_INT]
	];
}