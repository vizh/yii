<?php
namespace partner\controllers\orderitem;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Заказы');
    $this->getController()->initBottomMenu('index');

    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Product',
      'RedirectUser',
      'Payer',
      'Owner',
      'Orders'
    );
    $criteria->condition = 'Product.EventId = :EventId';
    $criteria->params[':EventId'] = \Yii::app()->partner->getAccount()->EventId;
    $criteria->order = 'OrderItemId DESC';

    $request = \Yii::app()->request;
    $page = (int) $request->getParam('page', 0);
    if ($page === 0)
    {
      $page = 1;
    }

    $criteria->limit  = \OrderitemController::OrderItemsOnPage;
    $criteria->offset = \OrderitemController::OrderItemsOnPage * ($page-1);

    $filter = $request->getParam('filter', array());
    if ( !empty ($filter))
    {
      foreach ($filter as $field => $value)
      {
        if ($value !== '')
        {
          switch ($field)
          {
            case 'OrderItemId':
              $criteria->addCondition('t.OrderItemId = :OrderItemId');
              $criteria->params[':OrderItemId'] = (int) $value;
              break;

            case 'ProductId':
              $criteria->addCondition('t.ProductId = :ProductId');
              $criteria->params[':ProductId'] = (int) $value;
              break;

            case 'Payer':
            case 'Owner':
              $criteria->addCondition('`'. $field .'`.`RocId` = :'.$field);
              $criteria->params[':'.$field] = (int) $value;
              break;

            case 'Deleted':
            case 'Paid':
              $criteria->addCondition('`t`.`'.$field.'` = :'. $field);
              $criteria->params[':'.$field] = (int) $value;
              break;

          }
        }
        else
        {
          unset ($filter[$field]);
        }
      }
    }

    if (empty($filter['Deleted']))
    {
      $criteria->addCondition('(t.Deleted = 0 OR t.Deleted = 1 AND t.Paid = 1)');
    }
    
//    if ( isset($filter['Deleted']) && $filter['Deleted'] == 0)
//    {
//      $criteria->addCondition('`t`.`Deleted` = 1 AND `t`.`Paid` = 1', 'OR');
//    }

    $orderItems = \pay\models\OrderItem::model()->findAll($criteria);
    $products = \pay\models\Product::model()->findAll('t.EventId = :EventId', array(':EventId' => \Yii::app()->partner->getAccount()->EventId));

 
    // Список платежных систем для orderItem
    $orderIdList = array();
    $orderItemsPaySystem = array();
    foreach ($orderItems as $orderItem)
    {
      $orderId = !empty($orderItem->Orders) ? $orderItem->Orders[0]->OrderId : null;
      if ($orderId != null)
      {
        $orderIdList[$orderItem->OrderItemId] = $orderId;
      }
    }
    
    $criteria2 = new \CDbCriteria();
    $criteria2->condition = 't.Type = :Type';
    $criteria2->params['Type'] = \pay\models\PayLog::TypeSuccess;
    $criteria2->addInCondition('t.OrderId', $orderIdList);
    $payLogs = \pay\models\PayLog::model()->findAll($criteria2);
    foreach ($payLogs as $payLog)
    {
      $orderItemId = array_search($payLog->OrderId, $orderIdList);
      $orderItemsPaySystem[$orderItemId] = $payLog->PaySystem;
      unset($orderIdList[$orderItemId]);
    }
    
    $criteria2 = new \CDbCriteria;
    $criteria2->condition = 't.Paid = 1';
    $criteria2->addInCondition('t.OrderId', $orderIdList);
    $ordersJuridical = \pay\models\OrderJuridical::model()->findAll($criteria2);
    foreach ($ordersJuridical as $orderJuridical)
    {
      $orderItemId = array_search($orderJuridical->OrderId, $orderIdList);
      $orderItemsPaySystem[$orderItemId] = 'Juridical';
      unset($orderIdList[$orderItemId]);
    }
    
    
    $this->getController()->render('index',
      array(
        'filter' => $filter,
        'orderItems' => $orderItems,
        'products' => $products,
        'orderItemsPaySystem' => $orderItemsPaySystem,
        'count' => \pay\models\OrderItem::model()->count($criteria),
        'page' => $page
      )
    );
  }
}