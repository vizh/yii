<?php

namespace api\controllers\admin\account;

use api\models\Account;
use api\models\Domain;
use api\models\forms\admin\Account as AccountForm;
use api\models\Ip;
use application\components\utility\Texts;
use Yii;

class EditAction extends \CAction
{
    /**
     * @var AccountForm
     */
    private $form;

    /**
     * @var Account
     */
    private $account;

    public function run($accountId = null)
    {
        if ($accountId !== null) {
            $this->account = Account::model()->findByPk($accountId);
        } else {
            $this->account = new Account();
        }

        $this->form = new AccountForm();
        $request = Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $this->form->attributes = $request->getParam(get_class($this->form));
            $this->proccessForm();
        } else {
            if (!$this->account->getIsNewRecord()) {
                $this->form->Id = $this->account->Id;
                $this->form->Key = $this->account->Key;
                $this->form->Secret = $this->account->Secret;
                $this->form->Role = $this->account->Role;
                $this->form->RequestPhoneOnRegistration = $this->account->RequestPhoneOnRegistration;
                $this->form->QuotaByUser = $this->account->QuotaByUser;
                $this->form->QuotaByUserCounter = count($this->account->QuotaUsers);
                $this->form->Blocked = $this->account->Blocked;
                $this->form->BlockedReason = $this->account->BlockedReason;
                if (!empty($this->account->Event)) {
                    $this->form->EventId = $this->account->EventId;
                    $this->form->EventTitle = $this->account->Event->Title;
                }
            }
            foreach ($this->account->Domains as $domain) {
                $this->form->Domains[] = $domain->Domain;
            }
            foreach ($this->account->Ips as $ip) {
                $this->form->Ips[] = $ip->Ip;
            }
        }

        Yii::app()->getClientScript()->registerPackage('runetid.backbone');
        $this->getController()->setPageTitle(Yii::t('app', 'Настройка API аккаунта мероприятия.'));
        $this->getController()->render('edit', ['account' => $this->account, 'form' => $this->form]);
    }

    private function proccessForm()
    {
        if ($this->form->validate()) {
            if ($this->account->getIsNewRecord()) {
                $this->account->EventId = $this->form->EventId;
                $this->account->Key = Texts::GenerateString(10, true);
                $this->account->Secret = Texts::GenerateString(25);
            }
            $this->account->Role = $this->form->Role;
            $this->account->RequestPhoneOnRegistration = $this->form->RequestPhoneOnRegistration;
            $this->account->QuotaByUser = $this->form->QuotaByUser;
            $this->account->BlockedReason = !$this->account->Blocked && $this->form->Blocked
                ? 'Заблокировано вручную пользователем RunetId:'.Yii::app()->user->getCurrentUser()->RunetId.' в '.date('Y-m-d H:i')
                : $this->account->BlockedReason;
            $this->account->Blocked = $this->form->Blocked;
            $this->account->save();

            $ips = [];
            foreach (Ip::model()->byAccountId($this->account->Id)->findAll() as $ip) {
                $ips[] = $ip->Ip;
            }
            foreach (array_diff($ips, $this->form->Ips) as $ip) {
                Ip::model()
                    ->byAccountId($this->account->Id)
                    ->byIp($ip)
                    ->find()
                    ->delete();
            }
            foreach (array_diff($this->form->Ips, $ips) as $ip) {
                $ipModel = new Ip();
                $ipModel->AccountId = $this->account->Id;
                $ipModel->Ip = $ip;
                $ipModel->save();
            }

            $domains = [];
            foreach (Domain::model()->byAccountId($this->account->Id)->findAll() as $domain) {
                $domains[] = $domain->Domain;
            }

            foreach (array_diff($domains, $this->form->Domains) as $domain) {
                Domain::model()->byAccountId($this->account->Id)->byDomain($domain)->find()->delete();
            }

            foreach (array_diff($this->form->Domains, $domains) as $domain) {
                $domainModel = new Domain();
                $domainModel->AccountId = $this->account->Id;
                $domainModel->Domain = $domain;
                $domainModel->save();
            }

            Yii::app()
                ->getUser()
                ->setFlash('success', Yii::t('app', 'API аккаунт успешно сохранен!'));

            $this->getController()->redirect(
                $this->getController()->createUrl('/api/admin/account/edit', ['accountId' => $this->account->Id])
            );
        }
    }
}
