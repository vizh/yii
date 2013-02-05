<?php
class ResultController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($term)
  {
    $search = new \search\models\Search();
    $tab = \Yii::app()->request->getParam('tab', \search\components\SearchResultTabId::User);
    $page  = \Yii::app()->request->getParam('page', 1);
    if ($page < 1)
    {
      $page = 1;
    }
    $offset = ($page - 1) * \Yii::app()->params['SearchResultPerPage'];
    
    
    $userModel = \user\models\User::model();
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Employments' => array('together' => false),
      'Settings'
    );
    $criteria->limit = \Yii::app()->params['SearchResultPerPage'];
    if ($tab == \search\components\SearchResultTabId::User)
    {
      $criteria->limit *= $page;
      $criteria->offset = $offset;
    }    
    $userModel->getDbCriteria()->mergeWith($criteria);
    
    
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
    $criteria->limit = \Yii::app()->params['SearchResultPerPage'];
    if ($tab == \search\components\SearchResultTabId::Companies)
    {
      $criteria->limit *= $page;
      $criteria->offset = $offset;
    }
    $companyModels->getDbCriteria()->mergeWith($criteria);
    
    
    $search->appendModel($userModel)->appendModel($companyModels);
    $this->render('index', array(
      'results' => $search->findAll($term),
      'term' => $term,
      'tab' => $tab
    ));
  }
}
