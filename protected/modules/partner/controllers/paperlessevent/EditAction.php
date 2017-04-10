<?php
namespace partner\controllers\paperlessevent;

use partner\components\Action;
use partner\models\forms\paperless\Event;
use paperless\models\Event as EventModel;

class EditAction extends Action
{
    public function run($id = null)
    {
        if ($id){
            $event = EventModel::model()->findByPk($id);
            if (!$event){
                throw new \CHttpException(404);
            }
        }
        else {
            $event = new EventModel();
        }

        $form = new Event($this->getEvent(), $event);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($event->isNewRecord){
                $model = $form->createActiveRecord();
            }
            else{
                $model = $form->updateActiveRecord();
            }
            if ($model !== null) {
                $this->getController()->redirect(['index']);
            }
        }

        $this->getController()->render('edit', ['form' => $form, 'event' => $event]);
    }
}