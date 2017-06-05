<?php
namespace user\controllers\edit;

class IndexAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\edit\Main();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $user->FirstName = $form->FirstName;
                $user->LastName = $form->LastName;
                $user->FatherName = $form->FatherName;
                $user->Gender = $form->Gender;
                $user->Birthday = !empty($form->Birthday) ? \Yii::app()->dateFormatter->format('yyyy-MM-dd', $form->Birthday) : null;

                $user->save();

                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Основная информация профиля успешно сохранена!'));
                $this->getController()->refresh();
            }
        } else {
            $form->FirstName = $user->FirstName;
            $form->LastName = $user->LastName;
            $form->FatherName = $user->FatherName;
            $form->Gender = $user->Gender;
            $form->Birthday = \Yii::app()->dateFormatter->format('dd.MM.yyyy', $user->Birthday);
        }

        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('index', ['form' => $form]);
    }
}
