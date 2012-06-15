<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');

class GateLogin extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    /**
     * Принимаемые данные
     */
    $rocid = intval(Registry::GetRequestVar('rocid', 0));
    $email = Registry::GetRequestVar('email');
    $passw = Registry::GetRequestVar('passw');
    $passw2 = Registry::GetRequestVar('passw2', '');
    $force = Registry::GetRequestVar('force', false);


    // Полние информации о пользователе
    if ((!empty($rocid) || !empty($email)) && (!empty($passw) || !empty($force)))
    {
      $this->sendUserInfo($rocid, $email, $passw, $passw2, $force);
    }
    else
    {
      $this->sendResponse(202);
    }
  }



  /**
   * Полчение userId из rocID
   *
   * @param int     $rocid    Ключевое слово
   */
  private function sendUserInfo($rocid, $email, $passw, $passw2, $force)
  {
    $with = array('Addresses', 'Phones', 'Employments.Company');
    if (!empty($rocid))
    {
      $user = User::GetByRocid($rocid, $with);
    }
    else
    {
      $user = User::GetByEmail($email, $with);
    }

    if (empty($user) || (!$force && $user->Password != $passw && $user->Password != $passw2))
    {
      $this->SendResponse(201);
    }

    $email = $user->GetEmail() != null ? $user->GetEmail()->Email : $user->Email;

    $result = array('user_id' => $user->UserId, 'rocid' => $user->RocId, 'lastname' => iconv('utf-8', 'cp1251', $user->LastName), 'firstname' => iconv('utf-8', 'cp1251', $user->FirstName), 'fathername' => iconv('utf-8', 'cp1251', $user->FatherName), 'password' => $user->Password, 'email' => trim($email));

    foreach ($user->Employments as $employment)
    {
      if ($employment->Primary && !empty($employment->Company))
      {
        $result['company'] = htmlspecialchars(iconv('utf-8', 'cp1251', $employment->Company->Name));
        $result['position'] = htmlspecialchars(iconv('utf-8', 'cp1251', $employment->Position));
        break;
      }
    }

    $city_id = $user->GetAddress() != null ? $user->GetAddress()->CityId : null;
    if (! empty($city_id))
    {
      $result['city_id'] = $city_id;
    }

    foreach ($user->GetPhones() as $phone)
    {
      if ($phone->Type == ContactPhone::TypeMobile)
      {
        $result['mobilephone'] = $phone->Phone;
        break;
      }
    }
    $event = Event::GetEventByIdName($this->EventName);
    if (! empty($event))
    {
      $eventUser = $user->EventUsers(array('condition'=>'EventUsers.EventId='.$event->EventId));
      if (! empty($eventUser))
      {
        $result['role'] = $eventUser[0]->RoleId;
      }
    }


    $result['key'] = substr(md5($user->Password.$user->RocId), 1, 16);
    $this->SendResponse(0, array($result));
  }
}