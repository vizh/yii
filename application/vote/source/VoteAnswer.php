<?php

/**
 * @property int $AnswerId
 * @property int $QuestionId
 * @property string $Answer
 * @property int $Custom
 *
 * @property VoteQuestion $Question
 */
class VoteAnswer extends CActiveRecord
{
  public static $TableName = 'Mod_VoteAnswer';

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
    return 'AnswerId';
  }

  public function relations()
  {
    return array(
      'Question' => array(self::BELONGS_TO, 'VoteQuestion', 'QuestionId'),
      //      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      //      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      //      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      //      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      //      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
    );
  }

  /**
   * @param $resultIdList
   * @return VoteResultAnswer[]
   */
  public function GetResults($resultIdList)
  {
    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.ResultId', $resultIdList);
    $criteria->addCondition('t.AnswerId = :AnswerId');
    $criteria->params[':AnswerId'] = $this->AnswerId;

    return VoteResultAnswer::model()->findAll($criteria);
  }
}
