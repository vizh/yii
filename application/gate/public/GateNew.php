<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.company.*');
 
class GateNew extends GateCommand
{

  // Описание работы
  // ===========================================================

  /**
   * Запрос отправляется методом _GET или _POST, должен содержать следующие
   * обязательные параметры:
   *   &event=[ID мероприятия в системе rocID]
   *   &role=[ID типа участия в мероприятии] (необязательно)
   *   &rocid=[rocID пользователя]
   *   &passw=[MD5-хэш пароля пользователя]
   *   &token=[Уникальный ключ операции]
   *
   * Сервер возвращает ответ в XML-формате, ответ содержит код возможной ошибки:
   *   0   - Операция прошла успешно, пользователь зарегистрирован
   *   101 - Некорректный уникальный ключ
   *   102 - Мероприятия с указанным ID не существует
   *   302 - Такой электронный адрес уже есть
   *   303 - Какое-то из обязательных полей не заполнено
   *
  */


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $lastname = iconv('cp1251', 'utf-8', Registry::GetRequestVar('lastname'));
    $firstname = iconv('cp1251', 'utf-8', Registry::GetRequestVar('firstname'));
    $fathername = iconv('cp1251', 'utf-8', Registry::GetRequestVar('fathername'));
    $email = Registry::GetRequestVar('email');
    $phone = Registry::GetRequestVar('phone');
    $company = iconv('cp1251', 'utf-8', Registry::GetRequestVar('company'));
    $position = iconv('cp1251', 'utf-8', Registry::GetRequestVar('position'));
    $password = iconv('cp1251', 'utf-8', Registry::GetRequestVar('password'));
    $city = intval(Registry::GetRequestVar('city'));
    $mobilePhone = Registry::GetRequestVar('mobilephone');

    if (empty($lastname) || empty($firstname) || empty($email) || empty($password))
    {
      $this->SendResponse(303);
    }
    $user = User::Register($email, $password);
    if ($user == null)
    {
      $this->SendResponse(302);
    }

    $user->LastName = $lastname;
    $user->FirstName = $firstname;
    $user->FatherName = $fathername;
    $user->save();

    $user->Settings->Agreement = 1;
    $user->Settings->save();

    if (! empty($company))
    {
      $this->addUserEmployment($user, $company, $position);
    }

    if (! empty($mobilePhone))
    {
      $this->addUserPhone($user, $mobilePhone, ContactPhone::TypeMobile);
    }
    elseif (!empty($phone))
    {
      $this->addUserPhone($user, $phone, ContactPhone::TypePersonal);
    }

    if (! empty($city))
    {
      $address = new ContactAddress();
      $address->CityId = $city;
      $address->Primary = 1;
      $address->save();
      $user->AddAddress($address);
    }

    $result = array('user_id' => $user->UserId, 'rocid' => $user->RocId, 'lastname' => iconv('utf-8', 'cp1251', $user->LastName), 'firstname' => iconv('utf-8', 'cp1251', $user->FirstName), 'password' => $user->Password, 'email' => $user->GetEmail()->Email);

    $this->SendResponse(0, array($result));
  }

  /**
   * @param User $user
   * @param string $companyName
   * @param string $position
   * @return void
   */
  private function addUserEmployment($user, $companyName, $position)
  {
    preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \'\"\.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", $companyName, $matches);

    $companyOpf = (isset($matches[2])) ? $matches[2] : '';
    $companyName = (isset($matches[4])) ? $matches[4] : '';

    $company = Company::GetCompanyByName($companyName);
    if ($company == null)
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