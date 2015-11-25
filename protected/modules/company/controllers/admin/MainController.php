<?php

use application\components\controllers\AdminMainController;
use company\models\Company;
use application\components\traits\LoadModelTrait;
use company\models\forms\admin\Edit;
use application\helpers\Flash;

class MainController extends AdminMainController
{
    use LoadModelTrait;

    public function actionIndex()
    {

    }

    /**
     * Редактирование компании
     */
    public function actionEdit($id)
    {
        /** @var Company $company */
        $company = $this->loadModel(Company::class, $id);
        $form = new Edit($company);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                Flash::setSuccess('Компания успешно сохранена');
                $this->redirect(['edit', 'id' => $result->Id]);
            }
        }
        $this->render('edit', ['form' => $form]);
    }
}