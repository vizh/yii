<?php
namespace user\controllers\edit;

use contact\models\Address;
use contact\models\forms\Phone as PhoneForm;
use contact\models\forms\ServiceAccount as ServiceAccountForm;
use contact\models\Phone;
use contact\models\ServiceType;
use user\models\forms\edit\Contacts;
use user\models\LinkPhone;
use user\models\LinkServiceAccount;

class ContactsAction extends \CAction
{
    public function run()
    {
        $user = \Yii::app()->user->getCurrentUser();
        $request = \Yii::app()->getRequest();
        $form = new Contacts();
        $form->attributes = $request->getParam(get_class($form));
        if ($request->getIsPostRequest()) {
            if ($form->validate()) {
                $user->PrimaryPhone = $form->PrimaryPhone;
                $user->Email = $form->Email;
                if (!empty($form->Site)) {
                    $site = parse_url($form->Site);
                    $user->setContactSite($site['host'], ($site['scheme'] == 'https'));
                } else {
                    $user->setContactSite(null);
                }

                $user->save();

                // Сохранение адреса
                $address = $user->getContactAddress();
                if (!$form->Address->getIsEmpty() || $address !== null) {
                    if ($address == null) {
                        $address = new Address();
                    }
                    $address->RegionId = $form->Address->RegionId;
                    $address->CountryId = $form->Address->CountryId;
                    $address->CityId = $form->Address->CityId;
                    $address->save();
                    $user->setContactAddress($address);
                }

                // Сохранение номеров телефонов
                foreach ($form->Phones as $formPhone) {
                    if (!empty($formPhone->Id)) {
                        $linkPhone = LinkPhone::model()->byUserId($user->Id)->byPhoneId($formPhone->Id)->find();
                        if ($linkPhone == null) {
                            throw new \CHttpException(500);
                        }
                        $phone = $linkPhone->Phone;
                        if ($formPhone->Delete == 1) {
                            $linkPhone->delete();
                            $phone->delete();
                            continue;
                        }
                    } else {
                        $linkPhone = new LinkPhone();
                        $linkPhone->UserId = $user->Id;
                        $phone = new Phone();
                    }

                    $phone->CountryCode = $formPhone->CountryCode;
                    $phone->CityCode = $formPhone->CityCode;
                    $phone->Phone = $formPhone->Phone;
                    $phone->Type = $formPhone->Type;
                    $phone->save();
                    $linkPhone->PhoneId = $phone->Id;
                    $linkPhone->save();
                }

                // Сохранение аккаунтов в соц. сетях
                foreach ($form->Accounts as $formAccount) {
                    $serviceType = ServiceType::model()->findByPk($formAccount->TypeId);
                    if (!empty($formAccount->Id)) {
                        $linkServiceAccount = LinkServiceAccount::model()
                            ->byServiceAccountId($formAccount->Id)
                            ->byUserId($user->Id)->find();
                        if ($linkServiceAccount == null) {
                            throw new \CHttpException(500);
                        }
                        $serviceAccount = $linkServiceAccount->ServiceAccount;
                        if ($formAccount->Delete == 1) {
                            $serviceAccount->delete();
                            $linkServiceAccount->delete();
                            continue;
                        } else {
                            $serviceAccount->Account = $formAccount->Account;
                            $serviceAccount->TypeId = $serviceType->Id;
                            $serviceAccount->save();
                        }
                    } else {
                        $serviceAccount = $user->setContactServiceAccount($formAccount->Account, $serviceType);
                    }
                }

                \Yii::app()->user->setFlash('success', \Yii::t('app', 'Ваша контактная информация успешно сохранена!'));
                $this->getController()->refresh();
            }
        } else {
            $form->Email = $user->Email;
            $form->PrimaryPhone = $user->PrimaryPhone;
            if ($user->getContactSite() !== null) {
                $form->Site = (string)$user->getContactSite();
            }

            foreach ($user->LinkPhones as $linkPhone) {
                $phone = new PhoneForm(PhoneForm::ScenarioOneFieldRequired);
                $phone->attributes = [
                    'Id' => $linkPhone->PhoneId,
                    'OriginalPhone' => $linkPhone->Phone->getWithoutFormatting(),
                    'Type' => $linkPhone->Phone->Type
                ];
                $form->Phones[] = $phone;
            }

            foreach ($user->LinkServiceAccounts as $linkAccount) {
                if ($linkAccount->ServiceAccount !== null) {
                    $account = new ServiceAccountForm();
                    $account->attributes = [
                        'Id' => $linkAccount->ServiceAccount->Id,
                        'TypeId' => $linkAccount->ServiceAccount->TypeId,
                        'Account' => $linkAccount->ServiceAccount->Account
                    ];
                    $form->Accounts[] = $account;
                }
            }

            if ($user->getContactAddress() !== null) {
                $form->Address->attributes = $user->getContactAddress()->attributes;
            }
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
        $this->getController()->bodyId = 'user-account';
        $this->getController()->setPageTitle(\Yii::t('app', 'Редактирование профиля'));
        $this->getController()->render('contacts', ['form' => $form, 'user' => $user]);
    }
}
