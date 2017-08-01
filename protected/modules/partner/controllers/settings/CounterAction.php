<?php
namespace partner\controllers\settings;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\settings\Counter;

class CounterAction extends Action
{
    public function run()
    {
        $event = $this->getEvent();
        $form = new Counter($event);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->updateActiveRecord()) {
                Flash::setSuccess(\Yii::t('app', 'Настройки счетчика успешно сохранены!'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('counter', [
            'event' => $event,
            'form' => $form
        ]);
    }
}