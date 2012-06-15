<?php

/**
 * @property int $DependId
 * @property int $QuestionId
 * @property int $AnswerId
 * @property int $Invert
 *
 * @property VoteAnswer $Answer
 */
class VoteQuestionDepend extends CActiveRecord
{
  public static $TableName = 'Mod_VoteQuestionDepend';

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
    return 'DependId';
  }

  public function relations()
  {
    return array(
      //      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
      //      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
      //      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
      //      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
      //      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
      'Answer' => array(self::BELONGS_TO, 'VoteAnswer', 'AnswerId')
    );
  }
}
