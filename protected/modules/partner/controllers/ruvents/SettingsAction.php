<?php
namespace partner\controllers\ruvents;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\ruvents\Settings;
use ruvents\models\Setting;

class SettingsAction extends Action
{
    public function run()
    {
        $settings = Setting::model()->byEventId($this->getEvent()->Id)->find();

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $form = new Settings($this->getEvent(), $settings);
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Настройки клиента успешно сохранены'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('settings', ['form' => $form]);
    }
} 