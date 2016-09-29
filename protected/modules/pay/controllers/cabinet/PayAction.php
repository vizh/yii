<?php
namespace pay\controllers\cabinet;

use pay\components\Action;
use pay\components\systems\Base;
use pay\components\systems\CloudPayments;
use pay\components\systems\PayOnline;
use pay\components\systems\PayPal;
use pay\components\systems\Uniteller;
use pay\components\systems\WalletOne;
use pay\models\Account;
use pay\models\Order;
use pay\models\OrderType;

class PayAction extends Action
{
    public function run($eventIdName, $type = null)
    {
        $order = new Order();
        $total = $order->create($this->getUser(), $this->getEvent(), OrderType::PaySystem);
        $account = Account::model()->byEventId($this->getEvent()->Id)->find();
        $system = $this->getSystem($type, $account);
        $system->processPayment($this->getEvent()->Id, $order->Id, $total);
    }

    /**
     * @param string $type
     * @param Account $account
     * @return Base
     */
    public function getSystem($type, Account $account)
    {
        if ($type == 'paypal') {
            $system = new PayPal();
        } elseif ($type == 'uniteller' && $account->Uniteller) {
            $system = $this->getSystemUniteller($account);
        } elseif ($type == 'yandexmoney' && $account->PayOnline) {
            /**
             * todo: заменить на $system = $this->getSystemPayonline($account); когда будут подключены Я.Деньги
             */
            $system = new PayOnline(); //
            $system->toYandexMoney = true;
        } elseif ($type == 'cloudpayments') {
            $system = new CloudPayments();
        } elseif ($type == 'walletone') {
            $system = new WalletOne();
        } else {
            if ($account->PayOnline) {
                $system = $this->getSystemPayonline($account);
            }
            else {
                $system = new Uniteller();
            }
        }
        return $system;
    }

    /**
     * @param Account $account
     * @return Uniteller
     */
    private function getSystemUniteller(Account $account)
    {
        if ($account->UnitellerRuvents) {
            return new Uniteller('ruvents');
        } elseif ($account->Own) {
            return new Uniteller(null, '00000524');
        }
        return new Uniteller();
    }

    /**
     * @param Account $account
     * @return PayOnline
     */
    private function getSystemPayonline(Account $account)
    {
        if ($account->PayOnlineRuvents) {
            return new PayOnline('ruvents');
        } else {
            return new PayOnline();
        }
    }
}
