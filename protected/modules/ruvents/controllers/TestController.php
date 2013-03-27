<?php


class TestController extends CController
{
  const EventId = 248;
  private $user = null;

  private $start;
  public function actionUsers()
  {
    $this->start = microtime(true);
    ini_set("memory_limit", "512M");

    $request = \Yii::app()->getRequest();
    $query = $request->getParam('Query', null);


    if (strlen($query) != 0)
    {
      $criteria = \user\models\User::GetSearchCriteria($query);
    }
    else
    {
      $criteria = new CDbCriteria();
    }

    $criteria->select = 't.UserId';

    $criteria->addCondition('Participants.EventId = :EventId');
    $criteria->params[':EventId'] = self::EventId;

    $offset = 0;
    $criteria->limit = 1000;
    $criteria->offset = $offset;

    $criteria->order = 'Participants.EventUserId ASC';


    $criteria->group = 't.UserId';

    $userModel = \user\models\User::model()->with(array(
      'Participants' => array('together' => true, 'select' => false),
      'Settings' => array('together' => true, 'select' => false),
    ));

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);

    $this->printTime('first');

    $idList = array();
    foreach ($users as $user)
    {
      $idList[] = $user->UserId;
    }

    $this->printTime('afterIdList');

    $criteria = new CDbCriteria();
    $criteria->addInCondition('t.UserId', $idList);

    $criteria->select = 't.*';

    $userModel = \user\models\User::model()->with(array(
      'Employments.Company' => array('on' => 'Employments.Primary = :Primary', 'params' => array(':Primary' => 1), 'together' => false),
      'Participants' => array('on' => 'Participants.EventId = :EventId', 'params' => array(':EventId' => self::EventId), 'together' => false),
      'Participants.Role' => array('select' => 'Participants.Role.Name', 'together' => false),
      'Emails' => array('select' => 'Emails.Email', 'together' => false),
      'Phones' => array('select' => 'Phones.Phone, Phones.Primary', 'together' => false)
    ));

    /** @var $users User[] */
    $users = $userModel->findAll($criteria);

    $this->printTime('afterAllSelect');

    $returnBadgeCount = true;
    if ($returnBadgeCount)
    {
      $badges = \ruvents\models\Badge::model()->findAll('t.EventId = :EventId', array(':EventId' => self::EventId));
      $badgesCount = array();
      foreach ($badges as $badge)
      {
        $badgesCount[$badge->UserId]++;
      }
      //print_r($badgesCount);
      //echo 'END BADGES COUNT';
      //echo sizeof($badgesCount);
    }

    $result = array();
    foreach ($users as $user)
    {

      $this->user = new \stdClass();

      $this->user->RocId = $user->RocId;
      $this->user->LastName = $user->LastName;
      $this->user->FirstName = $user->FirstName;
      $this->user->FatherName = $user->FatherName;
      $this->user->Birthday = $user->Birthday;
      $this->user->UpdateTime = $user->UpdateTime;
      $this->user->Sex = $user->Sex;
      $this->user->CreationTime = $user->CreationTime;

      $this->user->Photo = new \stdClass();
      $this->user->Photo->Small = $user->GetMiniPhoto();
      $this->user->Photo->Medium = $user->GetMediumPhoto();
      $this->user->Photo->Large = $user->GetPhoto();

      if (!empty($user->Emails))
      {
        $this->user->Email = $user->Emails[0]->Email;
      }
      else
      {
        $this->user->Email = $user->Email;
      }

      if (!empty($user->Phones))
      {
        $phone = null;
        foreach ($user->Phones as $userPhone)
        {
          if ($userPhone->Primary == 1)
          {
            $phone = $userPhone;
          }
        }

        if ($phone === null)
        {
          $phone = $user->Phones[0];
        }
        $this->user->Phone = $phone->Phone;
      }

      foreach ($user->Employments as $employment)
      {
        if ($employment->Primary == 1 && !empty($employment->Company))
        {
          $this->user->Work = new \stdClass();
          $this->user->Work->Position = $employment->Position;

          $this->user->Work->Company = new \stdClass();
          $this->user->Work->Company->CompanyId = $employment->Company->CompanyId;
          $this->user->Work->Company->Name = $employment->Company->Name;

          $this->user->Work->Start = $employment->StartWorking;
          $this->user->Work->Finish = $employment->FinishWorking;
          break;
        }
      }

      foreach ($user->Participants as $participant)
      {
        if ($participant->EventId == self::EventId)
        {
          if ($participant->DayId == 2)
          {
            $this->user->Status = new \stdClass();
            $this->user->Status->RoleId = $participant->RoleId;
            $this->user->Status->RoleName = $participant->Role->Name;
            $this->user->Status->CreationTime = $participant->CreationTime;
            $this->user->Status->UpdateTime = $participant->UpdateTime;
          }

          if (!isset($this->user->Statuses))
          {
            $this->user->Statuses = array();
          }
          $status = new \stdClass();
          $status->DayId = $participant->DayId;
          $status->RoleId = $participant->RoleId;
          $status->RoleName = $participant->Role->Name;
          $status->CreationTime = $participant->CreationTime;
          $status->UpdateTime = $participant->UpdateTime;
          $this->user->Statuses[] = $status;
        }
      }


      /** @var $paidItems \pay\models\OrderItem[] */
      $paidItems = \pay\models\OrderItem::model()
        ->byOwnerId($user->UserId)
        ->byRedirectId(null)
        ->byRedirectId($user->UserId, false)
        ->byEventId(self::EventId)
        ->byPaid(1)->with(array('Product', 'Payer', 'Owner', 'RedirectUser', 'Orders', 'Orders.OrderJuridical'))->findAll();

      $this->user->OrderItems = array();
      foreach ($paidItems as $orderItem)
      {
        $resultItem = new \stdClass();

        $resultItem->OrderItemId = $orderItem->OrderItemId;

        $product = new \stdClass();

        $product->ProductId = $orderItem->Product->ProductId;
        $product->Manager = $orderItem->Product->Manager;
        $product->Title = $orderItem->Product->Title;
        $product->Price = $orderItem->Product->GetPrice($orderItem->PaidTime);


        $resultItem->Product = $product;
        $resultItem->PriceDiscount = $orderItem->PriceDiscount();
        $resultItem->Paid = $orderItem->Paid == 1;
        $resultItem->PaidTime = $orderItem->PaidTime;
        $resultItem->Booked = $orderItem->Booked;

        $couponActivated = $orderItem->GetCouponActivated();

        if (!empty($couponActivated) && !empty($couponActivated->Coupon))
        {
          $resultItem->Discount = $couponActivated->Coupon->Discount;
          $resultItem->PromoCode = $couponActivated->Coupon->Code;
        }
        else
        {
          $resultItem->Discount = 0;
          $resultItem->PromoCode = '';
        }

        if ($resultItem->Discount == 1)
        {
          $resultItem->PayType = 'promo';
        }
        else
        {
          $resultItem->PayType = 'individual';
          foreach ($orderItem->Orders as $order)
          {
            if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1)
            {
              $resultItem->PayType = 'juridical';
            }
          }
        }


        $this->user->OrderItems[] = $resultItem;
      }

