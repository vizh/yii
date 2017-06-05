<?php
namespace user\controllers\setting;

class IndexingAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new \user\models\forms\setting\Indexing();
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));
            if ($form->validate()) {
                $user->Settings->IndexProfile = $form->Deny == 1 ? false : true;
                $user->Settings->save();
                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Настройки индексация в поисковых системах успешно сохранены!'));
                $this->getController()->refresh();
            }
        } else {
            if (!$user->Settings->IndexProfile) {
                $form->Deny = 1;
            }
        }
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('indexing', ['form' => $form]);
    }
}
