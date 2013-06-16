<?php
namespace competence\models;

/**
 * Class Test
 * @package competence\models
 *
 * @property int $Id
 * @property string $Code
 * @property string $Title
 */
class Test extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Test
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompetenceTest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array();
  }

  /**
   * @return Question
   */
  public function getFirstQuestion()
  {
    $className = "\\competence\\models\\tests\\" . $this->Code . "\\First";
    return new $className($this);
  }

  public function saveResult()
  {
    $fullData = $this->getFirstQuestion()->getFullData();

    $result = new Result();
    $result->TestId = $this->Id;
    $result->UserId = \Yii::app()->user->getCurrentUser()->Id;
    $result->setDataByResult($fullData);
    $result->save();
  }
}