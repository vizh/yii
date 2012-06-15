<?php
AutoLoader::Import('library.rocid.company.*');

class CompanyAjaxGet extends AjaxNonAuthCommand
{


  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $name = Registry::GetRequestVar('term');
    $companies = Company::SearchCompaniesByName($name, 10);
    $result = array();
    foreach ($companies as $company)
    {
      $result[] = array('id' => $company->CompanyId, 'label' => $company->GetName());
    }
    echo json_encode($result);
  }
}
 
