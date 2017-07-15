<?php

use api\models\Account;
use application\components\controllers\AdminMainController;

class AccountController extends AdminMainController
{
    public function actionIndex()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Event' => ['together' => false]];
        $criteria->order = '"t"."EventId" DESC';
        $accounts = Account::model()->findAll($criteria);
        $this->setPageTitle(\Yii::t('app', 'API аккаунты'));
        $this->render('index', ['accounts' => $accounts]);
    }

    public function actions()
    {
        return [
            'edit' => 'api\controllers\admin\account\EditAction'
        ];
    }
}