      $result['Users'][] = $this->user;
    }

    $this->printTime('afterBuildResult');


    //print_r($result);
    //echo json_encode($result);

    $this->saveLogs();
  }

  private function printTime($tag = '')
  {
    $delta = microtime(true) - $this->start;
    echo $tag . ': ' . $delta . '<br>';
  }

  private function saveLogs()
  {
    echo '<pre>';
    $logger = Yii::GetLogger();
    ob_start();
    $logs = $logger->getProfilingResults();
    print_r($logs);
    $log = ob_get_clean();

    $executionTime = $logger->getExecutionTime();

    echo $executionTime;
    echo $log;

    echo '</pre>';
  }



  public function actionPaiditems()
  {
    ini_set("memory_limit", "512M");

    /** @var $paidItems \pay\models\OrderItem[] */
    $paidItems = \pay\models\OrderItem::model()
      ->byEventId(self::EventId)
      ->byPaid(1)->with(array('Product', 'Orders.OrderJuridical'))->findAll();

    $dataBuilder = new \ruvents\components\DataBuilder(self::EventId);

    $result = array();
    foreach ($paidItems as $orderItem)
    {
      $userId = $orderItem->RedirectId !== null ? $orderItem->RedirectId : $orderItem->OwnerId;
      if (!isset($result[$userId]))
      {
        $result[$userId] = array();
      }

      $resultItem = new \stdClass();

      $resultItem->OrderItemId = $orderItem->OrderItemId;
      $resultItem->Product = $dataBuilder->CreateProduct($orderItem->Product, $orderItem->PaidTime);



      $resultItem->Paid = $orderItem->Paid == 1;
      $resultItem->PaidTime = $orderItem->PaidTime;
      $resultItem->Booked = $orderItem->Booked;

      if ( in_array($orderItem->ProductId, array(696, 718, 719)))
      {
        $resultItem->PriceDiscount = $orderItem->PriceDiscount();
        $couponActivated = $orderItem->GetCouponActivated();
      }
      else
      {
        $resultItem->PriceDiscount = 0;
        $couponActivated = null;
      }

      if (!empty($couponActivated) && !empty($couponActivated->Coupon))
      {
        $resultItem->Discount = $couponActivated->Coupon->Discount;
        $resultItem->PromoCode = $couponActivated->Coupon->Code;
      }
      else
      {
        $resultItem->Discount = 0;
        $resultItem->PromoCode = '';
      }

      if ($resultItem->Discount == 1)
      {
        $resultItem->PayType = 'promo';
      }
      else
      {
        $resultItem->PayType = 'individual';
        foreach ($orderItem->Orders as $order)
        {
          if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1)
          {
            $resultItem->PayType = 'juridical';
          }
        }
      }

      $result[$userId][] = $resultItem;
    }

    $newResult = array();
    foreach ($result as $key => $value)
    {
      /** @var $user \user\models\User */
      $user = \user\models\User::model()->findByPk($key);
      if (!empty($user))
      {
        $resultUser = new stdClass();
        $resultUser->RocId = $user->RocId;
        $resultUser->OrderItems = $value;
        $newResult[] = $resultUser;
      }
    }

    echo '<pre>';
    print_r($newResult);
    echo '</pre>';

    //echo json_encode(array('Users' => $newResult));

    $this->saveLogs();
  }
}
