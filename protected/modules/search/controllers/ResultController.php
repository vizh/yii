<?php
class ResultController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($term)
  {
    $search = new \search\models\Search();
    
    $page  = \Yii::app()->request->getParam('page', 1);
    if ($page < 1)
    {
      $page = 1;
    }
    $search->setPageSettings($page, \Yii::app()->params['SearchResultPerPage']);
    
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Employments' => array('together' => false),
      'Settings'
    );
    $userModel = \user\models\User::model();
    $userModel->getDbCriteria()->mergeWith($criteria);
    
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
    $companyModels = \company\models\Company::model();
    $companyModels->getDbCriteria()->mergeWith($criteria);
    $search->appendModel($userModel)->appendModel($companyModels);
    $this->render('index', array(
      'results' => $search->findAll($term),
      'term' => $term
    ));
  }
}
