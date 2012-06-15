<?php
AutoLoader::Import('library.rocid.company.*');
 
class CompanyMerge extends AdminCommand
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
      $companyId = intval(Registry::GetRequestVar('main_id', 0));
      $second = Registry::GetRequestVar('second_id', 0);
      $parts = preg_split('/\,/', $second, -1, PREG_SPLIT_NO_EMPTY);
      if ($checked === false)
      {
        $this->view->MainCompany = $this->getCompanyHtml($companyId);
        $second = '';
        foreach ($parts as $part)
        {
          $part = intval(trim($part));
          if ($part != $companyId)
          {
            $companyInfo = $this->getCompanyHtml($part);
            if (! empty($companyInfo))
            {
              $this->view->SecondCompanies .= $companyInfo;
              $second .= $part . ',';
            }
          }
        }

        $this->view->SetTemplate('error');
        if (empty($this->view->MainCompany))
        {
          $this->view->Error = 'Не найдена основная компания';
        }
        elseif (empty($this->view->SecondCompanies))
        {
          $this->view->Error = 'Не найдено ни одной дополнительной компании';
        }
        else
        {
          $this->view->Main = $companyId;
          $this->view->Second = $second;
          $this->view->SetTemplate('check');
        }
      }
      else
      {
        $company = Company::GetById($companyId);
        if (empty($company))
        {
          $this->view->SetTemplate('error');
          $this->view->Error = 'Не найдена основная компания';
        }
        else
        {
          foreach ($parts as $part)
          {
            $part = intval(trim($part));
            $secondCompany = Company::GetById($part);
            if ($part != $companyId && ! empty($secondCompany))
            {
              $this->mergeCompanies($company, $secondCompany);
            }
          }
          $company->save();
          $this->view->SetTemplate('success');
        }
      }

    }
    echo $this->view;
  }

  /**
   * @param int $companyId
   * @return string
   */
  private function getCompanyHtml($companyId)
  {
    $company = Company::GetById($companyId);
    if (empty($company))
    {
      return '';
    }
    $view = new View();
    $view->SetTemplate('company');
    $view->CompanyId = $company->CompanyId;
    $view->Name = $company->Name;
    $view->Logo = $company->GetLogo();
    return $view;
  }

  /**
   * @param Company $main
   * @param Company $second
   * @return bool
   */
  private function mergeCompanies($main, $second)
  {
    /* general info */
    if (empty($main->Info))
    {
      $main->Info = $second->Info;
    }
    /* address  */
    if (empty($main->Addresses) && !empty($second->Addresses))
    {
      $address = $second->Addresses[0];
      /** @var ContactAddress $address */
      $address->ChangeCompany($second->CompanyId, $main->CompanyId);
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
    /* emails */
    if (empty($main->Emails) && !empty($second->Emails))
    {
      $email = $second->Emails[0];
      /** @var ContactEmail $email */
      $email->ChangeCompany($second->CompanyId, $main->CompanyId);
      $main->Emails = array($email);
    }
    /* phones */
    foreach ($second->Phones as $phone)
    {
      $phone->ChangeCompany($second->CompanyId, $main->CompanyId);
    }
    /* sites */
    foreach ($second->Sites as $site)
    {
      $site->ChangeCompany($second->CompanyId, $main->CompanyId);
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
        $service->ChangeCompany($second->CompanyId, $main->CompanyId);
      }
    }
    $main->ServiceAccounts = array_merge($main->ServiceAccounts, $second->ServiceAccounts);

    /* Employers */
    foreach ($second->UsersAll as $userEmployment)
    {
      $userEmployment->CompanyId = $main->CompanyId;
      $userEmployment->save();
    }

    $second->delete();

    return true;
  }
}
