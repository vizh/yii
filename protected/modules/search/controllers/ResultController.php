<?php
use application\components\controllers\PublicMainController;
use application\components\utility\Paginator;
use application\components\utility\Texts;
use company\models\Company;
use event\models\Event;
use search\components\SearchResultTabId;
use search\models\Search;
use user\models\User;

class ResultController extends PublicMainController
{
    private $term;
    private $paginators;
    private $currentTab;
    private $results;

    public function actionIndex($term = '')
    {
        $this->paginators = new \stdClass();
        $this->term = $term;

        $search = new Search();
        $this->currentTab = \Yii::app()->request->getParam('tab', SearchResultTabId::User);
        $textUtility = new Texts();
        $this->term = $textUtility->filterPurify(trim($this->term));


        $criteria = $this->getUserCriteria();
        $criteria->mergeWith(User::model()->byVisible(true)->getDbCriteria());
        $search->appendModel(
            $this->getModelForSearch(User::model(), $criteria, SearchResultTabId::User)
        );

        $search->appendModel(
            $this->getModelForSearch(Company::model(), $this->getCompanyCriteria(), SearchResultTabId::Companies)
        );

        $criteria = new \CDbCriteria();
        $criteria->mergeWith(Event::model()->byVisible(true)->orderByDate('DESC')->getDbCriteria());
        $search->appendModel(
            $this->getModelForSearch(Event::model(), $criteria, SearchResultTabId::Events)
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
        $this->paginators->{get_class($model)} = new Paginator($model->bySearch($this->term)->count(), array(
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
                return SearchResultTabId::User;
            case 'company\models\Company':
                return SearchResultTabId::Companies;
            case 'event\models\Event':
                return SearchResultTabId::Events;
        }
    }

    /**
     * @return CDbCriteria
     */
    private function getUserCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."LastName" ASC, "t"."FirstName" ASC';
        $criteria->with = [
            'Employments' => ['together' => false],
            'Settings'
        ];
        return $criteria;
    }

    /**
     * @return CDbCriteria
     */
    private function getCompanyCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Name" ASC';
        $criteria->with = [
            'LinkAddress.Address.City',
            'Employments' => ['together' => false],
            'LinkPhones' => [
                'together' => false,
                'with' => ['Phone']
            ],
            'LinkEmails' => [
                'together' => false,
                'with' => ['Email']
            ],
            'LinkSite.Site'
        ];
        return $criteria;
    }
}