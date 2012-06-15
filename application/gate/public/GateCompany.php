<?php
AutoLoader::Import('gate.source.*');
AutoLoader::Import('library.rocid.event.*');
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.company.*');
 
class GateCompany extends GateCommand
{

  /**
   * Основные действия комманды
   * @return void
   */
  protected function doExecute()
  {
    $id = Registry::GetRequestVar('company_id');
    $name =  iconv('cp1251', 'utf-8', Registry::GetRequestVar('name'));
    
    $company = null;
    if (! empty($id))
    {
      $company = Company::GetById($id);
      if (! empty($name) && $company->Name != $name)
      {
        $company = null;
      }
    }elseif (! empty($name))
    {
      $company = Company::GetCompanyByName($name);
    }

    $dom = new DOMDocument('1.0', 'cp1251');
    $result = $dom->appendChild(new DOMElement('result'));
    $errorCode = $dom->createElement('error-code');
    $errorCode->nodeValue = '0';
    $result->appendChild($errorCode);

    if (! empty($company))
    {
      $arCompany = array();
      $arCompany['company_id'] = $company->CompanyId;
      $arCompany['name'] = $company->Name;
      $arCompany['full_name'] = $company->FullName;
      $arCompany['opf'] = $company->Opf;

      $deCompany = $dom->createElement('company');
      foreach ($arCompany as $field => $value) {
        $deField = $dom->createElement($field);
        $deField->nodeValue = $value;
        $deCompany->appendChild($deField);
      }
      $result->appendChild($deCompany);
    }

    echo $dom->saveXML();
  }
}