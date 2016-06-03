<?php
namespace partner\controllers\user\export;

use partner\components\Action;
use partner\models\Export;
use partner\models\forms\user\Export as ExportForm;

class IndexAction extends Action
{
    public function run()
    {
        $event = $this->getEvent();
        $user  = \Yii::app()->getUser()->getCurrentUser();

        $form = new ExportForm($event, $user);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->createActiveRecord() !== null) {
                $this->getController()->refresh();
            }
        }

        $exports = Export::model()
            ->byEventId($this->getEvent()->Id)
            ->orderBy(['"t"."CreationTime"' => SORT_DESC])
            ->findAll();

        $this->getController()->render('export', [
            'form' => $form,
            'event' => $event,
            'exports' => $exports
        ]);
    }
}
