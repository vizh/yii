<?php
namespace api\controllers\user;

class GetAction extends \api\components\Action
{
  public function run()
  {
    $runetId = intval(\Yii::app()->getRequest()->getParam('RunetId', null));

    $user = \user\models\User::model()->byRunetId($runetId)->find();
    if ($user !== null)
    {
      $this->getDataBuilder()->createUser($user);
      $this->getDataBuilder()->buildUserEmail($user);
      $this->getDataBuilder()->buildUserEmployment($user);

      $this->setResult($this->getDataBuilder()->buildUserEvent($user));
    }
    else
    {
      throw new \api\components\Exception(202, array($runetId));
    }
  }
}
