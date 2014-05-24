<?php
namespace partner\controllers\ruvents;

use ruvents\models\AccountRole;

class OperatorAction extends \partner\components\Action
{
    const OperatorSubname = 'op';
    const AdminSubname = 'adm';

    public function run()
    {
        $this->getController()->setPageTitle('Генерация аккаунтов операторов');
        $this->getController()->initActiveBottomMenu('operator');
        $request = \Yii::app()->getRequest();

        $account = \ruvents\models\Account::model()
            ->byEventId($this->getEvent()->Id)->byRole(AccountRole::SERVER)->find();
        if ($account == null)
        {
            $account = new \ruvents\models\Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Hash = \application\components\utility\Texts::GenerateString(25);
            $account->Role = AccountRole::SERVER;
            $account->save();
        }

        $form = new \partner\models\forms\OperatorGenerate();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest() && $form->validate())
        {
            $this->addOperators($form->Prefix . '_' . self::OperatorSubname, $form->CountOperators, \ruvents\models\Operator::RoleOperator);
            $this->addOperators($form->Prefix . '_' . self::AdminSubname, $form->CountAdmins, \ruvents\models\Operator::RoleAdmin);
            $form = new \partner\models\forms\OperatorGenerate();
        }

        $operators = \ruvents\models\Operator::model()->byEventId($this->getEvent()->Id)->findAll(['order' => '"Role" DESC, "Id"']);

        $this->getController()->render('operator', [
            'form' => $form,
            'account' => $account,
            'operators' => $operators
        ]);
    }

    private function addOperators($prefix, $count, $role)
    {
        if ($count <= 0)
        {
            return;
        }
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Login" LIKE :Login';
        $criteria->params = array('Login' => \Utils::PrepareStringForLike($prefix) . '%');
        /** @var $operators \ruvents\models\Operator[] */
        $operators = \ruvents\models\Operator::model()->findAll($criteria);

        $max = 0;
        foreach ($operators as $operator)
        {
            $number = intval(substr($operator->Login, strlen($prefix)));
            $max = $number > $max ? $number : $max;
        }
        $max += 1;
        for ($i = 0; $i < $count; $i++)
        {
            $login = $prefix . ($max+$i);
            $password = $this->generatePassword(5);
            $operator = new \ruvents\models\Operator();
            $operator->EventId = $this->getEvent()->Id;
            $operator->Login = $login;
            $operator->Password = $password;
            $operator->Role = $role;
            $operator->save();
            fputcsv($this->getFile(), array($login, $password));
        }
    }

    private $file = null;
    private function getFile()
    {
        if ($this->file == null)
        {
            $this->file = fopen($this->getDataPath() . 'operators_' . date('Y-m-d H:i:s') . '.csv', 'w');
        }
        return $this->file;
    }

    private $dataPath = null;
    private function getDataPath()
    {
        if (empty($this->dataPath))
        {
            $path = \Yii::getPathOfAlias('partner.data');
            $this->dataPath = $path . '/' . \Yii::app()->partner->getAccount()->EventId . '/operator/';
            if (!file_exists($this->dataPath))
            {
                mkdir($this->dataPath, 0755, true);
            }
        }
        return $this->dataPath;
    }

    private function generatePassword($length)
    {
        $password = '';
        for ($i = 0; $i < $length; $i++)
        {
            $password .= mt_rand(1, 9);
        }
        return $password;
    }
}