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
    $orders = \pay\models\Order::model()->byJuridical(true)->byDeleted(false)->byPaid(false)->findAll($criteria);
    $mailer = new \mail\components\mailers\PhpMailer();
    foreach ($orders as $order)
    {
      $mail = new \pay\components\handlers\orderjuridical\NotPaidNotify($mailer, $order);
      $mail->send();
    }
    return 0;
  }
}
