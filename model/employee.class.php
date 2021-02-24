<?php
//M7
namespace DDDDD\model;

class Employee extends Model
{
	const TABLENAME = '`Employee`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'management' => ['type' => Model::TYPE_TINYINT],
		'ContactData_id' => ['type' => Model::TYPE_INT]
	];
}