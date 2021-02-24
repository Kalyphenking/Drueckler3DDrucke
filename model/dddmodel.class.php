<?php
//M5

namespace DDDDD\model;


class Dddmodel
{
	const TABLENAME = '`Models`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'fileName' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 100]
	];
}