<?php
namespace partner\controllers\ruvents;

use partner\models\forms\OperatorGenerate;
use ruvents\models\Operator;

class OperatorAction extends \partner\components\Action
{
    const OperatorSubname = 'op';
    const AdminSubname = 'adm';

    public function run()
    {
        $request = \Yii::app()->getRequest();

        $form = new OperatorGenerate();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate()) {
            $this->addOperators($form->Prefix.'_'.self::OperatorSubname, $form->CountOperators, \ruvents\models\Operator::RoleOperator);
            $this->addOperators($form->Prefix.'_'.self::AdminSubname, $form->CountAdmins, \ruvents\models\Operator::RoleAdmin);
            $form = new OperatorGenerate();
        }

        $operators = Operator::model()->byEventId($this->getEvent()->Id)->findAll(['order' => '"Role" DESC, "Id"']);

        $this->getController()->render('operator', [
            'form' => $form,
            'account' => $this->getRuventsAccount(),
            'operators' => $operators
        ]);
    }

    private function addOperators($prefix, $count, $role)
    {
        if ($count <= 0) {
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Login" LIKE :Login';
        $criteria->params = ['Login' => \Utils::PrepareStringForLike($prefix).'%'];
        /** @var $operators \ruvents\models\Operator[] */
        $operators = Operator::model()->findAll($criteria);

        $max = 0;
        foreach ($operators as $operator) {
            $number = intval(substr($operator->Login, strlen($prefix)));
            $max = $number > $max ? $number : $max;
        }
        $max += 1;
        for ($i = 0; $i < $count; $i++) {
            $login = $prefix.($max + $i);
            $password = $this->generatePassword(5);
            $operator = new Operator();
            $operator->EventId = $this->getEvent()->Id;
            $operator->Login = $login;
            $operator->Password = $password;
            $operator->Role = $role;
            $operator->save();
            fputcsv($this->getFile(), [$login, $password]);
        }
    }

    private $file;

    private function getFile()
    {
        if ($this->file == null) {
            $this->file = fopen($this->getDataPath().'operators_'.date('Y-m-d_H-i-s').'.csv', 'w');
        }
        return $this->file;
    }

    private $dataPath;

    private function getDataPath()
    {
        if (empty($this->dataPath)) {
            $path = \Yii::getPathOfAlias('partner.data');
            $this->dataPath = $path.DIRECTORY_SEPARATOR.\Yii::app()->partner->getAccount()->EventId.DIRECTORY_SEPARATOR.'operator'.DIRECTORY_SEPARATOR;
            if (!file_exists($this->dataPath)) {
                mkdir($this->dataPath, 0755, true);
            }
        }
        return $this->dataPath;
    }

    private function generatePassword($length)
    {
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= mt_rand(1, 9);
        }
        return $password;
    }
}