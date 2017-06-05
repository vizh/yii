<?php
namespace user\controllers\setting;

class PasswordAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\setting\Password();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            if ($form->NewPassword1 !== $form->NewPassword2) {
                $form->addError('NewPassword1', \Yii::t('app', 'Введенные Вами пароли не совпадают!'));
            } else if ($user->checkLogin($form->OldPassword) == false) {
                $form->addError('OldPassword', \Yii::t('app', 'Неверно указан старый пароль!'));
            } else {
                $user->changePassword($form->NewPassword1);
                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Новый пароль успешно сохранен!'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('password', ['form' => $form]);
    }
}
