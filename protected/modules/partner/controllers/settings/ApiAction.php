<?php
namespace partner\controllers\settings;

use api\models\Account;
use application\components\utility\Texts;
use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\settings\ApiAccount as AccountForm;

class ApiAction extends Action
{
    public function run()
    {
        $account = $this->getApiAccount();
        $form = new AccountForm($account);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->updateActiveRecord()) {
                Flash::setSuccess(\Yii::t('app', 'Настройки API успешно сохранены!'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('api', [
            'account' => $account,
            'form' => $form
        ]);
    }

    /**
     * @return Account
     */
    private function getApiAccount()
    {
        $account = Account::model()
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($account === null) {
            $account = new Account();
            $account->EventId = $this->getEvent()->Id;
            $account->Key = Texts::GenerateString(10, true);
            $account->Secret = Texts::GenerateString(25);
            $account->Role = Account::ROLE_PARTNER;
            $account->save();
        }

        return $account;
    }
}