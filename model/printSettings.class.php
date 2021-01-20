<?php


namespace DDDDD\model;


class PrintSettings extends Model
{
	const TABLENAME = '`PrintSettings`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'resolution' => ['type' => Model::TYPE_DECIMAL],
		'infill' => ['type' => Model::TYPE_DECIMAL],
		'description' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50]
	];
}