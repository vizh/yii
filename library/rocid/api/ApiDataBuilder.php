<?php

class ApiDataBuilder
{
  /**
   * @var ApiAccount
   */
  protected $account;

  /**
   * @param ApiAccount $account
   */
  public function __construct($account)
  {
    $this->account = $account;
  }

  /**
   * @param User $user
   * @param bool $full
   * @return stdClass
   */
  public function UserData($user, $full = true)
  {
    $result = new stdClass();

    $result->RocId = $user->RocId;
    $result->LastName = $user->LastName;
    $result->FirstName = $user->FirstName;
    $result->FatherName = $user->FatherName;

    $result->Photo = new stdClass();
    $result->Photo->Small = $user->GetMiniPhoto();
    $result->Photo->Medium = $user->GetMediumPhoto();
    $result->Photo->Large = $user->GetPhoto();


    if ($full)
    {
      if (!empty($user->Emails))
      {
        $result->Email = $user->Emails[0]->Email;
      }
      else
      {
        $result->Email = $user->Email;
      }

      foreach ($user->Employments as $employment)
      {
        if ($employment->Primary == 1 && !empty($employment->Company))
        {
          $result->Work = new stdClass();
          $result->Work->Position = $employment->Position;
          $result->Work->Company = $this->CompanyData($employment->Company, false);
          break;
        }
      }

      foreach ($user->EventUsers as $eUser)
      {
        if ($eUser->EventId == $this->account->EventId)
        {
          $result->Status = new stdClass();
          $result->Status->RoleId = $eUser->RoleId;
          $result->Status->RoleName = $eUser->EventRole->Name;
          //todo: добавить поле UpdateTime, переделать эти поля в timestamp
        }
      }
    }

    return $result;
  }

  /**
   * @param Company $company
   * @param bool $full
   * @return stdClass
   */
  public function CompanyData($company, $full = true)
  {
    $result = new stdClass();

    $result->CompanyId = $company->CompanyId;
    $result->Name = $company->Name;

    if ($full)
    {
      //todo: Заполнение полных данных о компании
    }

    return $result;
  }

  /**
   * @param OrderItem $orderItem
   * @return stdClass
   */
  public function OrderItemData($orderItem)
  {
    $result = new stdClass();

    $result->OrderItemId = $orderItem->OrderItemId;
    $result->Product = $this->ProductData($orderItem->Product, $orderItem->PaidTime);
    $result->Owner = $this->UserData($orderItem->Owner, false);
    $result->PriceDiscount = $orderItem->PriceDiscount();
    $result->Paid = $orderItem->Paid == 1;
    $result->PaidTime = $orderItem->PaidTime;
    $result->Booked = $orderItem->Booked;

    $result->Params = array();
    foreach ($orderItem->Params as $param)
    {
      $result->Params[$param->Name] = $param->Value;
    }

    $couponActivated = $orderItem->GetCouponActivated();
    $result->Discount = !empty($couponActivated) && !empty($couponActivated->Coupon) ? $couponActivated->Coupon->Discount : 0;

    return $result;
  }

  /**
   * @param Product $product
   * @param string $time
   * @return stdClass
   */
  public function ProductData($product, $time = null)
  {
    $result = new stdClass();

    $result->ProductId = $product->ProductId;
    $result->Manager = $product->Manager;
    $result->Title = $product->Title;
    $result->Price = $product->GetPrice($time);

    $result->Attributes = array();
    foreach ($product->Attributes as $attribute)
    {
      $result->Attributes[$attribute->Name] = $attribute->Value;
    }


    return $result;
  }

  /**
   * @param EventProgram $section
   * @return stdClass
   */
  public function SectionData($section)
  {
    $result = new stdClass();

    $result->SectionId = $section->EventProgramId;
    $result->Type = $section->Type;
    $result->Abbr = $section->Abbr;
    $result->Title = $section->Title;
    $result->Comment = $section->Comment;
    $result->Audience = $section->Audience;
    $result->Rubricator = $section->Rubricator;
    $result->LinkPhoto = $section->LinkPhoto;
    $result->LinkVideo = $section->LinkVideo;
    $result->LinkShorthand = $section->LinkShorthand;
    $result->LinkAudio = $section->LinkAudio;
    $result->Start = $section->DatetimeStart;
    $result->Finish = $section->DatetimeFinish;
    $result->Place = $section->Place;
    $result->Description = $section->Description;
    $result->Partners = $section->Partners;
    $result->Fill = $section->Fill;

    return $result;
  }

  /**
   * @param EventProgram $section
   * @return stdClass[]
   */
  public function SectionReports($section)
  {
    $result = array();
    foreach ($section->UserLinks as $link)
    {
      $report = new stdClass();
      $report->User = $this->UserData($link->User, false);
      $report->SectionRoleId = $link->Role->RoleId;
      $report->SectionRoleName = $link->Role->Name;
      $report->Order = $link->Order;
      if (! empty($link->Report))
      {
        $report->Header = $link->Report->Header;
        $report->Thesis = $link->Report->Thesis;
        $report->LinkPresentation = $link->Report->LinkPresentation;
      }
      $result[] = $report;
    }

    return $result;
  }
}
