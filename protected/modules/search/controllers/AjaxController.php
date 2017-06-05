<?php

class AjaxController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($term)
    {
        $search = new \search\models\Search();

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Employments' => ['together' => false],
            'Settings'
        ];
        $criteria->limit = 5;
        $userModel = \user\models\User::model()->byVisible(true);
        $userModel->getDbCriteria()->mergeWith($criteria);
        $search->appendModel($userModel);

        $criteria = new \CDbCriteria();
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
        $criteria->limit = 5;
        $companyModel = \company\models\Company::model();
        $companyModel->getDbCriteria()->mergeWith($criteria);
        $search->appendModel($companyModel);

        $criteria = new \CDbCriteria();
        $criteria->limit = 5;
        $eventModel = \event\models\Event::model()->orderByDate('DESC')->byVisible(true);
        $eventModel->getDbCriteria()->mergeWith($criteria);
        $search->appendModel($eventModel);

        $response = [];

        $results = $search->findAll($term);
        if (!empty($results->Results)) {
            foreach ($results->Results as $model => $records) {
                foreach ($records as $record) {
                    $item = new \stdClass();
                    switch ($model) {
                        case get_class($userModel):
                            $item->url = $this->createUrl('/user/view/index', ['runetId' => $record->RunetId]);
                            $item->value = $record->getFullName();
                            if ($record->employmentPrimary) {
                                $item->value .= ' ('.$record->employmentPrimary.')';
                            }
                            $item->runetid = $record->RunetId;
                            $item->category = \Yii::t('app', 'Пользователи');
                            break;

                        case get_class($companyModel):
                            $item->url = $this->createUrl('/company/view/index', ['companyId' => $record->Id]);
                            $item->value = $record->Name;
                            if ($record->LinkAddress !== null) {
                                $item->locality = $record->LinkAddress->Address->City->Name;
                            }
                            $item->category = \Yii::t('app', 'Компании');
                            break;

                        case get_class($eventModel):
                            $item->url = $record->getUrl();
                            $item->value = $record->Title;
                            $item->category = \Yii::t('app', 'Мероприятия');
                            break;
                    }
                    $response[] = $item;
                }
            }
        }
        echo json_encode($response);
    }
}
