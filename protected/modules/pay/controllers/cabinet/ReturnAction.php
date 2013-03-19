<?php
namespace pay\controllers\cabinet;

class ReturnAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    $this->getController()->redirect($account->ReturnUrl);
  }
}
