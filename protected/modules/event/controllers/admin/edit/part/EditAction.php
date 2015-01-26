<?php
namespace event\controllers\admin\edit\part;

use event\models\forms\admin\Part;

class EditAction extends \CAction
{
    public function run($eventId, $partId = null)
    {
        $request = \Yii::app()->getRequest();
        $form = new Part($partId, $eventId);
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $form->save();
            $this->getController()->redirect(\Yii::app()->createUrl('/event/admin/edit/parts', ['eventId' => $eventId]));
        }

        $this->getController()->render('part/edit', ['form' => $form]);
    }
}