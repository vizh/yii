<?php

use application\components\helpers\ArrayHelper;
use raec\models\Commission;
use raec\models\forms\admin\Users as UsersForm;
use raec\models\forms\Edit as CommissionForm;
use raec\models\forms\User as UserForm;
use raec\models\User as CommissionUser;
use user\models\User;

class CommissionController extends \application\components\controllers\AdminMainController
{
    public function actionList()
    {
        $commissions = Commission::model()
            ->with('UsersActive')
            ->orderBy(['t."Title"' => SORT_ASC])
            ->findAll();

        $this->render('list', [
            'commissions' => $commissions
        ]);
    }

    public function actionEdit($id = null)
    {
        $form = new CommissionForm();

        if ($id !== null) {
            $commission = Commission::model()
                ->findByPk($id);

            if ($commission === null) {
                throw new \CHttpException(404);
            }

            $form->Title = $commission->Title;
            $form->Description = $commission->Description;
            $form->Url = $commission->Url;
        } else {
            $commission = new Commission();
        }

        $request = Yii::app()->getRequest();

        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $commission->Title = $form->Title;
            $commission->Description = $form->Description;
            $commission->Url = $form->Url;
            $commission->save();
            Yii::app()->getUser()->setFlash('success', Yii::t('app', 'Информация о комиссии успешно сохранена!'));
            $this->redirect(['edit', 'id' => $commission->Id]);
        }

        $this->render('edit', [
            'commission' => $commission,
            'form' => $form
        ]);
    }

    public function actionUserList($id = null)
    {
        $commission = Commission::model()
            ->with('Users.Role')
            ->orderBy(['"Role"."Priority"' => SORT_DESC, '"Users"."ExitTime"' => SORT_DESC])
            ->findByPk($id);

        if ($commission === null) {
            throw new \CHttpException(404);
        }

        $form = new UsersForm();
        $form->setAttributes(Yii::app()->getRequest()->getParam(get_class($form)));

        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if ($form->validate()) {
                foreach ($form->Users as $user) {
                    if (!empty($user->Id)) {
                        $commissionUser = CommissionUser::model()
                            ->findByPk($user->Id);

                        if ($commissionUser === null) {
                            throw new \CHttpException(500);
                        }
                    } else {
                        $commissionUser = new CommissionUser();
                    }
                    $commissionUser->UserId = User::model()->byRunetId($user->RunetId)->find()->Id;
                    $commissionUser->JoinTime = Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $user->JoinDate);
                    $commissionUser->ExitTime = !empty($user->ExitDate) ? Yii::app()->getDateFormatter()->format('yyyy-MM-dd', $user->ExitDate) : null;
                    $commissionUser->RoleId = $user->RoleId;
                    $commissionUser->CommissionId = $commission->Id;
                    $commissionUser->save();
                }
                Yii::app()->user->setFlash('success', Yii::t('app', 'Информация об участниках секции успешно сохранена!'));
                $this->refresh();
            }
        } else {
            foreach ($commission->Users as $user) {
                $userForm = new UserForm();
                $userForm->Id = $user->Id;
                $userForm->RunetId = $user->User->RunetId;
                $userForm->RoleId = $user->RoleId;
                $userForm->JoinDate = Yii::app()->getDateFormatter()->format(UserForm::DATE_FORMAT, $user->JoinTime);
                $userForm->ExitDate = Yii::app()->getDateFormatter()->format(UserForm::DATE_FORMAT, $user->ExitTime);
                $form->Users[] = $userForm;
            }
        }

        $this->render('userList', [
            'commission' => $commission,
            'form' => $form
        ]);
    }

    public function actionExport($commissionId = null)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            ini_set('memory_limit', '512M');

            $csvCharset = Yii::app()->getRequest()->getParam('charset', 'utf8');

            header('Content-type: text/csv; charset='.$csvCharset);
            header('Content-Disposition: attachment; filename=commission.csv');

            $fp = fopen('php://output', '');

            $csvRowHandler = function ($row) use ($csvCharset) {
                return ArrayHelper::each($row, function ($item) use ($csvCharset) {
                    if ($csvCharset !== 'utf8') {
                        $item = iconv('utf-8', $csvCharset, $item);
                    }

                    return str_replace(';', '', $item);
                });
            };

            $users = CommissionUser::model()
                ->with(['User.LinkPhones.Phone', 'User.Employments.Company', 'Role', 'Commission'])
                ->orderBy(['"Role"."Priority"' => SORT_DESC]);

            if ($commissionId !== null) {
                $users->byCommissionId($commissionId);
            }

            $criteria = new \CDbCriteria();
            $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');

            $users = $users->findAll($criteria);

            fputcsv($fp, $csvRowHandler(['RUNET-ID', 'Фамилия', 'Имя', 'Отчество', 'Email', 'Статус', 'Комиссия']), ';');

            foreach ($users as $user) {
                $row = [
                    'RUNET-ID' => $user->User->RunetId,
                    'LastName' => $user->User->LastName,
                    'FirstName' => $user->User->FirstName,
                    'FatherName' => $user->User->FatherName,
                    'Email' => $user->User->Email,
                    'Role' => $user->Role->Title,
                    'Commission' => $user->Commission->Title
                ];
                if (false === empty($user->User->LinkPhones)) {
                    $row['Phone'] = (string) $user->User->LinkPhones[0]->Phone;
                }
                if ($user->User->getEmploymentPrimary() !== null) {
                    $row['Company'] = $user->User->getEmploymentPrimary()->Company->Name;
                    $row['Position'] = $user->User->getEmploymentPrimary()->Position;
                }
                fputcsv($fp, $csvRowHandler($row), ';');
            }
            Yii::app()->end();
        }

        $commissions = Commission::model()
            ->orderBy(['t."Title"' => SORT_ASC])
            ->findAll();

        $this->render('export', [
            'commissions' => $commissions
        ]);
    }
}