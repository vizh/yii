<?php
namespace competence\models;

/**
 * Class QuestionType
 * @package competence\models
 *
 * @property int $Id
 * @property string $Class
 * @property string $Title
 * @property string $Description
 *
 */
class QuestionType extends \CActiveRecord
{
  /**
   * @param string $className
   * @return QuestionType
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompetenceQuestionType';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [];
  }
}