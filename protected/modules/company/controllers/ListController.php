<?php
class ListController extends \application\components\controllers\PublicMainController
{
  public function actionIndex()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkEmails.Email',
      'LinkSite.Site', 
      'LinkPhones.Phone',
      'LinkAddress.Address.City',
      'Employments' => array('together' => false)
    );
    $companies = \company\models\Company::model()->findAll($criteria);
    
    $this->bodyId = 'companies-list';
    $this->render('index', array('companies' => $companies));
  }
}
