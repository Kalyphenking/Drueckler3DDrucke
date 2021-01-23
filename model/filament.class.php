<?php


namespace DDDDD\model;


class Filament extends Model
{
	const TABLENAME = '`Filaments`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'color' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'type' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'producer' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'pricePerGramm' => ['type' => Model::TYPE_DECIMAL]
	];
}