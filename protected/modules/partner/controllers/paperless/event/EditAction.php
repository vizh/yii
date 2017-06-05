<?php

namespace partner\controllers\paperless\event;

use application\components\Exception;
use application\components\helpers\ArrayHelper;
use application\models\paperless\DeviceSignal;
use application\models\paperless\Event;
use application\models\paperless\Event as EventModel;
use partner\components\Action;
use partner\models\forms\paperless\Event as EventForm;
use Yii;

class EditAction extends Action
{
    public function run($id = null)
    {
        $event = $id === null
            ? new EventModel()
            : EventModel::model()->findByPk($id);

        if ($event === null) {
            throw new Exception(404);
        }

        $form = new EventForm($this->getEvent(), $event);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $model = $event->isNewRecord
                ? $form->createActiveRecord()
                : $form->updateActiveRecord();

            if ($model !== null && Yii::app()->getRequest()->getParam('apply') === null) {
                $this->getController()->redirect(['eventIndex']);
            }
        }

        $signals = DeviceSignal::model()
            ->byDeviceNumber(ArrayHelper::getColumn($event->DeviceLinks, 'DeviceId'))
            ->with(['Participant' => ['with' => ['User' => ['with' => ['Employments', 'Settings', 'LinkPhones']]]]])
            ->orderBy(['"t"."Id"' => SORT_DESC])
            ->findAll();

        $this->getController()->render('event/edit', [
            'form' => $form,
            'event' => $event,
            'signals' => $signals
        ]);
    }
}