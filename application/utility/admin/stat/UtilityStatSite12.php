<?php
AutoLoader::Import('library.rocid.pay.*');

class UtilityStatSite12 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    return;
    $eventId = 246;

    $command = Yii::app()->db->createCommand();
    $command = $command->select('Mod_PayOrder.OrderId, Mod_PayLog.Total')->from('Mod_PayOrder');
    $command = $command->leftJoin('Mod_PayLog', 'Mod_PayLog.OrderId = Mod_PayOrder.OrderId');
    $command = $command->where('Mod_PayOrder.EventId=:EventId AND Mod_PayLog.PayLogId IS NOT NULL', array(':EventId' => $eventId));
    $result = $command->queryAll();

    $total = 0;
    $orderIds = array();
    foreach ($result as $item)
    {
      $total += $item['Total'];
      $orderIds[] = $item['OrderId'];
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('Orders.OrderId', $orderIds);

    $model = OrderItem::model()->with(array('Orders'));

    /** @var $orderItems OrderItem[] */
    $orderItems = $model->findAll($criteria);

    $byProduct = array();
    foreach ($orderItems as $item)
    {
      if (!isset($byProduct[$item->ProductId]))
      {
        $byProduct[$item->ProductId]['count'] = 0;
        $byProduct[$item->ProductId]['total'] = 0;
      }
      $byProduct[$item->ProductId]['count'] += 1;
      $byProduct[$item->ProductId]['total'] += $item->PriceDiscount();
    }

    echo '<pre>';
    print_r($byProduct);
    echo '</pre>';
  }
}
