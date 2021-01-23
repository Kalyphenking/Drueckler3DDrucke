<?php


namespace DDDDD\model;


class Pricing extends Model
{
	const TABLENAME = '`Pricing`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'shiping' => ['type' => Model::TYPE_DECIMAL],
		'workPerHour' => ['type' => Model::TYPE_DECIMAL],
		'energyPerHour' => ['type' => Model::TYPE_DECIMAL],
		'taxes' => ['type' => Model::TYPE_DECIMAL],
		'country' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'grammsPerMinute' => ['type' => Model::TYPE_DECIMAL],
		'Currency' => ['type' => Model::TYPE_STRING]




	];
}