<?php

class UserMerge extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    if (Yii::app()->getRequest()->getIsPostRequest())
    {
      $checked = Registry::GetRequestVar('checked', false);
      $rocId = intval(Registry::GetRequestVar('main_rocid', 0));
      $second = Registry::GetRequestVar('second_rocid', 0);
      $parts = preg_split('/\,/', $second, -1, PREG_SPLIT_NO_EMPTY);
      if ($checked === false)
      {
        $this->view->MainUser = $this->getUserHtml($rocId);
        $second = '';
        foreach ($parts as $part)
        {
          $part = intval(trim($part));
          if ($part != $rocId)
          {
            $userInfo = $this->getUserHtml($part);
            if (! empty($userInfo))
            {
              $this->view->SecondUsers .= $userInfo;
              $second .= $part . ',';
            }

          }
        }

        $this->view->SetTemplate('error');
        if (empty($this->view->MainUser))
        {
          $this->view->Error = 'Не найдень основной пользователь';
        }
        elseif (empty($this->view->SecondUsers))
        {
          $this->view->Error = 'Не найдено ни одного дополнительного пользователя';
        }
        else
        {
          $this->view->Main = $rocId;
          $this->view->Second = $second;
          $this->view->SetTemplate('check');
        }
      }
      else
      {
        $user = User::GetByRocid($rocId);
        if (empty($user))
        {
          $this->view->SetTemplate('error');
          $this->view->Error = 'Не найдень основной пользователь';
        }
        else
        {
          foreach ($parts as $part)
          {
            $part = intval(trim($part));
            $secondUser = User::GetByRocid($part);
            if ($part != $rocId && ! empty($secondUser))
            {
              $this->mergeUsers($user, $secondUser);
            }
          }
          $user->save();
          $this->view->SetTemplate('success');
        }
      }

    }
    echo $this->view;
  }

  /**
   * @param int $rocId
   * @return string
   */
  private function getUserHtml($rocId)
  {
    $user = User::GetByRocid($rocId);
    if (empty($user))
    {
      return '';
    }
    $view = new View();
    $view->SetTemplate('user');
    $view->RocId = $user->RocId;
    $view->LastName = $user->LastName;
    $view->FirstName = $user->FirstName;
    $view->FatherName = $user->FatherName;
    $view->Photo = $user->GetMiniPhoto();
    $view->Email = $user->Email;
    return $view;
  }

  /**
   * @param User $main
   * @param User $second
   * @return bool
   */
  private function mergeUsers($main, $second)
  {
    if (empty($main->LastName) && ! empty($second->LastName))
    {
      $main->LastName = $second->LastName;
    }
    if (empty($main->FirstName) && ! empty($second->FirstName))
    {
      $main->FirstName = $second->FirstName;
    }
    if (empty($main->FatherName) && ! empty($second->FatherName))
    {
      $main->FatherName = $second->FatherName;
    }
    if (!strtotime($main->Birthday) && strtotime($second->Birthday))
    {
      $main->Birthday = $second->Birthday;
    }
    if ($main->Sex == 0 && $second->Sex != 0)
    {
      $main->Sex = $second->Sex;
    }

    /* emails */
    if (empty($main->Emails) && !empty($second->Emails))
    {
      $email = $second->Emails[0];
      /** @var ContactEmail $email */
      $email->ChangeUser($second->UserId, $main->UserId);
      $main->Emails = array($email);
    }
    /* address */
    if (empty($main->Addresses) && !empty($second->Addresses))
    {
      $address = $second->Addresses[0];
      /** @var ContactAddress $address */
      $address->ChangeUser($second->UserId, $main->UserId);
      $main->Addresses = array($address);
    }
    elseif (!empty($main->Addresses) && !empty($second->Addresses))
    {
      $address = $main->Addresses[0];
      $secondAddress = $second->Addresses[0];
      /** @var ContactAddress $secondAddress */
      if ($address->CityId == 0)
      {
        $address->CityId = $secondAddress->CityId;
        $address->save();
      }
    }
    /* phones */
    foreach ($second->Phones as $phone)
    {
      $phone->ChangeUser($second->UserId, $main->UserId);
    }
    /* sites */
    foreach ($second->Sites as $site)
    {
      $site->ChangeUser($second->UserId, $main->UserId);
    }
    /* service accounts */
    foreach ($second->ServiceAccounts as $service)
    {
      $flag = true;
      if ($service->ServiceTypeId == UserConnect::FacebookId || $service->ServiceTypeId == UserConnect::TwitterId)
      {

        foreach ($main->ServiceAccounts as $mainService)
        {
          if ($service->ServiceTypeId == $mainService->ServiceTypeId)
          {
            $flag = false;
            break;
          }
        }
      }
      if ($flag)
      {
        $service->ChangeUser($second->UserId, $main->UserId);
      }
    }
    $main->ServiceAccounts = array_merge($main->ServiceAccounts, $second->ServiceAccounts);

    /* work */
    foreach ($second->Employments as $employment)
    {
      $employment->UserId = $main->UserId;
      $employment->save();
    }

    /* events */
    foreach ($second->EventUsers as $eventUser)
    {
      $eventUser->UserId = $main->UserId;
      $eventUser->save();
    }

    $second->Hide();

    return true;
  }
}
