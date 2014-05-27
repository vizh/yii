<?php
namespace ruvents\components;

class DataBuilder
{
  private $eventId;
  public function __construct($eventId)
  {
    $this->eventId = $eventId;
  }

  private $activeEvent = null;

  /**
   * @return \event\models\Event
   */
  public function getEvent()
  {
    if ($this->activeEvent == null)
    {
      $this->activeEvent = \event\models\Event::model()->findByPk($this->eventId);
    }

    return $this->activeEvent;
  }

  protected $operator;

  /**
   * @param \ruvents\models\Operator $operator
   * @return \stdClass
   */
  public function createOperator($operator)
  {
    $this->operator = new \stdClass();

    $this->operator->Id = $operator->Id;
    $this->operator->Login = $operator->Login;
    $this->operator->Password = $operator->Password;
    $this->operator->Role = $operator->Role;

    return $this->operator;
  }

  protected $user;
  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function createUser($user)
  {
    $this->user = new \stdClass();

    $this->user->RunetId = $user->RunetId;
    $this->user->LastName = $user->LastName;
    $this->user->FirstName = $user->FirstName;
    $this->user->FatherName = $user->FatherName;
    $this->user->Birthday = $user->Birthday;
    $this->user->UpdateTime = $user->UpdateTime;
    $this->user->Gender = $user->Gender;
    $this->user->CreationTime = $user->CreationTime;
    $this->user->UpdateTime = $user->UpdateTime;
    $this->user->Email = trim($user->Email);
    $this->user->Locales = $this->getLocales($user);

    $this->user->Photo = new \stdClass();
    $this->user->Photo->Small = $user->getPhoto()->get50px();
    $this->user->Photo->Medium = $user->getPhoto()->get90px();
    $this->user->Photo->Large = $user->getPhoto()->get200px();

    return $this->user;
  }

  /**
   *
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function buildUserPhone ($user)
  {

      //todo: Хот фикс для девкон
      if (sizeof($user->LinkPhones) > 0) {
          $this->user->Phone = (string)$user->LinkPhones[0]->Phone;
      }
      return;
    $this->user->Phones = array();
    if (sizeof($user->LinkPhones) > 0)
    {
      $this->user->Phones = array();
      foreach ($user->LinkPhones as $link)
      {
        $this->user->Phones[] = (string)$link->Phone;
      }
    }
    return $this->user;
  }


  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function buildUserEmployment($user)
  {
    foreach ($user->Employments as $employment)
    {
      if ($employment->Primary == 1 && !empty($employment->Company))
      {
        $this->user->Work = new \stdClass();
        $this->user->Work->Position = $employment->Position;
        $this->user->Work->Company = $this->CreateCompany($employment->Company);
        $this->user->Work->StartYear = $employment->StartYear;
        $this->user->Work->StartMonth = $employment->StartMonth;
        $this->user->Work->EndYear = $employment->EndYear;
        $this->user->Work->EndMonth = $employment->EndMonth;
        return $this->user;
      }
    }

    return $this->user;
  }

  /**
   * @param \user\models\User $user
   * @return \stdClass
   */
  public function buildUserEvent($user)
  {
    $this->user->Statuses = [];

    foreach ($user->Participants as $participant)
      if ($participant->EventId == $this->eventId)
        $this->user->Statuses[$participant->PartId ? $participant->PartId : 0] = $participant->RoleId;

    /**
     * Данное преобразование важно для корректной передачи роли безпартийного мероприятия
     * виде ассоциативного масива с индексом 0. То есть "Statuses":{"0":1}
     */
    $this->user->Statuses = (object) $this->user->Statuses;

    return $this->user;
  }

  protected $company;
  /**
   * @param \company\models\Company $company
   * @return \stdClass
   */
  public function createCompany($company)
  {
    $this->company = new \stdClass();

    $this->company->CompanyId = $company->Id;
    $this->company->Name = $company->Name;
    $this->company->Locales = $this->getLocales($company);
    return $this->company;
  }

  protected $event;
  /**
   *
   */
  public function createEvent()
  {
    $this->event = new \stdClass();

    $this->event->EventId = $this->getEvent()->Id;
    $this->event->IdName = $this->getEvent()->IdName;
    $this->event->Title = $this->getEvent()->Title;
    $this->event->Info = $this->getEvent()->Info;

    /*$this->event->DateStart = $this->getEvent()->DateStart;
    $this->event->DateEnd = $this->getEvent()->DateEnd;

    $this->event->Image = new \stdClass();
    $this->event->Image->Mini = 'http://rocid.ru' . $this->Event()->GetMiniLogo();
    $this->event->Image->Normal = 'http://rocid.ru' . $this->Event()->GetLogo();*/

    $this->event->Parts = [];
    foreach ($this->getEvent()->Parts as $part)
    {
      $resultPart = new \stdClass();
      $resultPart->PartId = $part->Id;
      $resultPart->Title = $part->Title;
      $resultPart->Order = $part->Order;

      $this->event->Parts[] = $resultPart;
    }

    return $this->event;
  }

