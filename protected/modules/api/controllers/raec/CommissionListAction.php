<?php
namespace api\controllers\raec;

class CommissionListAction extends \api\components\Action
{
  public function run()
  {
    $commissionIdList = \Yii::app()->getRequest()->getParam('CommissionIdList');

    $criteria = new \CDbCriteria();
    $criteria->addCondition('NOT "t"."Deleted"');
    if (!empty($commissionIdList))
    {
      $criteria->addInCondition('"t"."Id"', $commissionIdList);
    }
    /** @var $commisions \commission\models\Commission[] */
    $commisions = \commission\models\Commission::model()->findAll($criteria);

    $builder = new \api\components\builders\Builder(null); //todo: быстрое решение, исправить

    $result = array();
    foreach ($commisions as $commision)
    {
      $builder->createCommision($commision);
      $result['Commissions'][] = $builder->buildComissionProjects($commision);
    }

    $this->setResult($result);
  }
}
