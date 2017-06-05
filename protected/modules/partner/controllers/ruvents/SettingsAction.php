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
            // Необходим несколько нестандартный подход, дабы работало удаление значений атрибутов
            $postData = $request->getPost('partner\models\forms\ruvents\Settings');
            if ($postData === null) {
                $postData = [];
            }
            foreach ($form->attributes as $attribute => $name) {
                if (!array_key_exists($attribute, $postData)) {
                    $postData[$attribute] = null;
                }
            }
            $form->setAttributes($postData);
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Настройки клиента успешно сохранены'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('settings', ['form' => $form]);
    }
}