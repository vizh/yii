<?php
class ViewController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($companyId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkEmails.Email',
      'LinkSite.Site', 
      'LinkPhones.Phone',
      'LinkAddress.Address.City',
      'EmploymentsAll' => array(
        'together' => false, 
        'order' => '"User"."LastName" ASC',
        'with' => array('User')  
      )
    );
    $company = company\models\Company::model()->findByPk($companyId, $criteria);
    if ($company == null)
    {
      throw new CHttpException(404);
    }

    $this->setPageTitle($company->Name . '/ RUNET-ID');
   
    $employmentsTmp = array();
    foreach ($company->EmploymentsAll as $employment)
    {
      if (!isset($employmentsTmp[$employment->UserId])
        || ($employmentsTmp[$employment->UserId]->StartYear <= $employment->StartYear 
          && $employmentsTmp[$employment->UserId]->StartMonth <= $employment->StartMonth))
      {
        $employmentsTmp[$employment->UserId] = $employment;
      }
    }
    
  
    $employments = array();
    $employmentsEx = array();
    foreach ($employmentsTmp as $employment)
    {
      if ((empty($employment->EndYear) || $employment->EndYear >= date('Y')) 
        && (empty($employment->EndMonth) || $employment->EndMonth >= date('m')))
      {
        $employments[$employment->UserId] = $employment; 
      }
      else 
      {
        $employmentsEx[$employment->UserId] = $employment;
      }
    }
    
    $this->bodyId = 'company-account';
    $this->render('index', array(
      'company' => $company, 
      'employments' => $employments,
      'employmentsEx' => $employmentsEx
    ));
  }
}