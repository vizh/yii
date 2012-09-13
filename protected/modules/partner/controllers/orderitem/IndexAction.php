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
      'Payer',
      'Owner'
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


    $this->getController()->render('index',
      array(
        'filter' => $filter,
        'orderItems' => $orderItems,
        'products' => $products,
        'count' => \pay\models\OrderItem::model()->count($criteria),
        'page' => $page
      )
    );
  }

//if ( \Yii::app()->request->getIsAjaxRequest())
//    {
//      exit();
  //todo: Вынести в отдельный метод содержимое if
//      $action = Registry::GetRequestVar('action');
//      $orderItemId = (int) Registry::GetRequestVar('orderItemId');
//
//      if ($orderItemId > 0)
//      {
//        switch ($action)
//        {
//          case 'activate':
//            $this->AjaxOrderItemActivate ($orderItemId);
//            break;
//
//          case 'deactivate':
//            $this->AjaxOrderItemDeActivate ($orderItemId);
//            break;
//        }
//      }
//      exit();
//    }



}