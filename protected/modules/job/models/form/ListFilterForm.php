<?php
namespace job\models\form;
class ListFilterForm extends \CFormModel
{
  public $CategoryId;
  public $PositionId;
  public $Query;
  public $SalaryFrom = 0;
  
  
  public function rules() 
  {
    return array(
      array('CategoryId, PositionId, SalaryFrom', 'numerical', 'allowEmpty' => true),
      array('Query', 'safe')
    );
  }
  
  public function getCategoryList()
  {
    $categories = \Yii::app()->db->createCommand()
      ->selectDistinct('Category.Id, Category.Title')
      ->from(\job\models\Job::model()->tableName().' t')
      ->join(\job\models\Category::model()->tableName().' Category', '"t"."CategoryId" = "Category"."Id"')
      ->where('"t"."Visible"')
      ->queryAll();
   
    $categoryList = array(
      \Yii::t('app', 'Все категории')
    );
    foreach ($categories as $category)
    {
      $categoryList[$category['Id']] = $category['Title'];
    }
    return $categoryList;
  }
  
  
  public function getPositionList($categoryId)
  {
    $positions = \Yii::app()->db->createCommand()
      ->selectDistinct('Position.Id, Position.Title')
      ->from(\job\models\Job::model()->tableName().' t')
      ->join(\job\models\Position::model()->tableName().' Position', '"t"."PositionId" = "Position"."Id"')
      ->where('"t"."Visible" AND "t"."CategoryId" = :CategoryId', array(
          'CategoryId' => $categoryId
      ))
      ->queryAll();
    
    $positionList = array(
      \Yii::t('app', 'Все специальности')
    );
    foreach ($positions as $position)
    {
      $positionList[$position['Id']] = $position['Title'];
    }
    return $positionList;
  }
}
