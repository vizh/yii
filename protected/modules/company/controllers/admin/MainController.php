<?php

use application\components\controllers\AdminMainController;
use application\components\traits\LoadModelTrait;
use application\helpers\Flash;
use company\models\Company;
use company\models\forms\admin\Company as CompanyForm;
use company\models\search\admin\Company as CompanySearch;

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
        $company = $this->loadModel('\company\models\Company', $id, false);
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