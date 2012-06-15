<?php

/**
 * @property int $ResultId
 * @property int $VoteId
 * @property string $Hash
 * @property string $Info
 * @property string $CreationTime
 */
class VoteResult extends CActiveRecord
{
  public static $TableName = 'Mod_VoteResult';

  /**
   * @static
   * @param string $className
   * @return VoteResult
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
    return 'ResultId';
  }

  public function relations()
  {
    return array(
      //'Question' => array(self::BELONGS_TO, 'VoteQuestion', 'QuestionId'),
      //      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      //      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      //      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      //      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      //      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
    );
  }

  /**
   * @param int $voteId
   * @param bool $useAnd
   * @return VoteResult
   */
  public function byVote($voteId, $useAnd = true)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.VoteId = :VoteId';
    $criteria->params = array(':VoteId' => $voteId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  /**
   * @param string $hash
   * @param bool $useAnd
   * @return VoteResult
   */
  public function byHash($hash, $useAnd = true)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Hash = :Hash';
    $criteria->params = array(':Hash' => $hash);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

  public function GetVoterInfo()
  {
    return unserialize(base64_decode($this->Info));
  }

}