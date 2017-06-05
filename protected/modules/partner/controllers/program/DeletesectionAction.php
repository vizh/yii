<?php
namespace partner\controllers\program;

use event\models\section\Section;
use partner\components\Action;

class DeleteSectionAction extends Action
{
    public function run($id)
    {
        $section = Section::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($section === null) {
            throw new \CHttpException(404);
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            foreach ($section->LinkHalls as $link) {
                $link->delete();
            }
            $section->delete();
            $transaction->commit();
        } catch (\CDbException $e) {
            $transaction->rollBack();
        }
        $this->getController()->redirect(['index']);
    }
}
