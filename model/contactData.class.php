<?php

namespace DDDDD\model;

class ContactData extends Model
{
	const TABLENAME = '`ContactData`';

	protected $shema = [
		'id' => ['type' => Model::TYPE_INT],
		'createdAt' => ['type' => Model::TYPE_STRING],
		'updatedAt' => ['type' => Model::TYPE_STRING],

		'Address_id' => ['type' => Model::TYPE_INT],
		'firstName' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'lastName' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'phoneNumber' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'emailAddress' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'username' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50],
		'password' => ['type' => Model::TYPE_STRING, 'min' => 2, 'max' => 50]
	];
}