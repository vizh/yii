<?php
class ContactController extends convert\components\controllers\Controller 
{
  /**
   * Переносит адреса
   */
  public function actionAddress()
  {
    $addresses = $this->queryAll('SELECT * FROM `ContactAddress` ORDER BY `AddressId` ASC');
    foreach ($addresses as $address)
    {
      $newAddress = new \contact\models\Address();
      $newAddress->Id = $address['AddressId'];
      if ($address['CityId'] != 0)
      {
        $newAddress->CityId = $address['CityId'];
        $city = \geo\models\City::model()->findByPk($address['CityId']);
        if ($city !== null)
        {
          $newAddress->CountryId = $city->CountryId;
          $newAddress->RegionId = $city->RegionId;
        }
      }
      
      if ($address['PostalIndex'] != 0)
      {
        $newAddress->PostCode = $address['PostalIndex'];
      }
      
      if (!empty($address['Street']))
      {
        $newAddress->Street = $address['Street'];
      }
      
      if (!empty($address['Apartment']))
      {
        $newAddress->Apartment = $address['Apartment'];
      }
      
      if (!empty($address['House']))
      {
        $house = explode('-', $address['House']);
        if (!empty($house[0]))
        {
          $newAddress->House = $house[0];
        }
        if (!empty($house[1]))
        {
          $newAddress->Building = $house[1];
        }
        if (!empty($house[2]))
        {
          $newAddress->Wing = $house[2];
        }
      }
      
      if (!empty($address['GeoPoint']))
      {
        $newAddress->GeoPoint = $address['GeoPoint'];
      }
      $newAddress->save();
    }
  }
  
  /**
   * Пенос Email
   */
  public function actionEmail()
  {
    $emails = $this->queryAll('SELECT * FROM `ContactEmail` ORDER BY `EmailId` ASC');
    foreach ($emails as $email)
    {
      $newEmail = new \contact\models\Email();
      $newEmail->Id = $email['EmailId'];
      $newEmail->Email = $email['Email'];
      $newEmail->Verified = true;
      $newEmail->save();
    }
  }
  
  public function actionServiceAccountType()
  {
    $types = $this->queryAll('SELECT * FROM `ContactServiceType` ORDER BY `ServiceTypeId` ASC');
    foreach ($types as $type)
    {
      $newType = new \contact\models\ServiceType();
      $newType->Id = $type['ServiceTypeId'];
      $newType->Title = $type['Title'];
      $newType->UrlMask = $type['AccountUrlMask'];
      $newType->Pattern = '';
      $newType->save();
    }
  }
  
 /**
  * Перенос Сервисных аккаунтов
  */
  public function actionServiceAccount()
  {
    $accounts = $this->queryAll('SELECT * FROM `ContactServiceAccount` ORDER BY `ServiceId` ASC');
    foreach ($accounts as $account)
    {
      if (!empty($account['Account']))
      {
        $newAccount = new \contact\models\ServiceAccount();
        $newAccount->Id = $account['ServiceId'];
        $newAccount->TypeId = $account['ServiceTypeId'];
        $newAccount->Account = $account['Account'];
        $newAccount->save();
      }
    }
  }
  
  /**
   * Перенести сайты
   */
  public function actionSite()
  {
    $sites = $this->queryAll('SELECT * FROM `ContactSite` ORDER BY `SiteId` ASC');
    foreach ($sites as $site)
    {
      $newSite = new \contact\models\Site();
      $newSite->Id = $site['SiteId'];
      $newSite->Url = str_replace(array('http://', 'https://', 'www.'), '', $site['Url']);
      $newSite->Secure = $site['Secure'] == 1 ? true : false;
      $newSite->save();
    }
  }
}
