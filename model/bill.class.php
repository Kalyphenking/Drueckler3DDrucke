<?php


namespace DDDDD\model;


class Bill
{
	const TABLENAME = '`Bill`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'Address_id' => ['type' => Model::TYPE_INT]
	];
}