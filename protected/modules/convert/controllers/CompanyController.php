<?php
class CompanyController extends convert\components\controllers\Controller
{
  /** 
   * Конвертирует Компании 
   */
  public function actionIndex()
  {
    $companies = $this->queryAll('SELECT * FROM `Company` ORDER BY CompanyId');
    foreach ($companies as $company)
    {
      $newCompany = new \company\models\Company();
      $newCompany->Id = $company['CompanyId'];
      $newCompany->Name = $company['Name'];
      if (!empty($company['FullName']))
      {
        $newCompany->FullName = $company['FullName'];
      }
      if (!empty($company['Info']))
      {
        $newCompany->Info = $company['Info'];
      }
      if ($company['CreationTime'] != 0)
      {
        $newCompany->CreationTime = date('Y-m-d H:i:s', $company['CreationTime']);
      }
      if ($company['UpdateTime'] != 0)
      {
        $newCompany->UpdateTime = date('Y-m-d H:i:s', $company['UpdateTime']);
      }
      $newCompany->save();
    }
  }
  
  
   /**
   * Переносит связи с адресами
   */
  public function actionLinkaddress()
  {
    $links = $this->queryAll('SELECT * FROM `Link_Company_ContactAddress` ORDER BY `NMID` ASC');
    foreach ($links as $link)
    {
      $newLink = new \company\models\LinkAddress();
      $newLink->Id = $link['NMID'];
      $newLink->CompanyId = $link['CompanyId'];
      $newLink->AddressId = $link['AddressId'];
      $newLink->save();
    }
  }
  
  /**
   * Переносит связи с Email
   */
  public function actionLinkemail()
  {
    $links = $this->queryAll('SELECT * FROM `Link_Company_ContactEmail` ORDER BY `NMID` ASC');
    foreach ($links as $link)
    {
      $newLink = new \company\models\LinkEmail();
      $newLink->Id = $link['NMID'];
      $newLink->CompanyId = $link['CompanyId'];
      $newLink->EmailId = $link['EmailId'];
      $newLink->save();
    }
  }
  
  /**
   * Переносит связи с телефонами
   */
  public function actionLinkphone()
  {
    $links = $this->queryAll('SELECT * FROM `Link_Company_ContactPhone` ORDER BY `NMID` ASC');
    foreach ($links as $link)
    {
      $newLink = new \company\models\LinkPhone();
      $newLink->Id = $link['NMID'];
      $newLink->CompanyId = $link['CompanyId'];
      $newLink->PhoneId = $link['PhoneId'];
      $newLink->save();
    }
  }
  
  /**
   * Переносит связи с сайтами
   */
  public function actionLinksite()
  {
    $links = $this->queryAll('SELECT * FROM `Link_Company_ContactSite` ORDER BY `NMID` ASC');
    foreach ($links as $link)
    {
      $newLink = new \company\models\LinkSite();
      $newLink->Id = $link['NMID'];
      $newLink->CompanyId = $link['CompanyId'];
      $newLink->SiteId = $link['SiteId'];
      $newLink->save();
    }
  }
}
