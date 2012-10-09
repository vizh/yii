<?php
AutoLoader::Import('library.rocid.pay.*');

class UtilityStatRad12 extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    ini_set("memory_limit", "512M");

    $file = fopen('rad12-stat-09102012.csv', 'w');

    $criteria = new CDbCriteria();
    $criteria->condition = 't.Paid = :Paid AND Product.EventId = :EventId';
    $criteria->params = array(':EventId' => 312, ':Paid' => 1);
    $criteria->group = 't.OwnerId';

    $items = OrderItem::model()
      ->with(array('Product' => array('select' => false)))
      ->findAll($criteria);

    $userIdList = array();

    foreach ($items as $item)
    {
      $userIdList[] = $item->OwnerId;
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $userIdList);

    /** @var $users User[] */
    $users = User::model()->findAll($criteria);

    foreach ($users as $user)
    {
      $criteria = new CDbCriteria();
      $criteria->condition = 't.OwnerId = :OwnerId AND t.Paid = :Paid AND Product.EventId = :EventId';
      $criteria->params = array(':OwnerId' => $user->UserId, ':Paid' => 1, ':EventId' => 312);

      $result = array(
        'RocId' => $user->RocId,
        'FIO' => iconv('utf-8', 'Windows-1251', $user->GetFullName()),
        'PayTypeFirst' => '',
        'DayFirst' => '',
        'PromoFirst' => '',
        'DiscountFirst' => '',
        'PayTypeSecond' => '',
        'DaySecond' => '',
        'PromoSecond' => '',
        'DiscountSecond' => '',
        'PayTypeRange' => '',
        'DayRange' => '',
      );

      /** @var $orderItems OrderItem[] */
      $orderItems = OrderItem::model()
        ->with(array('Product' => array('select' => false)))
        ->findAll($criteria);
      foreach ($orderItems as $item)
      {
        if ($item->ProductId == 702)
        {
          $key = 'First';
        }
        elseif ($item->ProductId == 703)
        {
          $key = 'Second';
        }
        else
        {
          $key = 'Range';
        }
        $result['PayType'.$key] = iconv('utf-8', 'Windows-1251', 'физ.');
        foreach ($item->Orders as $order)
        {
          if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1)
          {
            $result['PayType'.$key] = iconv('utf-8', 'Windows-1251', 'юр.');
            break;
          }
        }

        $result['Day'.$key] = $item->PriceDiscount();

        $couponActivated = $item->GetCouponActivated();
        if (!empty($couponActivated) && $key != 'Range')
        {
          $result['Promo'.$key] = $couponActivated->Coupon->Code;
          $result['Discount'.$key] = ceil($couponActivated->Coupon->Discount * 100) . '%';
        }
      }

      fputcsv($file, $result);
    }

    fclose($file);
    echo 'Done!';
  }
}
