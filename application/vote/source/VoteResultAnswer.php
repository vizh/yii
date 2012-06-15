<?php

/**
 * @property int $ResultAnswerId
 * @property int $ResultId
 * @property int $AnswerId
 * @property string $Custom
 *
 * @property VoteAnswer $Answer
 */
class VoteResultAnswer extends CActiveRecord
{
  public static $TableName = 'Mod_VoteResultAnswer';

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
    return 'ResultAnswerId';
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
      'Answer' => array(self::BELONGS_TO, 'VoteAnswer', 'AnswerId'),
    );
  }

}