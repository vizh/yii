<?php
namespace partner\controllers\order;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->initBottomMenu('inactive');

    $this->getController()->setPageTitle('Список счетов');

    $request = \Yii::app()->getRequest();
    $filter = $request->getParam('filter', null);
    $page = intval($request->getParam('page', null));
    $page = $page > 1 ? $page : 1;



    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'OrderJuridical' => array('together' => true),
      'Payer',
      'Payer.Emails',
      'Payer.Phones'
    );
    $criteria->condition = 'OrderJuridical.OrderId IS NOT NULL AND t.EventId = :EventId';
    $criteria->params = array(':EventId' => \Yii::app()->partner->getAccount()->EventId);

    if ($filter == 'active')
    {
      $criteria->addCondition('OrderJuridical.Paid = :Paid');
      $criteria->params[':Paid'] = 1;
    }
    else
    {
      $criteria->addCondition('OrderJuridical.Paid = :Paid AND OrderJuridical.Deleted = :Deleted');
      $criteria->params[':Paid'] = 0;
      $criteria->params[':Deleted'] = 0;
    }

    $model = \pay\models\Order::model();

    echo '123';

    $count = \pay\models\Order::model()->count($criteria);

    echo '456';

    $criteria->limit = \OrderController::OrdersOnPage;
    $criteria->offset = ($page - 1) * \OrderController::OrdersOnPage;
    $criteria->order = 't.CreationTime DESC';

    $orders = \pay\models\Order::model()->with(array('Items' => array('together' => false)))->findAll($criteria);

    //$this->view->Paginator = new Paginator(RouteRegistry::GetUrl('partner', 'order', 'index') . '?page=%s', $page, self::OrdersOnPage, $count, array('filter' => $filter));


    $this->getController()->render('index',
      array(
        'orders' => $orders,
        'count' => $count,
        'filter' => $filter
      )
    );
  }
}