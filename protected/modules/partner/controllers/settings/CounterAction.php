<?php

namespace partner\controllers\settings;

use application\components\helpers\ArrayHelper;
use application\helpers\Flash;
use partner\components\Action;
use Yii;

class CounterAction extends Action
{
    public function run()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $event = $this->getEvent();
            $event->setAttributes(ArrayHelper::getValues($_POST, [
                'CounterHeadHTML',
                'CounterBodyHTML'
            ]));

            if ($event->save()) {
                Flash::setSuccess(Yii::t('app', 'Настройки счетчика успешно сохранены!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('counter');
    }
}