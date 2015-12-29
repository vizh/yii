<?php
namespace user\models;
use application\components\ActiveRecord;
use user\models\forms\document\BaseDocument;

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
 * @method DocumentType ordered()
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


	/**
	 * Возаращает форму для редактирования документа
	 * @param User $user
	 * @param Document|null $document
	 * @return BaseDocument
	 */
	public function getForm(User $user = null, Document $document = null)
	{
		$class = '\user\models\forms\document\\' . $this->FormName;
		return new $class($this, $user, $document);
	}

	/**
	 * @param int $pk
	 * @return DocumentType
	 */
	public static function findOne($pk)
	{
		return parent::findOne($pk);
	}


}