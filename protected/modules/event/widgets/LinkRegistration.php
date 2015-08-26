<?php
namespace event\widgets;

/**
 * Class LinkRegistration
 * @package event\widgets
 *
 * @property string $LinkRegistration
 */
class LinkRegistration extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return ['LinkRegistration'];
    }


    public function run()
    {
        if ($this->getEvent()->isRegistrationClosed()) {
            return;
        }

        /** @var \event\models\Participant $participant */
        $participant = null;
        if (!\Yii::app()->user->getIsGuest()) {
            if (count($this->event->Parts) == 0) {
                $participant = \event\models\Participant::model()
                    ->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->find();
            } else {
                $participants = \event\models\Participant::model()->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->findAll();
                foreach ($participants as $p) {
                    if ($participant == null || $participant->Role->Priority < $p->Role->Priority) {
                        $participant = $p;
                    }
                }
            }
        }

        $this->render('linkregistration', ['participant' => $participant]);
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Переход на страницу регистрации на сайт мероприятия');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }
}