<?php
namespace partner\controllers\ruvents;

class OperatorAction extends \partner\components\Action
{
  const OperatorSubname = 'op';
  const AdminSubname = 'adm';

  public function run()
  {
    $this->getController()->setPageTitle('Генерация аккаунтов операторов');
    $this->getController()->initActiveBottomMenu('operator');

    $form = new \partner\components\form\OperatorGenerateForm();
    $request = \Yii::app()->request;
    $form->attributes = $request->getParam(get_class($form));
    if ($request->getIsPostRequest() && $form->validate())
    {
      $this->addOperators($form->Prefix . '_' . self::OperatorSubname, $form->CountOperators, \ruvents\models\Operator::RoleOperator);
      $this->addOperators($form->Prefix . '_' . self::AdminSubname, $form->CountAdmins, \ruvents\models\Operator::RoleAdmin);
      $form = new \partner\components\form\OperatorGenerateForm();
    }

    $files = $this->getFileList();

    $this->getController()->render('operator', array('form' => $form, 'files' => $files));
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
      $password = $this->generatePassword(10);
      $operator = new \ruvents\models\Operator();
      $operator->EventId = $this->getEvent()->Id;
      $operator->Login = $login;
      $operator->Password = \ruvents\models\Operator::generatePasswordHash($password);
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
      $password .= mt_rand(0, 9);
    }
    return $password;
  }

  private function getFileList()
  {
    $results = array();

        // create a handler for the directory
    $handler = opendir($this->getDataPath());

    // open directory and walk through the filenames
    while ($file = readdir($handler)) {

      // if file isn't this directory or its parent, add it to the results
      if ($file != "." && $file != "..") {
        $results[] = $file;
      }

    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;
  }
}
