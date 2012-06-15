<?php
AutoLoader::Import('library.rocid.pay.*');
AutoLoader::Import('library.rocid.event.*');

class MainIndex extends AdminCommand
{
  const Length = 12;

  private static $discounts = array('10%' => 0.1, '15%'=> 0.15, '25%' => 0.25, '40%' => 0.4 ,'50%' => 0.5, '75%' => 0.75, '100%' => 1);

  /**
   * @var Event
   */
  private $event;

  /**
   * Основные действия комманды
   * @param string $eventId
   * @return void
   */
  protected function doExecute($eventId = '')
  {
    $this->event = Event::GetById($eventId);
    if (empty($this->event))
    {
      $this->Send404AndExit();
    }

    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $count = intval(Registry::GetRequestVar('count', 0));
      $discount = Registry::GetRequestVar('discount', null);
      $productId = Registry::GetRequestVar('product', 0);

      if ($count > 0)
      {
        if (isset(self::$discounts[$discount]))
        {
          $discount = self::$discounts[$discount];
          $product = Product::GetById($productId);
          if ($discount != 1 || $product !== null)
          {
            $this->generate($count, $discount, $discount == 1 ? $product : null);
          }
          else
          {
            $this->view->Error = 'Для 100% скидки необходимо указывать мероприятие';
          }
        }
        else
        {
          $this->view->Error = 'Введенная скидка не корректна';
        }
      }
      else
      {
        $this->view->Error = 'Количество купонов должно быть больше нуля.';
      }

    }


    $this->view->Products = Product::GetByEventId($this->event->EventId);
    $this->view->EventName = $this->event->Name;
    $this->view->Discounts = self::$discounts;

    echo $this->view;
  }

  /**
   * @param int $count
   * @param float $discount
   * @param Product|null $product
   */
  private function generate($count, $discount, $product = null)
  {
    $percentDiscount = $discount * 100;
    $productTitle = $product != null ? $product->Title : '';
    $path = '/discount/'. $this->event->IdName . '_' . date('Y_m_d_H_i_s') .'.csv';
    $fp = fopen($_SERVER['DOCUMENT_ROOT'] . $path, 'w');
    for ($i = 0; $i < $count; $i++)
    {
      $coupon = new Coupon();
      $coupon->EventId = $this->event->EventId;
      $coupon->Discount = $discount;
      $coupon->ProductId = $product !== null ? $product->ProductId : null;
      $coupon->Code = $coupon->GenerateCode();
      $coupon->save();

      $this->view->Result .= $coupon->Code . '<br/>';
      fputs($fp, "{$coupon->Code};{$percentDiscount}%;{$productTitle}\r\n");
    }
    fclose($fp);

    $this->view->CsvUrl = $path;
  }

//  function getCode()
//  {
//    $salt = (string) $this->event->EventId;
//    $salt = substr($salt, max(0, strlen($salt) - 3));
//    $salt = strlen($salt) == 3 ? $salt : '0'.$salt;
//    $chars = 'abcdefghijkmnpqrstuvwxyz123456789';
//    $pass = '';
//    while (strlen($pass) < self::Length)
//    {
//      if ((strlen($pass)) % 4 != 0)
//      {
//        $invert = mt_rand(1,5);
//        $pass .= ($invert == 1) ? strtoupper($chars[mt_rand(0, strlen($chars)-1)]) : $chars[mt_rand(0, strlen($chars)-1)];
//      }
//      else
//      {
//        $key = intval((strlen($pass)) / 4);
//        $pass .= $salt[$key];
//      }
//    }
//    return $pass;
//
//  }
}
