<?php
namespace ruvents\components;

class DataBuilder
{
  private $eventId;
  public function __construct($eventId)
  {
    $this->eventId = $eventId;
  }

  private static $dayId = null;
  public static function RadDayId()
  {
    if (empty(self::$dayId))
    {
      $day = date('Y-m-d');
      self::$dayId = $day <= '2012-10-04' ? 1 : 2;
    }
    return null;//self::$dayId;
  }

  private $activeEvent = null;

  /**
   * @return \event\models\Event
   */
  public function Event()
  {
    if ($this->activeEvent == null)
    {
      $this->activeEvent = \event\models\Event::model()->findByPk($this->eventId);
    }

    return $this->activeEvent;
  }

  protected $user;
  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function CreateUser($user)
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

    $this->user->Locales = $this->getLocales($user);

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEmail($user)
  {
    if (!empty($user->Emails))
    {
      $this->user->Email = $user->Emails[0]->Email;
    }
    else
    {
      $this->user->Email = $user->Email;
    }

    return $this->user;
  }

  /**
   *
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserPhone ($user)
  {
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
    return $this->user;
  }


  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEmployment($user)
  {
    foreach ($user->Employments as $employment)
    {
      if ($employment->Primary == 1 && !empty($employment->Company))
      {
        $this->user->Work = new \stdClass();
        $this->user->Work->Position = $employment->Position;
        $this->user->Work->Company = $this->CreateCompany($employment->Company);
        $this->user->Work->Start = $employment->StartWorking;
        $this->user->Work->Finish = $employment->FinishWorking;
        return $this->user;
      }
    }

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function BuildUserEvent($user)
  {
    //$isSingleDay = empty($this->Event()->Days);
    $isSingleDay = true;
    foreach ($user->Participants as $participant)
    {
      if ($participant->EventId == $this->eventId)
      {
        if ($participant->DayId == self::RadDayId())
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

    return $this->user;
  }

  protected $company;
  /**
   * @param \company\models\Company $company
   * @return \stdClass
   */
  public function CreateCompany($company)
  {
    $this->company = new \stdClass();

    $this->company->CompanyId = $company->CompanyId;
    $this->company->Name = $company->Name;
    $this->company->Locales = $this->getLocales($company);
    return $this->company;
  }

  protected $event;
  /**
   *
   */
  public function CreateEvent()
  {
    $this->event = new \stdClass();

    $this->event->EventId = $this->Event()->EventId;
    $this->event->IdName = $this->Event()->IdName;
    $this->event->Name = $this->Event()->Name;
    $this->event->Info = $this->Event()->Info;
    $this->event->Place = $this->Event()->Place;
    $this->event->Url = $this->Event()->Url;
    $this->event->UrlRegistration = $this->Event()->UrlRegistration;
    $this->event->UrlProgram = $this->Event()->UrlProgram;
    $this->event->DateStart = $this->Event()->DateStart;
    $this->event->DateEnd = $this->Event()->DateEnd;

    $this->event->Image = new \stdClass();
    $this->event->Image->Mini = 'http://rocid.ru' . $this->Event()->GetMiniLogo();
    $this->event->Image->Normal = 'http://rocid.ru' . $this->Event()->GetLogo();

    $this->event->Days = array();
    foreach ($this->Event()->Days as $day)
    {
      $resultDay = new \stdClass();
      $resultDay->DayId = $day->DayId;
      $resultDay->Title = $day->Title;
      $resultDay->Order = $day->Order;

      $this->event->Days[] = $resultDay;
    }

    return $this->event;
  }

  protected $badge;

  /**
   * @param \ruvents\models\Badge $badge
   */
  public function CreateBadge($badge)
  {
    $this->badge = new \stdClass();

    $this->badge->RocId = $badge->User->RocId;
    $this->badge->RoleId = $badge->RoleId;
    $this->badge->RoleName = $badge->Role->Name;
    $this->badge->DayId = $badge->DayId;
    $this->badge->OperatorId = $badge->OperatorId;
    $this->badge->CreationTime = $badge->CreationTime;

    return $this->badge;
  }

