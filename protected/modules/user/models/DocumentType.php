<?php
namespace user\models;
use application\components\ActiveRecord;

/**
 * This is the model class for table "UserDocumentType".
 *
 * The followings are the available columns in table 'UserDocumentType':
 * @property integer $Id
 * @property string $Title
 * @property string $FormName
 *
 * The followings are the available model relations:
 *
 * @method DocumentType[] findAll()
 */
class DocumentType extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DocumentType the static model class
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
        return 'UserDocumentType';
    }
}