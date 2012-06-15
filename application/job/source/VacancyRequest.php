<?php

/**
 * @property int $VacancyRequestId
 * @property int $VacancyId
 * @property int $UserId
 * @property string $Email
 * @property string $Description
 * @property string $CreationDate
 */
class VacancyRequest extends CActiveRecord
{
  public static $TableName = 'Mod_JobVacancyRequest';


  /**
  * @param string $className
  * @return VacancyRequest
  */
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
    return 'VacancyRequestId';
  }

  public function relations()
  {
    return array(
    );
  }

  /**
   * @static
   * @param int $id
   * @return VacancyRequest
   */
  public static function GetById($id)
  {
    return VacancyRequest::model()->findByPk($id);
  }

  /**
   * @static
   * @param int $userId
   * @param int $vacancyId
   * @return VacancyRequest
   */
  public static function GetByUser($userId, $vacancyId)
  {
    $results = VacancyRequest::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.VacancyId = :VacancyId';
    $criteria->params[':UserId'] = $userId;
    $criteria->params[':VacancyId'] = $vacancyId;

    $criteria->order = 't.CreationDate DESC';
    $criteria->limit = 1;
    return $results->find($criteria);
  }
}
