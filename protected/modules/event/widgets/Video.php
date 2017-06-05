<?php
namespace event\widgets;

class Video extends \event\components\Widget
{

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Видеотрансляция');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }

    public function process()
    {
        $video = \Yii::app()->getRequest()->getParam('video');
        if (!empty($video)) {
            $this->render('video/iframe', ['video' => $video]);
            \Yii::app()->disableOutputLoggers();
            \Yii::app()->end();
        }
    }

    public function run()
    {
        if ($this->event->Id != 870) {
            return;
        }
        if (\Yii::app()->user->getIsGuest()) {
            $this->render('video/auth');
            return;
        }

        /** @var \event\models\Participant $participant */
        $participant = null;
        if (count($this->event->Parts) == 0) {
            $participant = \event\models\Participant::model()
                ->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->find();
        } else {
            $participants = \event\models\Participant::model()
                ->byUserId(\Yii::app()->user->getCurrentUser()->Id)->byEventId($this->event->Id)->findAll();
            foreach ($participants as $p) {
                if ($participant == null || $participant->Role->Priority < $p->Role->Priority) {
                    $participant = $p;
                }
            }
        }

        if ($participant == null || $participant->RoleId == 24) {
            $this->render('video/access');
            return;
        }

        $this->render('video/index');
    }
}