  protected $badge;

  /**
   * @param \ruvents\models\Badge $badge
   * @return \stdClass
   */
  public function createBadge($badge)
  {
    $this->badge = new \stdClass();

    $this->badge->RunetId = $badge->User->RunetId;
    $this->badge->RoleId = $badge->RoleId;
    $this->badge->RoleName = $badge->Role->Title;
    $this->badge->PartId = $badge->PartId;
    $this->badge->OperatorId = $badge->OperatorId;
    $this->badge->CreationTime = $badge->CreationTime;

    return $this->badge;
  }

  protected $role;

  /**
   * @param \event\models\Role $role
   *
   * @return \stdClass
   */
  public function createRole($role)
  {
    $this->role = new \stdClass();
    $this->role->RoleId = $role->Id;
    $this->role->Name = $role->Title;

    return $this->role;
  }

  protected $part;

  /**
   * @param \event\models\Part $part
   *
   * @return \stdClass
   */
  public function createPart($part)
  {
    $this->part = new \stdClass();
    $this->part->RoleId = $part->Id;
    $this->part->Name = $part->Title;
    $this->part->Order = $part->Order;

    return $this->part;
  }

  protected $orderItem;
  /**
   * @param \pay\models\OrderItem $orderItem
   * @return \stdClass
   */
  public function createOrderItem($orderItem)
  {
    $this->orderItem = new \stdClass();

    $this->orderItem->OrderItemId = $orderItem->Id;
    $this->orderItem->Product = $this->createProduct($orderItem->Product, $orderItem->PaidTime);
    $this->orderItem->PriceDiscount = $orderItem->getPriceDiscount();
    $this->orderItem->Paid = $orderItem->Paid;
    $this->orderItem->PaidTime = $orderItem->PaidTime;
    $this->orderItem->Booked = $orderItem->Booked;

    $couponActivation = $orderItem->getCouponActivation();

    if ($couponActivation !== null)
    {
      $this->orderItem->Discount = $couponActivation->Coupon->Discount;
      $this->orderItem->PromoCode = $couponActivation->Coupon->Code;
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
      foreach ($orderItem->OrderLinks as $link)
      {
        if ($link->Order->Type == \pay\models\OrderType::Juridical && $link->Order->Paid)
        {
          $this->orderItem->PayType = 'juridical';
        }
      }
    }

    return $this->orderItem;
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return \stdClass
   */
  public function buildOrderItemOwners($orderItem)
  {
    $this->orderItem->Owner = $this->createUser($orderItem->Owner);
    $this->orderItem->ChangedOwner = !empty($orderItem->ChangedOwner) ? $this->createUser($orderItem->ChangedOwner) : null;

    return $this->orderItem;
  }

  protected $product;
  /**
   * @param \pay\models\Product $product
   * @param string $time
   * @return \stdClass
   */
  public function createProduct($product, $time = null)
  {
    $this->product = new \stdClass();

    $this->product->ProductId = $product->Id;
    $this->product->Manager = $product->ManagerName;
    $this->product->Title = $product->Title;
    $this->product->Price = $product->getPrice($time);

    return $this->product;
  }

  protected $detailLog;

  /**
   * @param \ruvents\models\DetailLog $detailLog
   * @return \stdClass
   */
  public function createDetailLog($detailLog)
  {
    $this->detailLog = new \stdClass();
    $this->detailLog->OperatorId = $detailLog->OperatorId;
	$this->detailLog->OperatorLogin = $detailLog->Operator->Login;
    $this->detailLog->Changes = json_encode($detailLog->getChangeMessages());
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
    foreach (\Yii::app()->params['Languages'] as $lang)
    {
      $model->setLocale($lang);
      $localeStd = new \stdClass();
      foreach ($model->getTranslationFields() as $key)
      {
        $localeStd->{$key} = $model->{$key};
      }
      $locales->{$lang} = $localeStd;
    }
    $model->resetLocale();
    return $locales;
  }

  protected $sectionHall;

  /**
   * @param \event\models\section\Hall $hall
   * @return mixed
   */
  public function createSectionHall(\event\models\section\Hall $hall)
  {
    $this->sectionHall = new \stdClass();
    $this->sectionHall->HallId = $hall->Id;
    $this->sectionHall->Title = $hall->Title;
    return $this->sectionHall;
  }
}

