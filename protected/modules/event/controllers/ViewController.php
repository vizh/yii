<?php
use application\components\controllers\PublicMainController;
use application\components\utility\Texts;
use event\models\Event;
use event\models\Role;
use partner\models\PartnerCallback;
use user\models\User;

class ViewController extends PublicMainController
{
    public function actionIndex($idName)
    {
        /** @var $event \event\models\Event */
        $event = Event::model()
            ->byIdName($idName)
            ->byDeleted(false)
            ->with('Attributes', 'Widgets')
            ->find();

        if ($event === null) {
            throw new CHttpException(404);
        }

        $user = Yii::app()
            ->getUser()
            ->getCurrentUser();

        PartnerCallback::start($event);
        if ($user !== null) {
            PartnerCallback::registration($event, $user);
        }

        $this->setPageTitle("{$event->Title}  / RUNET-ID");
        if (!$event->Visible) {
            Yii::app()->getClientScript()->registerMetaTag('noindex,noarchive', 'robots');
        }

        foreach ($event->Widgets as $widget) {
            $widget->process();
        }

        // Быстрая регистрация
        if ($user !== null && isset($_GET['quickreg']) === true) {
            // Если посетитель не является участником мероприятия, то регистрируем его как "Виртуальный участник"
            if ($event->hasParticipant($user) === false) {
                $event->registerUser($user, Role::model()->findByPk(Role::VIRTUAL_ROLE_ID));
            }
        }

        $this->render('index', [
            'event' => $event
        ]);
    }

    public function actionUsers($idName, $term = '')
    {
        $term = (new Texts())->filterPurify(trim($term));

        $event = Event::model()
            ->byIdName($idName)
            ->byDeleted(false)
            ->with('Attributes', 'Widgets')
            ->find();

        if ($event === null) {
            throw new CHttpException(404);
        }

        $criteria = new \CDbCriteria();
        if (!empty($term)) {
            $criteria->mergeWith(
                User::model()
                    ->bySearch($term)
                    ->getDbCriteria()
            );
        }

        $users = $this->widget('\event\widgets\Users', [
            'event' => $event,
            'showCounter' => false,
            'showPagination' => true,
            'criteria' => $criteria
        ], true);

        $this->setPageTitle("{$event->Title}  / RUNET-ID");
        $this->render('users', [
            'event' => $event,
            'users' => $users
        ]);
    }

    public function actionShare($targetService, $idName)
    {
        $event = Event::model()
            ->byIdName($idName)
            ->byDeleted(false)
            ->find();

        if ($event === null) {
            throw new CHttpException(404);
        }

        $dateStart = $event->getFormattedStartDate('yyyyMMddT090000');
        $dateEnd = $event->getFormattedEndDate('yyyyMMddT180000');

        switch ($targetService) {
            case 'iCal':
                header('Content-Type: text/Calendar');
                header('Content-Disposition: attachment; filename="'.$event->IdName.'.ics"');
                $this->renderPartial('ical', [
                    'event' => $event,
                    'dateStart' => $dateStart,
                    'dateEnd' => $dateEnd
                ]);
                Yii::app()->disableOutputLoggers();
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