<?php
class ResultController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($term = '')
  {
    $search = new \search\models\Search();
    $tab = \Yii::app()->request->getParam('tab', \search\components\SearchResultTabId::User);
    $textUtility = new \application\components\utility\Texts();
    $term = $textUtility->filterPurify(trim($term));
    
    $paginators = new \stdClass();
      
    $userModel = \user\models\User::model();
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Employments' => array('together' => false),
      'Settings'
    );
    $userModel->getDbCriteria()->mergeWith($criteria);
    $paginators->User = new \application\components\utility\Paginator($userModel->bySearch($term)->count(), array(
      'tab' => \search\components\SearchResultTabId::User
    ));
    if ($tab !== \search\components\SearchResultTabId::User)
    {
      $paginators->User->page = 1;
    }
    $userModel->getDbCriteria()->mergeWith($paginators->User->getCriteria());
    
    
    $companyModels = \company\models\Company::model();
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'LinkAddress.Address.City',
      'Employments' => array('together' => false),
      'LinkPhones' => array(
        'together' => false,
        'with' => array('Phone')
      ),
      'LinkEmails' => array(
        'together' => false,
        'with' => array('Email')
      ),
      'LinkSite.Site'
    );
    $companyModels->getDbCriteria()->mergeWith($criteria);
    $paginators->Company = new \application\components\utility\Paginator($companyModels->bySearch($term)->count(), array(
      'tab' => \search\components\SearchResultTabId::Companies
    ));
    if ($tab !== \search\components\SearchResultTabId::Companies)
    {
      $paginators->Company->page = 1;
    }
    $companyModels->getDbCriteria()->mergeWith($paginators->Company->getCriteria());
    
    
    $search->appendModel($userModel)->appendModel($companyModels);
    $this->render('index', array(
      'results' => $search->findAll($term),
      'term' => $term,
      'paginators' => $paginators
    ));
  }
}
