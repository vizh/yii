<?php
namespace api\controllers\professionalinterest;

class ListAction extends \api\components\Action
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Title" ASC';
    $interests = \application\models\ProfessionalInterest::model()->findAll($criteria);
    $result = [];
    foreach ($interests as $interes)
    {
      $result[] = $this->getDataBuilder()->createProfessionalInterest($interes);
    }
    $this->setResult($result);
  }
} 