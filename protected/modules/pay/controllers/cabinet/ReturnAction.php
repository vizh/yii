<?php
namespace pay\controllers\cabinet;

class ReturnAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($account->ReturnUrl !== null)
    {
      $this->getController()->redirect($account->ReturnUrl);
    }
    else
    {
      $this->getController()->redirect(\Yii::app()->createUrl('/event/view/index', array('idName' => $eventIdName)));
    }
  }
}
