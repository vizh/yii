<?php

class ListController extends \application\components\controllers\PublicMainController
{
    public function actionIndex()
    {
        $month = \Yii::app()->request->getParam('Month', date('n'));
        $year = \Yii::app()->request->getParam('Year', date('Y'));
        if (empty($month) || empty($year) || ($month > 12 || $month < 1)
            || !preg_match('/^\d{4}$/', $year)
        ) {
            throw new CHttpException(404);
        }

        $eventModel = \event\models\Event::model()->byDate($year, $month)->byVisible(true)->orderByDate('ASC');
        $criteria = new \CDbCriteria();
        $criteria->with = ['LinkAddress', 'LinkAddress.Address', 'Type'];

        $filter = new \event\models\forms\ListFilterForm();
        $filter->attributes = \Yii::app()->getRequest()->getParam(get_class($filter));
        if (\Yii::app()->getRequest()->getIsPostRequest() && $filter->validate()) {
            foreach ($filter->getAttributes() as $attribute => $value) {
                if (!empty($value)) {
                    switch ($attribute) {
                        case 'City':
                            $criteria->addCondition('"Address"."CityId" = :CityId');
                            $criteria->params['CityId'] = intval($value);
                            break;

                        case 'Type':
                            $eventModel = $eventModel->byType($value);
                            break;

                        case 'Query':
                            $eventModel = $eventModel->bySearch($value);
                            break;
                    }
                }
            }
        }

        $allEvents = $eventModel->findAll($criteria);
        $actEvents = $oldEvents = $eventIdList = $topEvents = [];

        foreach ($allEvents as $event) {
            if ($event->getFormattedEndDate('yyyy-MM-dd') >= date('Y-m-d')) {
                if (isset($event->Top) && $event->Top == 1) {
                    $topEvents[] = $event;
                }
                $actEvents[] = $event;
            } else {
                $oldEvents[] = $event;
            }
            $eventIdList[] = $event->Id;
        }
        $events = array_merge($actEvents, $oldEvents);

        $criteria = new \CDbCriteria();
        $eventWithPayAccounts = [];
        $criteria->addInCondition('"t"."EventId"', $eventIdList);
        $payAccounts = \pay\models\Account::model()->findAll($criteria);
        foreach ($payAccounts as $account) {
            $eventWithPayAccounts[] = $account->EventId;
        }

        $eventWithCurrentUser = [];
        if (!\Yii::app()->getUser()->getIsGuest()) {
            $criteria->addCondition('"t"."UserId" = :UserId');
            $criteria->params['UserId'] = \Yii::app()->getUser()->getId();
            $participants = \event\models\Participant::model()->findAll($criteria);
            foreach ($participants as $participant) {
                $eventWithCurrentUser[] = $participant->EventId;
            }
        }

        $this->setPageTitle(\Yii::t('app', 'Календарь мероприятий / RUNET-ID'));
        $this->render('index', [
            'events' => $events,
            'filter' => $filter,
            'topEvents' => $topEvents,
            'eventWithPayAccounts' => $eventWithPayAccounts,
            'eventWithCurrentUser' => $eventWithCurrentUser,
            'month' => $month,
            'year' => $year,
            'nextUrl' => $this->getNextMonthUrl($month, $year),
            'prevUrl' => $this->getPrevMonthUrl($month, $year)
        ]);
    }

    /**
     * Возврщает ссылку на предыдущий месяц
     * @return type
     */
    private function getPrevMonthUrl($currentMonth, $currentYear)
    {
        if ($currentMonth == 1) {
            $prevMonth = 12;
            $prevYear = $currentYear - 1;
        } else {
            $prevMonth = $currentMonth - 1;
            $prevYear = $currentYear;
        }
        return $this->createUrl('/event/list/'.$this->action->getId(), ['Month' => $prevMonth, 'Year' => $prevYear]);
    }

    /**
     * Возврщает ссылку на следующий месяц
     * @return type
     */
    private function getNextMonthUrl($currentMonth, $currentYear)
    {
        if ($currentMonth == 12) {
            $nextMonth = 1;
            $nextYear = $currentYear + 1;
        } else {
            $nextMonth = $currentMonth + 1;
            $nextYear = $currentYear;
        }
        return $this->createUrl('/event/list/'.$this->action->getId(), ['Month' => $nextMonth, 'Year' => $nextYear]);
    }
}
