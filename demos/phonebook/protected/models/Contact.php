<?php

class Contact extends CActiveRecord
{
	/**
	 * @var integer ID of this record
	 * @soap
	 */
	public $id;
	/**
	 * @var string name
	 * @soap
	 */
	public $name;
	/**
	 * @var string phone number
	 * @soap
	 */
	public $phone;
}