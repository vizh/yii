<?php
AutoLoader::Import('library.rocid.company.*');

class CompanyList extends AdminCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $companies = array();
    $action = Registry::GetRequestVar('action');
    if (! empty($action))
    {
      if ($action == 'search')
      {
        $query = Registry::GetRequestVar('query_string');
        $field = Registry::GetRequestVar('field');
        if ($field == 'id')
        {
          $query = intval($query);
          $companies[] = Company::model()->findByPk($query);
        }
        elseif ($field == 'name')
        {
          $companies = Company::SearchCompaniesByName($query, 100, Company::LoadContactInfo);
        }
        $this->view->Query = $query;
        $this->view->Field = $field;
      }
    }

    $companyContainer = new ViewContainer();
    foreach ($companies as $company)
    {
      $view = new View();
      $view->SetTemplate('company');

      $view->CompanyId = $company->CompanyId;
      $view->Name = $company->Name;
      $emails = $company->Emails;
      if (! empty($emails))
      {
        $view->Email = $emails[0]->Email;
      }
      $adresses = $company->Addresses;
      if (! empty($adresses))
      {
        /** @var ContactAddress $address */
        $address = $adresses[0];
        $view->CityName = isset($address->City) ? $address->City->Name : '';
        $view->CountryName = isset($address->City->Country) ? $address->City->Country->Name : '';
      }
      $view->Created = date('d.m.Y H:i', $company->CreationTime);
      $view->Updated = date('d.m.Y H:i', $company->UpdateTime);

      $companyContainer->AddView($view);
    }

    if (!$companyContainer->IsEmpty())
    {
      $this->view->Companies = $companyContainer;
    }

    echo $this->view;
  }
}
 
