<?php
namespace user\controllers\edit;

class PhotoAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\edit\Photo();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            $form->Image = \CUploadedFile::getInstance($form, 'Image');
            if ($form->validate()) {
                $user->getPhoto()->SavePhoto($form->Image);
                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Фотография профиля успешно сохранена!'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('photo', ['form' => $form, 'user' => $user]);
    }
}
