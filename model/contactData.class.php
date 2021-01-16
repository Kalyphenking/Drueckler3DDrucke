<?php

namespace DDDDD\model;

class ContactData extends Model
{
	const TABLENAME = '`ContactData`';

	protected $shema = [
		'id' => ['type' => BaseModel::TYPE_INTEGER],
		'createdAt' => ['type' => BaseModel::TYPE_STRING],
		'updatedAt' => ['type' => BaseModel::TYPE_STRING],

		'firstName' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'lastName' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'phoneNumber' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'emailAddress' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'username' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50],
		'password' => ['type' => BaseModel::TYPE_STRING, 'min' => 2, 'max' => 50]
	];
}