  protected $role;

  public function CreateRole($role)
  {
    $this->role = new \stdClass();
    $this->role->RoleId = $role->RoleId;
    $this->role->Name = $role->Name;

    return $this->role;
  }


  protected $eventSetting;

  public function CreateEventSetting ($setting)
  {
    $this->eventSetting = new \stdClass();
    $this->eventSetting->Name = $setting->Name;
    $this->eventSetting->Value = $setting->Value;
    return $this->eventSetting;
  }

  public function CreateEventSettingBadge ($setting)
  {
    $this->eventSetting = new \stdClass();
    $this->eventSetting->Name = $setting->Name;

    $viewPath = '/badge/event'.$setting->EventId.'/'.$setting->Value;
    $this->eventSetting->Value = \Yii::app()->controller->renderPartial($viewPath, null, true);

    return $this->eventSetting;
  }

  protected $orderItem;
  /**
   * @param \pay\models\OrderItem $orderItem
   */
  public function CreateOrderItem($orderItem)
  {
    $this->orderItem = new \stdClass();

    $this->orderItem->OrderItemId = $orderItem->OrderItemId;
    $this->orderItem->Product = $this->CreateProduct($orderItem->Product, $orderItem->PaidTime);
    $this->orderItem->Owner = $this->CreateUser($orderItem->Owner);
    $this->orderItem->RedirectUser = !empty($orderItem->RedirectUser) ? $this->CreateUser($orderItem->RedirectUser) : null;
    $this->orderItem->PriceDiscount = $orderItem->PriceDiscount();
    $this->orderItem->Paid = $orderItem->Paid == 1;
    $this->orderItem->PaidTime = $orderItem->PaidTime;
    $this->orderItem->Booked = $orderItem->Booked;

    $couponActivated = $orderItem->GetCouponActivated();

    if (!empty($couponActivated) && !empty($couponActivated->Coupon))
    {
      $this->orderItem->Discount = $couponActivated->Coupon->Discount;
      $this->orderItem->PromoCode = $couponActivated->Coupon->Code;
    }
    else
    {
      $this->orderItem->Discount = 0;
      $this->orderItem->PromoCode = '';
    }

    if ($this->orderItem->Discount == 1)
    {
      $this->orderItem->PayType = 'promo';
    }
    else
    {
      $this->orderItem->PayType = 'individual';
      foreach ($orderItem->Orders as $order)
      {
        if (!empty($order->OrderJuridical) && $order->OrderJuridical->Paid == 1)
        {
          $this->orderItem->PayType = 'juridical';
        }
      }
    }

    return $this->orderItem;
  }


  protected $product;
  /**
   * @param \pay\models\Product $product
   * @param string $time
   * @return \stdClass
   */
  public function CreateProduct($product, $time = null)
  {
    $this->product = new \stdClass();

    $this->product->ProductId = $product->ProductId;
    $this->product->Manager = $product->Manager;
    $this->product->Title = $product->Title;
    $this->product->Price = $product->GetPrice($time);

    return $this->product;
  }

  protected $detailLog;

  /**
   * @param \ruvents\models\DetailLog $detailLog
   * @return \stdClass
   */
  public function CreateDetailLog($detailLog)
  {
    $this->detailLog = new \stdClass();
    $this->detailLog->OperatorId = $detailLog->OperatorId;
    $this->detailLog->Changes = $detailLog->getChangeMessages();
    $this->detailLog->Time = $detailLog->CreationTime;

    return $this->detailLog;
  }

  /**
   * @param \application\models\translation\ActiveRecord $model
   * @return \stdClass
   */
  protected function getLocales($model)
  {
    $locales = new \stdClass();
    foreach (\Yii::app()->params['locales'] as $locale)
    {
      $model->setLocale($locale);
      $localeStd = new \stdClass();
      foreach ($model->getTranslationFields() as $key)
      {
        $localeStd->{$key} = $model->{$key};
      }
      $locales->{$locale} = $localeStd;
    }
    $model->resetLocale();
    return $locales;
  }
}

