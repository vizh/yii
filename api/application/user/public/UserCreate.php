<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.geo.*');

class UserCreate extends ApiCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $email = Registry::GetRequestVar('Email');
    $password = Registry::GetRequestVar('Password');
    $lastName = Registry::GetRequestVar('LastName');
    $firstName = Registry::GetRequestVar('FirstName');

    if (empty($email) || empty($password) || empty($lastName) || empty($firstName))
    {
      throw new ApiException(204);
    }

    $emailValidator = new CEmailValidator();
    if (!$emailValidator->validateValue($email))
    {
      throw new ApiException(205);
    }

    $user = User::Register($email, $password);
    if ($user == null)
    {
      throw new ApiException(206);
    }

    $user->LastName = $lastName;
    $user->FirstName = $firstName;
    $user->FatherName = Registry::GetRequestVar('FatherName', '');

    $user->save();

    $user->Settings->Agreement = 1;
    $user->Settings->save();

    $this->addEmployment($user);

    $cityId = Registry::GetRequestVar('City', 0);
    $city = GeoCity::GetById($cityId);
    if ($city !== null)
    {
      $address = new ContactAddress();
      $address->CityId = $city->CityId;
      $address->Primary = 1;
      $address->save();
      $user->AddAddress($address);
    }

    $phone = Registry::GetRequestVar('Phone');
    if (! empty($phone))
    {
      $this->addUserPhone($user, $phone);
    }

    $this->Account->DataBuilder()->CreateUser($user);
    $this->Account->DataBuilder()->BuildUserEmail($user);
    $this->Account->DataBuilder()->BuildUserEmployment($user);
    $result = $this->Account->DataBuilder()->BuildUserEvent($user);

    $this->SendJson($result);
  }

  /**
   * @param User $user
   */
  private function addEmployment($user)
  {
    $companyName = Registry::GetRequestVar('Company', '');
    $position = Registry::GetRequestVar('Position', '');
    if (!empty($companyName) && !empty($position))
    {
      $companyInfo = Company::ParseName($companyName);

      $company = Company::GetCompanyByName($companyInfo['name']);
      if (empty($company))
      {
        $company = new Company();
        $company->Name = $companyInfo['name'];
        $company->Opf = $companyInfo['opf'];
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
  }

  /**
   * @param User $user
   * @param string $phone
   * @param string $type
   * @return void
   */
  private function addUserPhone($user, $phone, $type = ContactPhone::TypeMobile)
  {
    $cPhone = new ContactPhone();
    $cPhone->Phone = $phone;
    $cPhone->Primary = 1;
    $cPhone->Type = $type;
    $cPhone->save();
    $user->AddPhone($cPhone);
  }
}