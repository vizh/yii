<?php

use api\models\Account;
use application\components\controllers\AdminMainController;

class AccountController extends AdminMainController
{
    public function actionIndex()
    {
        $accounts = Account::model()
            ->with(['Event' => ['together' => false]])
            ->orderBy(['t."EventId"' => SORT_DESC])
            ->findAll();

        $this->setPageTitle(Yii::t('app', 'API аккаунты'));
        $this->render('index', [
            'accounts' => $accounts
        ]);
    }

    public function actions()
    {
        return [
            'edit' => 'api\controllers\admin\account\EditAction'
        ];
    }
}
