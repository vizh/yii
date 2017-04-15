<?php
namespace partner\controllers\paperlessdevice;

use partner\components\Action;
use partner\models\forms\paperless\Device;
use application\models\paperless\Device as DeviceModel;

class EditAction extends Action
{
    public function run($id = null)
    {
        if ($id){
            $device = DeviceModel::model()->findByPk($id);
            if (!$device){
                throw new \CHttpException(404);
            }
        }
        else {
            $device = new DeviceModel();
        }

        $form = new Device($this->getEvent(), $device);

        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            if ($device->isNewRecord){
                $model = $form->createActiveRecord();
            }
            else{
                $model = $form->updateActiveRecord();
            }
            if ($model !== null) {
                $this->getController()->redirect(['index']);
            }
        }

        $this->getController()->render('edit', ['form' => $form, 'device' => $device]);
    }
}