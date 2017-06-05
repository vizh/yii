<?php

class ExportController extends \application\components\controllers\AdminMainController
{
    private $csvDelimiter = ';';
    private $csvCharset = 'utf8';

    public function actionIndex()
    {
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $this->export();
        }
        $commissions = \commission\models\Commission::model()->findAll(['order' => '"t"."Title" ASC']);
        $this->setPageTitle(\Yii::t('app', 'Экспорт коммиссий в CSV'));
        $this->render('index', ['commissions' => $commissions]);
    }

    private function export()
    {
        ini_set("memory_limit", "512M");
        $request = \Yii::app()->getRequest();
        $this->csvCharset = $request->getParam('charset', $this->csvCharset);

        header('Content-type: text/csv; charset='.$this->csvCharset);
        header('Content-Disposition: attachment; filename=commission.csv');

        $fp = fopen('php://output', '');

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'User.LinkPhones.Phone',
            'User.Employments.Company',
            'Role',
            'Commission'
        ];
        $criteria->order = '"Role"."Priority" DESC';
        $criteria->addCondition('"t"."ExitTime" IS NULL OR "t"."ExitTime" > NOW()');

        if (($commissionId = $request->getParam('commissionId')) !== '') {
            $criteria->condition = '"t"."CommissionId" = :CommissionId';
            $criteria->params['CommissionId'] = $commissionId;
        }

        $users = \commission\models\User::model()->findAll($criteria);

        $row = ['RUNET-ID', 'Фамилия', 'Имя', 'Отчество', 'Компания', 'Должность', 'Email', 'Телефон', 'Статус', 'Комиссия'];
        fputcsv($fp, $this->csvRowHandler($row), $this->csvDelimiter);

        foreach ($users as $user) {
            $row = [
                'RUNET-ID' => $user->User->RunetId,
                'LastName' => $user->User->LastName,
                'FirstName' => $user->User->FirstName,
                'FatherName' => $user->User->FatherName,
                'Company' => '',
                'Position' => '',
                'Email' => $user->User->Email,
                'Phone' => '',
                'Role' => $user->Role->Title,
                'Commission' => $user->Commission->Title
            ];
            if (!empty($user->User->LinkPhones)) {
                $row['Phone'] = (string)$user->User->LinkPhones[0]->Phone;
            }
            if ($user->User->getEmploymentPrimary() !== null) {
                $row['Company'] = $user->User->getEmploymentPrimary()->Company->Name;
                $row['Position'] = $user->User->getEmploymentPrimary()->Position;
            }
            fputcsv($fp, $this->csvRowHandler($row), $this->csvDelimiter);
        }
        \Yii::app()->end();
    }

    private function csvRowHandler($row)
    {
        foreach ($row as &$item) {
            if ($this->csvCharset == 'Windows-1251') {
                $item = iconv('utf-8', 'Windows-1251', $item);
            }
            $item = str_replace($this->csvDelimiter, '', $item);
        }
        return $row;
    }
}
