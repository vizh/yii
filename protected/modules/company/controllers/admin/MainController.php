<?php

use application\components\controllers\AdminMainController;
use company\models\Company;
use application\components\traits\LoadModelTrait;
use company\models\forms\admin\Company as CompanyForm;
use company\models\search\Company as CompanySearch;
use application\helpers\Flash;

class MainController extends AdminMainController
{
    use LoadModelTrait;

    /**
     * Список компаний
     */
    public function actionIndex()
    {
        $search = new CompanySearch();
        $this->render('index', ['search' => $search]);
    }

    /**
     * @param int|null $id
     * Редактирование компании
     */
    public function actionEdit($id = null)
    {
        /** @var Company $company */
        $company = $this->loadModel(Company::class, $id, false);
        $form = new CompanyForm($company);
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