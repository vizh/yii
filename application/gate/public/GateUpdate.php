<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');
 
class GateUpdate extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $rocid = intval(Registry::GetRequestVar('rocid'));
    $passw = Registry::GetRequestVar('passw');
    $companyFullName =  iconv('cp1251', 'utf-8', Registry::GetRequestVar('company'));
    $position =  iconv('cp1251', 'utf-8', Registry::GetRequestVar('position'));
    $cityId = intval(Registry::GetRequestVar('city'));
    $email = Registry::GetRequestVar('email');
    $mobilePhone = urldecode(Registry::GetRequestVar('mobilephone'));

    if (!$rocid || !$passw)
    {
      $this->SendResponse(201);
    }

    $user = User::GetByRocid($rocid, array('Addresses.City.Country', 'Employments.Company', 'Phones'));
    if (empty($user))
    {
      $this->SendResponse(202);
    }
    if ($user->GetPassword() != $passw)
    {
      $this->SendResponse(203);
    }
    if (! empty($cityId))
    {
      $city = GeoCity::GetById($cityId);
      if (empty($city))
      {
        $this->SendResponse(204);
      }
      $address = $user->GetAddress();
      if (!empty($address))
      {
        $address->CityId = $city->CityId;
        $address->save();
      }
      else
      {
        $address = new ContactAddress();
        $address->CityId = $city->CityId;
        $address->Primary = 1;
        $address->save();
        $user->AddAddress($address);
      }
    }

    if (! empty($companyFullName))
    {
      preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ|АНО)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \'\"\.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", stripslashes($companyFullName), $matches);
      $companyOpf = (isset($matches[2])) ? $matches[2] : '';
      $companyName = (isset($matches[4])) ? $matches[4] : '';

      $employment = null;
      foreach ($user->Employments as $empl)
      {
        if ($empl->Primary == 1)
        {
          $employment = $empl;
          break;
        }
      }
      if (empty($employment) || $employment->Company->Opf != $companyOpf || $employment->Company->GetName() != $companyName)
      {
        UserEmployment::ResetAllUserPrimary($user->UserId);
        $company = Company::GetCompanyByName($companyName);
        if (empty($company))
        {
          $company = new Company();
          $company->Name = $companyName;
          $company->Opf = $companyOpf;
          $company->CreationTime = time();
          $company->UpdateTime = time();
          $company->save();
        }
        $employment = new UserEmployment();
        $employment->UserId = $user->UserId;
        $employment->CompanyId = $company->CompanyId;
        $employment->SetParsedStartWorking(array('year' => '9999'));
        $employment->SetParsedFinishWorking(array('year' => '9999'));
        $employment->Position = $position;
        $employment->Primary = 1;
        $employment->save();
      }
      elseif ($employment->Position != $position)
      {
        $employment->Position = $position;
        $employment->save();
      }
    }

    if (! empty($mobilePhone))
    {
      ContactPhone::ResetAllUserPrimary($user->UserId);
      $phones = $user->Phones;
      $flag = false;
      foreach ($phones as $phone)
      {
        if ($phone->Phone == $mobilePhone)
        {
          $phone->Primary = 1;
          $phone->save();
          $flag = true;
          break;
        }
      }
      if (! $flag)
      {
        $phone = new ContactPhone();
        $phone->Phone = $mobilePhone;
        $phone->Primary = 1;
        $phone->save();
        $user->AddPhone($phone);
      }
    }

    if (! empty($email))
    {
      if (ContactEmail::GetCountEmails($email) == 0)
      {
        $cEmail = $user->GetEmail();
        if ($cEmail == null)
        {
          $cEmail = new ContactEmail();
          $cEmail->Primary = 1;
          $cEmail->save();
          $user->AddEmail($cEmail);
        }
        $cEmail->Email = $email;
        $cEmail->save();
      }
    }

    $this->SendResponse(0);
  }
}