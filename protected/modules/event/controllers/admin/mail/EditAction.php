<?php
namespace event\controllers\admin\mail;

use event\models\forms\admin\mail\Register;
use event\models\Event;
use Yii;

class EditAction extends \CAction
{
    /**
     * @param int $id
     * @param string|null $idMail
     * @throws \CHttpException
     */
    public function run($id, $idMail = null)
    {
        $event = Event::model()
            ->findByPk($id);

        if ($event === null) {
            throw new \CHttpException(404);
        }

        $form = new Register($event, $idMail);

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();

            $result = $form->isUpdateMode()
                ? $form->updateActiveRecord()
                : $form->createActiveRecord();

            if ($result !== null) {
                if ($form->Delete == 1) {
                    $this->getController()->redirect(['index', ['eventId' => $event->Id]]);
                } else {
                    $this->getController()->redirect(['edit', 'id' => $id, 'idMail' => $result->Id]);
                }
            }
        }

        $this->getController()->render('edit', [
            'form'  => $form,
            'event' => $event,
            'idMail' => $idMail
        ]);
    }
}
