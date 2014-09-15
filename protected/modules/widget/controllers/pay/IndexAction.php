<?php
namespace widget\controllers\pay;

class IndexAction extends \widget\components\pay\Action
{
  const SessionProductCount = 'ProductCount';

  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Priority" DESC, "t"."Id" ASC';
    $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');
    $products = \pay\models\Product::model()->byEventId($this->getEvent()->Id)->byPublic(true)->findAll($criteria);

    $request = \Yii::app()->getRequest();
    if ($request->getIsPostRequest())
    {
      \Yii::app()->session[self::SessionProductCount] = $request->getParam('ProductCount', []);
      $this->getController()->gotoNextStep();
    }
    $this->getController()->render('index', ['products' => $products, 'event' => $this->getEvent()]);
  }
}