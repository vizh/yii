<?php
namespace iri\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "IriRole".
 *
 * The followings are the available columns in table 'IriRole':
 * @property integer $Id
 * @property string $Title
 * @property integer $Priority
 *
 * @method Role findByPk()
 *
 * The followings are the available model relations:
 */
class Role extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Role the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'IriRole';
	}

}