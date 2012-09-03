<?php
AutoLoader::Import('vote.source.managers.*');

/**
 * @property int $VoteId
 * @property string $Manager
 * @property string $Params
 * @property string $Title
 * @property string $Description
 * @property string $Status
 * @property string $CreationTime
 * @property string $DeadTime
 *
 * @property VoteQuestion[] $Questions
 */
class Vote extends CActiveRecord
{
  public static $TableName = 'Mod_Vote';

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

      'Questions' => array(self::HAS_MANY, 'VoteQuestion', 'VoteId')
    );
  }

  /**
   * @var BaseVoteManager
   */
  private $voteManager;
  /**
   * @return BaseVoteManager
   */
  public function VoteManager()
  {
    if (empty($this->voteManager))
    {
      $manager = $this->Manager;
      $this->voteManager = new $manager($this);
    }
    return $this->voteManager;
  }

  public function ResultCsv($path, $resultIdList, $file = null)
  {
    if ($file === null)
    {
      $file = fopen($path, 'w');
    }

    /** @var $questions VoteQuestion[] */
    $questions = $this->Questions(array('order' => 'Questions.StepId'));

    $reverseIdList = array();
    foreach ($resultIdList as $key)
    {
      $reverseIdList[$key] = null;
    }

    foreach ($questions as $question)
    {
      fputcsv($file, array( $this->forCsv(strip_tags($question->Question))), ';');
      fputcsv($file, array(), ';');

      $question->QuestionType()->ResultCsv($file, $reverseIdList);

      fputcsv($file, array(), ';');
      fputcsv($file, array(), ';');
    }



    fputcsv($file, array(), ';');

    fclose($file);
  }

  private function forCsv($text)
  {
    return iconv('utf-8', 'Windows-1251', $text);
  }
}