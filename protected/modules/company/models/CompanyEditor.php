<?php
namespace company\models;
AutoLoader::Import('library.rocid.user.*');

/**
 * @property int $CompanyEditorId
 * @property int $CompanyId
 * @property int $UserId
 */
class CompanyEditor extends CActiveRecord
{
  public static $TableName = 'CompanyEditor';

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return self::$TableName;
	}

	public function primaryKey()
	{
		return 'CompanyEditorId';
	}

  public function relations()
  {
    return array();
  }

  public static function RemoveByData($companyId, $userId)
  {
    $editor = CompanyEditor::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 'CompanyId = :CompanyId AND UserId = :UserId';
    $criteria->params - array(':CompanyId' => $companyId, ':UserId' => $userId);
    $editor->deleteAll($criteria);
  }
}