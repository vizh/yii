<?php
class ResultController extends \application\components\controllers\PublicMainController
{
  private $term;
  private $paginators;
  private $currentTab;
  private $results;
  
  public function actionIndex($term = '')
  {
    $this->paginators = new \stdClass();
    $this->term = $term;
    
    $search = new \search\models\Search();
    $this->currentTab = \Yii::app()->request->getParam('tab', \search\components\SearchResultTabId::User);
    $textUtility = new \application\components\utility\Texts();
    $this->term = $textUtility->filterPurify(trim($this->term));
   
    
    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
    $criteria->with = array(
      'Employments' => array('together' => false),
      'Settings'
    );
    $criteria->mergeWith(\user\models\User::model()->byVisible(true)->getDbCriteria());
    $search->appendModel(
      $this->getModelForSearch(\user\models\User::model(), $criteria, \search\components\SearchResultTabId::User)
    );

    $criteria = new \CDbCriteria();
    $criteria->order = '"t"."Name" ASC';
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
    $search->appendModel(
      $this->getModelForSearch(\company\models\Company::model(), $criteria, \search\components\SearchResultTabId::Companies)
    );
    
    $criteria = new \CDbCriteria();
    $criteria->mergeWith(\event\models\Event::model()->byVisible(true)->orderByDate('DESC')->getDbCriteria());
    $search->appendModel(
      $this->getModelForSearch(\event\models\Event::model(), $criteria, \search\components\SearchResultTabId::Events)
    );
    
    $this->results = $search->findAll($term);
    
    $this->setPageTitle(\Yii::t('app', 'Результаты поиска'));
    $this->render('index', array(
      'results' => $this->results,
      'activeTabId' => $this->getActiveTabId(),
      'term' => $this->term,
      'paginators' => $this->paginators
    ));
  }
  
  /**
   * 
   * @param \CActiveRecord $model
   * @param \CDbCriteria $criteria
   * @param string $tabId
   * @return \CActiveRecord
   */
  private function getModelForSearch($model, $criteria, $tabId)
  {
    $this->paginators->{get_class($model)} = new \application\components\utility\Paginator($model->bySearch($this->term)->count(), array(
      'tab' => $tabId
    ));
    if ($this->currentTab !== $tabId)
    {
      $this->paginators->{get_class($model)}->page = 1;
    }
    $criteria->mergeWith($this->paginators->{get_class($model)}->getCriteria());
    $model->getDbCriteria()->mergeWith($criteria);
    return $model;
  }
  
  private function getActiveTabId()
  {
    $tabId = \Yii::app()->request->getParam('tab');
    if ($tabId !== null)
      return $tabId;
    
    $max = -1;
    $maxModel = null;
    foreach ($this->results->Counts as $model => $count)
    {
      if ($count > $max)
      {
        $max = $count;
        $maxModel = $model;
      }
    }
    
    switch ($maxModel)
    {
      case 'user\models\User':
        return \search\components\SearchResultTabId::User;
      case 'company\models\Company':
        return \search\components\SearchResultTabId::Companies;
      case 'event\models\Event':
        return \search\components\SearchResultTabId::Events;
    }
  }
}
