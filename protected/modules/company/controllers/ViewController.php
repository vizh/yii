<?php
class ViewController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($companyId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkEmails', 
      'LinkEmails.Email',
      'LinkSite', 
      'LinkSite.Site',
      'LinkPhones', 
      'LinkPhones.Phone',
      'LinkAddress',
      'LinkAddress.Address',
      'LinkAddress.Address.City',
      'EmploymentsAll' => array(
        'together' => false, 
        'order' => '"User"."StartYear" DESC, "User"."StartMonth" DESC',
        'with' => array('User')  
      )
    );
    $company = company\models\Company::model()->findByPk($companyId, $criteria);
    if ($company == null)
    {
      throw new CHttpException(404);
    }
   
    
    $employments = array();
    $employmentsEx = array();
    foreach ($company->EmploymentsAll as $employment)
    {
      if (!isset($employments[$employment->UserId]) && !isset($employmentsEx[$employment->UserId]))
      {
        if (empty($employment->EndYear) || $employment->EndYear >= date('Y'))
        {
          $employments[$employment->UserId] = $employment; 
        }
        else 
        {
          $employmentsEx[$employment->UserId] = $employment;
        }
      }
    }
    
    $this->render('index', array(
      'company' => $company, 
      'employments' => $employments,
      'employmentsEx' => $employmentsEx
    ));
  }
}