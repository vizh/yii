<?php
namespace partner\controllers\orderitem;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Заказы');
    $this->getController()->initActiveBottomMenu('index');

    $event = $this->getEvent();
    $form = new \partner\models\forms\OrderItemSearch($this->getEvent());

    $reset = \Yii::app()->getRequest()->getParam('reset');
    if ($reset !== 'reset')
    {
      $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    }

    $criteria = $form->getCriteria();
    $count = \pay\models\OrderItem::model()
        ->byEventId($event->Id)->count($criteria);

    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerOrderItemPerPage'];

    $criteria->mergeWith($paginator->getCriteria());
    $criteria->order = '"t"."Id" DESC';

    $criteria->mergeWith(array(
      'with' => array(
        'Product',
        'ChangedOwner',
        'Payer',
        'Owner',
        'OrderLinks.Order',
        'CouponActivationLink.CouponActivation.Coupon'
      )
    ));

    $orderItems = \pay\models\OrderItem::model()->byEventId($event->Id)->findAll($criteria);
    //$products = \pay\models\Product::model()->byEventId($event->Id)->findAll();

    //$paySystemStat = $this->getPaySystemStat($orderItems);

    
    
    $this->getController()->render('index',
      array(
        'form' => $form,
        'orderItems' => $orderItems,
        //'products' => $products,
        //'paySystemStat' => $paySystemStat,
        'paginator' => $paginator
      )
    );
  }

  /**
   * @param \pay\models\OrderItem[] $orderItems
   */
  public function getPaySystemStat($orderItems)
  {
    $result = array();
    foreach ($orderItems as $item)
    {
      if (!$item->Paid)
      {
        continue;
      }
      foreach ($item->OrderLinks as $link)
      {
        if ($link->Order->Paid)
        {
          if (!\pay\models\OrderType::getIsBank($link->Order->Type))
          {
            /** @var $log \pay\models\Log */
            $log = \pay\models\Log::model()->byOrderId($link->Order->Id)->find();
            if ($log !== null)
            {
              $result[$item->Id] = $log->PaySystem;
            }
          }
          else
          {
            $result[$item->Id] = 'Juridical';
          }
        }
      }
    }
  }
}