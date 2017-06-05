<?php

class AccountController extends \application\components\controllers\AdminMainController
{
    public function actionIndex()
    {
        $this->setPageTitle(\Yii::t('app', 'Партнерские аккаунты'));

        $criteria = new CDbCriteria();
        $criteria->addCondition('"t"."EventId" IS NOT NULL');
        $criteria->with = ['Event' => ['together' => true]];

        $searchQuery = \Yii::app()->request->getParam('Query', null);
        if (!empty($searchQuery)) {
            if (is_numeric($searchQuery)) {
                $criteria->addCondition('"t"."EventId" = :Query');
                $criteria->params['Query'] = $searchQuery;
            } else {
                $criteria->addCondition('"Event"."IdName" ILIKE :Query OR "Event"."Title" ILIKE :Query');
                $criteria->params['Query'] = '%'.$searchQuery.'%';
            }
        }

        $count = \partner\models\Account::model()->count($criteria);

        $criteria->order = '"t"."CreationTime" DESC, "t"."EventId" DESC';

        $paginator = new \application\components\utility\Paginator($count);
        $paginator->perPage = \Yii::app()->params['AdminEventPerPage'];
        $criteria->mergeWith($paginator->getCriteria());

        $accounts = \partner\models\Account::model()->findAll($criteria);

        $this->render('index', ['accounts' => $accounts, 'paginator' => $paginator]);
    }

    public function actionEdit($id = null)
    {
        if ($id != null) {
            $this->setPageTitle(\Yii::t('app', 'Редактирование партнерского аккаунта'));
            $account = \partner\models\Account::model()->findByPk($id);
        } else {
            $this->setPageTitle(\Yii::t('app', 'Создание партнерского аккаунта'));
            $account = new \partner\models\Account();
        }

        $form = new \partner\models\forms\admin\Account();
        $request = Yii::app()->getRequest();
        $password = Yii::app()->getUser()->hasFlash('password') ? Yii::app()->getUser()->getFlash('password') : null;
        if ($request->getIsPostRequest()) {
            $form->attributes = $request->getParam(get_class($form));

            $generatePassword = $request->getParam('generatePassword');
            if ($generatePassword !== null) {
                $password = \application\components\utility\Texts::GenerateString(10);
                $account->Password = md5($password);
                $account->PasswordStrong = null;
                $account->save();
            } elseif ($form->validate()) {
                $account->Login = $form->Login;
                $account->Role = $form->Role;

                if ($account->getIsNewRecord()) {
                    $password = \application\components\utility\Texts::GenerateString(10);
                    $account->Password = md5($password);
                    $account->EventId = $form->EventId;
                    $account->save();
                    Yii::app()->getUser()->setFlash('password', $password);
                    $this->redirect(Yii::app()->createUrl('/partner/admin/account/edit', ['id' => $account->Id]));
                } else {
                    $account->save();
                }
            }
        }
        $form->attributes = $account->attributes;
        if (!$account->getIsNewRecord()) {
            $form->EventTitle = $account->Event->Id.', '.$account->Event->IdName.', '.$account->Event->Title;
        }

        $this->render('edit', ['form' => $form, 'account' => $account, 'password' => $password]);
    }
}