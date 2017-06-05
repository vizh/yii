<?php

class ViewController extends \application\components\controllers\PublicMainController
{
    public function actionIndex($companyId)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'LinkEmails.Email',
            'LinkSite.Site',
            'LinkPhones.Phone',
            'LinkAddress.Address.City',
            'EmploymentsAll' => [
                'together' => false,
                'order' => '"User"."LastName" ASC',
                'with' => ['User', 'User.Settings'],
                'condition' => '"User"."Visible"'
            ]
        ];
        $company = company\models\Company::model()->findByPk($companyId, $criteria);
        if ($company == null) {
            throw new CHttpException(404);
        }

        $this->setPageTitle($company->Name.'/ RUNET-ID');

        $employmentsTmp = [];
        foreach ($company->EmploymentsAll as $employment) {
            $userId = $employment->UserId;
            if (!isset($employmentsTmp[$userId])
                || $employmentsTmp[$userId]->StartYear <= $employment->StartYear
                || ($employmentsTmp[$userId]->StartYear == $employment->StartYear
                    && $employmentsTmp[$userId]->StartMonth <= $employment->StartMonth)
            ) {
                $employmentsTmp[$userId] = $employment;
            }
        }

        $employments = [];
        $employmentsEx = [];
        foreach ($employmentsTmp as $employment) {
            if ((empty($employment->EndYear) || $employment->EndYear >= date('Y'))
                && (empty($employment->EndMonth) || $employment->EndMonth >= date('m'))
            ) {
                $employments[$employment->UserId] = $employment;
            } else {
                $employmentsEx[$employment->UserId] = $employment;
            }
        }

        $showEdit = false;
        if (!\Yii::app()->getUser()->getIsGuest()) {
            $showEdit = \company\models\LinkModerator::model()->byUserId(\Yii::app()->getUser()->getId())->byCompanyId($company->Id)->exists();
        }

        $this->bodyId = 'company-account';
        $this->render('index', [
            'company' => $company,
            'employments' => $employments,
            'employmentsEx' => $employmentsEx,
            'showEdit' => $showEdit
        ]);
    }
}