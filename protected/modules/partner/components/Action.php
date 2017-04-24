<?php

namespace partner\components;

use application\components\utility\Texts;
use ruvents\models\Account;

/**
 * @method Controller getController()
 */
class Action extends \CAction
{
    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->getController()->getEvent();
    }

    /**
     * Возвращает Account для Ruvents. Если аккаунта нет, то создает его.
     *
     * @return Account
     */
    public function getRuventsAccount()
    {
        $account = Account::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($account === null) {
            $account = new Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Hash = Texts::GenerateString(25);
            $account->save();
        }

        return $account;
    }
}
