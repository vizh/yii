<?php
class PayCommand extends \application\components\console\BaseConsoleCommand
{   
  public function actionJuridicalOrderNotPaidNotify()
  {
    $date = date('Y-m-d', time() - (4*24*60*60));
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."CreationTime" >= :MinTime AND "t"."CreationTime" <= :MaxTime');
    $criteria->params['MinTime'] = $date.' 00:00:00';
    $criteria->params['MaxTime'] = $date.' 23:59:59';

    $orders = \pay\models\Order::model()->byBankTransfer(true)->byDeleted(false)->byPaid(false)->findAll($criteria);
    $mailer = new \mail\components\mailers\PhpMailer();
    foreach ($orders as $order)
    {
      $language = $order->Payer->Language != null ? $order->Payer->Language : 'ru';
      Yii::app()->setLanguage($language);
      $class = \Yii::getExistClass('\pay\components\handlers\orderjuridical\notify\notpaid', ucfirst($order->Event->IdName), 'Base'); 
      $mail = new $class($mailer, $order);
      $mail->send();
    }
    return 0;
  }

  public function actionClearPhysicalBook()
  {
    $orderItems = \pay\models\OrderItem::model()->byEventId(789)
      ->byPaid(false)->byBooked(false)->byDeleted(false)->findAll();

    foreach ($orderItems as $item)
    {
      $item->delete();
    }

    return 0;
  }
}
