<?php

class Post extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'posts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title','length','max'=>128),
			array('title, create_time, author_id', 'required'),
			array('author_id', 'numerical', 'integerOnly'=>true),
		);
	}
}