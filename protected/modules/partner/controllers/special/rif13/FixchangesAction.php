<?php
namespace partner\controllers\special\rif13;


class FixchangesAction extends \partner\components\Action
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."ChangedOwnerId" IS NOT NULL');

    $orderItem = \pay\models\Order::model();
  }
}