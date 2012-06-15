<?php

/**
 * @property int $VacancyStreamId
 * @property int $AccountId
 * @property string $Title
 * @property int $SalaryMin
 * @property int $SalaryMax
 * @property string $Description
 * @property string $DescriptionShort
 * @property string $Link
 * @property string $PublicationDate
 * @property string $Status
 */
class VacancyStream extends CActiveRecord
{
  public static $TableName = 'Mod_JobVacancyStream';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusDraft = 'draft';
  const StatusDeleted = 'deleted';

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusDeleted);

  /**
   * @param string $className
   * @return NewsPost
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
    return 'VacancyStreamId';
  }

  public function relations()
  {
    return array(
    );
  }

  /**
   * @static
   * @param int $id
   * @return VacancyStream
   */
  public static function GetById($id)
  {
    return VacancyStream::model()->findByPk($id);
  }

  public static $GetByPageCountLast = 0;

  /**
   * @static
   * @param int $count
   * @param int $page
   * @param string $status
   * @param string $notStatus
   * @param int $accountId
   * @param bool $calcCount
   * @return VacancyStream[]
   */
  public static function GetByPage($count, $page = 1, $status = null, $notStatus = null, $accountId = null, $calcCount = false)
  {
    $vacancy = VacancyStream::model();
    $criteria = new CDbCriteria();
    $criteria->condition = '1=1';
    if (!empty($status) && $status != VacancyStream::StatusAny)
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }
    if (!empty($accountId))
    {
      $criteria->condition .= ' AND t.AccountId = :AccountId';
      $criteria->params[':AccountId'] = $accountId;
    }

    if ($calcCount)
    {
      self::$GetByPageCountLast = $vacancy->count($criteria);
    }

    $criteria->order = 't.PublicationDate DESC';
    $criteria->offset = ($page - 1) * $count;
    $criteria->limit = $count;

    return $vacancy->findAll($criteria);
  }
}
