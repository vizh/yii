<?php
AutoLoader::Import('library.rocid.company.*');

/**
 * @property int $VacancyId
 * @property int $AccountId
 * @property string $Type
 * @property string $Email
 * @property string $Title
 * @property int $SalaryMin
 * @property int $SalaryMax
 * @property string $Description
 * @property string $DescriptionShort
 * @property string $Schedule
 * @property int $CountryId
 * @property int $RegionId
 * @property int $CityId
 * @property int $CompanyId
 * @property string $PublicationDate
 * @property string $Status
 *
 *
 * @property JobTest $JobTest
 * @property Company $Company
 */
class Vacancy extends CActiveRecord
{
  public static $TableName = 'Mod_JobVacancy';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusDraft = 'draft';
  const StatusDeleted = 'deleted';

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusDeleted);

  const TypeTop = 'top';
  /*const TypeStudent = 'student';*/
  const TypeStartup = 'startup';

  public static $Types = array(self::TypeTop, /*self::TypeStudent,*/ self::TypeStartup);

  const ScheduleFull = 'full';
  const ScheduleShift = 'shift';
  const ScheduleFree = 'free';
  const ScheduleParttime = 'parttime';
  const ScheduleRemote = 'remote';

  public static $Schedules = array(self::ScheduleFull, self::ScheduleShift, self::ScheduleFree,
                                   self::ScheduleParttime, self::ScheduleRemote,);

  /**
  * @param string $className
  * @return Vacancy
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
    return 'VacancyId';
  }

  public function relations()
  {
    return array(
      'JobTest' => array(self::HAS_ONE, 'JobTest', 'VacancyId'),
      'Company' => array(self::BELONGS_TO, 'Company', 'CompanyId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return Vacancy
   */
  public static function GetById($id)
  {
    return Vacancy::model()->findByPk($id);
  }

  public static $GetByPageCountLast = 0;

  /**
   * @static
   * @param int $count
   * @param int $page
   * @param string $type
   * @param string $status
   * @param string $notStatus
   * @param int $accountId
   * @param bool $calcCount
   * @return Vacancy[]
   */
  public static function GetByPage($count, $page = 1, $type, $status, $notStatus, $accountId = null, $calcCount = false)
  {
    $vacancy = Vacancy::model()->with('Company');
    $criteria = new CDbCriteria();
    $criteria->condition = '1=1';
    if (!empty($type))
    {
      $criteria->condition .= ' AND t.Type = :Type';
      $criteria->params[':Type'] = $type;
    }
    if (!empty($status) && $status != Vacancy::StatusAny)
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }
    if (! empty($accountId))
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
