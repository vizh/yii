<?php
namespace partner\controllers\order;

class SearchAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск счета');
    $this->getController()->initActiveBottomMenu('search');

    $request = \Yii::app()->getRequest();
    $filter = $request->getParam('filter', array());
    $orders = $this->getOrders($filter);

    $this->getController()->render('search',
      array(
        'filter' => $filter,
        'orders' => $orders
      )
    );
  }

  private function getOrders($filter)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 'OrderJuridical.OrderId IS NOT NULL AND t.EventId = :EventId';
    $criteria->params = array(
      'EventId' => \Yii::app()->partner->getAccount()->EventId
    );
    $criteria->with = array(
      'OrderJuridical',
      'Payer',
      'Payer.Phones',
      'Payer.Emails'
    );

    if ( !empty ($filter['OrderId']))
    {
      $criteria->addCondition('t.OrderId = :OrderId');
      $criteria->params[':OrderId'] = $filter['OrderId'];
    }
    else if ( !empty ($filter['CompanyName']))
    {
      $criteria->addCondition('OrderJuridical.Name LIKE :CompanyName');
      $criteria->params[':CompanyName'] = '%'.$filter['CompanyName'].'%';
    }
    else if ( !empty ($filter['PayerRocId']))
    {
      $criteria->addCondition('Payer.RocId = :PayerRocId');
      $criteria->params[':PayerRocId'] = $filter['PayerRocId'];
    }
    else
    {
      return array();
    }

    return \pay\models\Order::model()->findAll($criteria);
  }
}