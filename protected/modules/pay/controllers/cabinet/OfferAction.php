<?php
namespace pay\controllers\cabinet;

class OfferAction extends \pay\components\Action
{
  public function run($eventIdName)
  {
    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->getEvent()->Id)->find();
    if ($account->Offer !== null)
    {
      $this->getController()->redirect('/docs/offers/' . \Yii::t('app',$account->Offer));
    }
    else
    {
      $this->getController()->redirect('/docs/offers/base.pdf');
    }
  }
}
