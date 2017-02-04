<?php
namespace pay\controllers\cabinet;

use pay\models\Account;

class OfferAction extends \pay\components\Action
{
    public function run($eventIdName)
    {
        $account = Account::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($account !== null && $account->Offer !== null) {
            $this->getController()->redirect('/docs/offers/'.\Yii::t('app', $account->Offer));
        }

        $this->getController()->redirect('/docs/offers/base.pdf');
    }
}
