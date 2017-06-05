<?php

class ShareController extends \application\components\controllers\PublicMainController
{
    public function actionIcal($idName)
    {
        header('Content-type: text/html; charset=utf-8');
        $event = \event\models\Event::model()->byIdName($idName)->find();
        if ($event == null) {
            throw new CHttpException(404);
        }

        echo $this->renderPartial('ical', ['event' => $event]);
        \Yii::app()->disableOutputLoggers();
    }
}
