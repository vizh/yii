<?php

/**
 * @property int $VoteId
 * @property int $ComissionId
 * @property string $Title
 * @property string $Description
 * @property string $Status
 * @property string $DeadTime
 * @property string $CreationTime
 *
 * @property Comission $Comission
 * @property ComissionVoteQuestion[] $Questions
 * @property int $QuestionsCount
 */
class ComissionVote extends CActiveRecord
{
  public static $TableName = 'Mod_ComissionVote';

  const StatusAny = 'any';
  const StatusPublish = 'publish';
  const StatusDraft = 'draft';
  const StatusDeleted = 'deleted';

  public static $Statuses = array(self::StatusPublish, self::StatusDraft, self::StatusDeleted);

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
    return 'VoteId';
  }

  public function relations()
  {
    return array(
//      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
//      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
//      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
//      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
//      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
      'Comission' => array(self::BELONGS_TO, 'Comission', 'ComissionId'),
      'Questions' => array(self::HAS_MANY, 'ComissionVoteQuestion', 'VoteId', 'order' => 'Questions.QuestionId ASC'),
      'QuestionsCount' => array(self::STAT, 'ComissionVoteQuestion', 'VoteId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return ComissionVote
   */
  public static function GetById($id)
  {
    return ComissionVote::model()->findByPk($id);
  }

  public static $GetByPageCountLast = 0;
  /**
   * @static
   * @param int $count
   * @param int $page
   * @param string $status
   * @param string $notStatus
   * @param bool $calcCount
   * @return JobTest[]
   */
  public static function GetByPage($count, $page = 1, $status = null, $notStatus = null, $calcCount = false)
  {
    $model = ComissionVote::model();
    $criteria = new CDbCriteria();
    $criteria->condition = '1=1';
    if (!empty($status) && $status != ComissionVote::StatusAny)
    {
      $criteria->condition .= ' AND t.Status = :Status';
      $criteria->params[':Status'] = $status;
    }
    if (! empty($notStatus))
    {
      $criteria->condition .= ' AND t.Status != :NotStatus';
      $criteria->params[':NotStatus'] = $notStatus;
    }

    if ($calcCount)
    {
      self::$GetByPageCountLast = $model->count($criteria);
    }

    $criteria->order = 't.CreationTime DESC';
    $criteria->offset = ($page - 1) * $count;
    $criteria->limit = $count;

    return $model->findAll($criteria);
  }

  private static $salt = 'yaJxhgnxVSxUhfSsSwvGEuEdu';
  public function GetHash($rocId)
  {
    return substr(md5($this->VoteId.$rocId.self::$salt), 0, 16);
  }
}
