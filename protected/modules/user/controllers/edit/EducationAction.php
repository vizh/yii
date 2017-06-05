<?php
namespace user\controllers\edit;

use user\models\forms\edit\Educations;

class EducationAction extends \CAction
{
    public function run()
    {
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));

        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new Educations();
        if ($request->getIsPostRequest()) {
            $form->applyAttributes($request->getParam(get_class($form)));

            if ($form->validate()) {
                foreach ($form->educations as $education) {
                    $education->process();
                }

                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Образование успешно сохранено!'));
                $this->getController()->refresh();
            }
        } else {
            foreach ($user->Educations as $education) {
                $form->addSubform($education);
            }
        }

        $this->getController()->render('education', ['form' => $form]);
    }
}