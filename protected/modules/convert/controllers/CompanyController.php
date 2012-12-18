<?php
class CompanyController extends convert\components\controllers\Controller
{
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
}
