<?php
use event\models\Event;

class ViewController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($idName)
    {
        /** @var $event \event\models\Event */
        $event = Event::model()->byIdName($idName)->byDeleted(false)->with(array('Attributes', 'Widgets'))->find();
        if (empty($event)) {
            throw new CHttpException(404);
        }

        \partner\models\PartnerCallback::start($event);
        if (Yii::app()->user->getCurrentUser() != null)
        {
            \partner\models\PartnerCallback::registration($event, Yii::app()->user->getCurrentUser());
        }

        $this->setPageTitle($event->Title . '  / RUNET-ID');
        if (!$event->Visible)
        {
            \Yii::app()->getClientScript()->registerMetaTag('noindex,noarchive','robots');
        }

        foreach ($event->Widgets as $widget)
        {
            $widget->process();
        }

        $this->render('index', array('event' => $event));
    }

    public function actionUsers($idName, $term = '')
    {
        $textUtility = new \application\components\utility\Texts();
        $term = $textUtility->filterPurify(trim($term));

        /** @var $event \event\models\Event */
        $event = Event::model()->byIdName($idName)->byDeleted(false)->with(array('Attributes', 'Widgets'))->find();;
        if (empty($event))
        {
            throw new CHttpException(404);
        }

        $criteria = new \CDbCriteria();
        if (!empty($term))
        {
            $criteria->mergeWith(
                \user\models\User::model()->bySearch($term)->getDbCriteria()
            );
        }

        $users = $this->widget('\event\widgets\Users', array(
            'event' => $event,
            'showCounter' => false,
            'showPagination' => true,
            'criteria' => $criteria
        ), true);

        $this->setPageTitle($event->Title . '  / RUNET-ID');
        $this->render('users', array(
            'event'     => $event,
            'users'     => $users
        ));
    }

    public function actionShare($targetService, $idName)
    {
        /** @var $event \event\models\Event */
        $event = Event::model()->byIdName($idName)->byDeleted(false)->find();
        if (!$event)
            throw new CHttpException(404);

        // И зачем в базе не хранятся просто даты?..
        $dateStart = sprintf('%d%02d%dT090000', $event->StartYear, $event->StartMonth, $event->StartDay);
        $dateEnd = sprintf('%d%02d%dT180000', $event->EndYear, $event->EndMonth, $event->EndDay);

        switch ($targetService)
        {
            case 'iCal':
                header('Content-Type: text/Calendar');
                header('Content-Disposition: attachment; filename="'.$event->IdName.'.ics"');
                $this->renderPartial('ical', [
                    'event' => $event,
                    'dateStart' => $dateStart,
                    'dateEnd' => $dateEnd
                ]);
                \Yii::app()->disableOutputLoggers();
                break;

            case 'Google':
                $googleRedirectURI = 'http://www.google.com/calendar/event?'.http_build_query([
                        'action' => 'TEMPLATE',
                        'text' => $event->Title,
                        'dates' => $dateStart.'/'.$dateEnd,
                        'location' => !empty($event->LinkAddress) ? $event->LinkAddress->Address->__toString() : '',
                        'details' => ''
                    ]);

                $this->redirect($googleRedirectURI.urlencode(CText::truncate($event->Info, 750 - strlen($googleRedirectURI), '...', true)));
                break;

            default:
                throw new CHttpException(404);
        }
    }
}