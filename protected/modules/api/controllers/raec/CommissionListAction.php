<?php
namespace api\controllers\raec;

class CommissionListAction extends \api\components\Action
{
  public function run()
  {
    $commissionIdList = \Yii::app()->getRequest()->getParam('CommissionIdList');

    $criteria = new \CDbCriteria();
    $criteria->addCondition('NOT t.Deleted');
    if (!empty($commissionIdList))
    {
      $criteria->addInCondition('t.ComissionId', $commissionIdList);
    }
    /** @var $commisions \commission\models\Commission[] */
    $commisions = \commission\models\Commission::model()->findAll($criteria);

    $result = array();
    foreach ($commisions as $commision)
    {
      $this->getAccount()->getDataBuilder()->createCommision($commision);
      $result['Commissions'][] = $this->getAccount()->getDataBuilder()->buildComissionProjects($commision);
    }

    $this->setResult($result);
  }
}
