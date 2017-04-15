<?php

namespace partner\controllers\paperless\event;

use application\components\Exception;
use application\models\paperless\Event as EventModel;
use partner\components\Action;
use partner\models\forms\paperless\Event;
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

        $form = new Event($this->getEvent(), $event);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $model = $event->isNewRecord
                ? $form->createActiveRecord()
                : $form->updateActiveRecord();

            if ($model !== null && Yii::app()->getRequest()->getParam('apply') === null) {
                $this->getController()->redirect(['eventIndex']);
            }
        }

        $this->getController()->render('event/edit', [
            'form' => $form,
            'event' => $event
        ]);
    }
}