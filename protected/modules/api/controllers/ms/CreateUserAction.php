<?php
namespace api\controllers\ms;

use application\components\utility\Texts;
use event\models\UserData;
use user\models\User;

class CreateUserAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $externalId = $request->getParam('ExternalId');
        $email = $request->getParam('Email');
        $lastName = $request->getParam('LastName');
        $firstName = $request->getParam('FirstName');
        $company = $request->getParam('Company');
        $position = $request->getParam('Position');
        $phone = $request->getParam('Phone', '');
        $country = $request->getParam('Country');
        $city = $request->getParam('City');
        $couponCode = $request->getParam('CouponCode');

        $externalUser = \api\models\ExternalUser::model()
            ->byExternalId($externalId)->byAccountId($this->getAccount()->Id)->find();
        if ($externalUser !== null)
            throw new \api\components\Exception(3002, [$externalId]);
        if (empty($externalId))
            throw new \api\components\Exception(3004, ['ExternalId']);
        if (empty($email))
            throw new \api\components\Exception(3004, ['Email']);
        if (empty($lastName))
            throw new \api\components\Exception(3004, ['LastName']);
        if (empty($firstName))
            throw new \api\components\Exception(3004, ['FirstName']);



        $user = User::model()->byEmail($email)->byVisible(true)->find();
        $isEqualUser = $user !== null && mb_strtolower($lastName) === mb_strtolower($user->LastName);
        $isEqualUser = $isEqualUser && mb_strtolower($firstName) === mb_strtolower($user->FirstName);
        if (!$isEqualUser) {
            $user = new \user\models\User();
            $user->FirstName = $firstName;
            $user->LastName = $lastName;
            $user->Email = mb_strtolower($email);
            $user->register(false);

            $user->Visible = false;
            $user->Temporary = true;
            $user->save();

            $user->Settings->UnsubscribeAll = true;
            $user->Settings->save();
        }

        $externalUser = new \api\models\ExternalUser();
        $externalUser->AccountId = $this->getAccount()->Id;
        $externalUser->Partner = $this->getAccount()->Role;
        $externalUser->UserId = $user->Id;
        $externalUser->ExternalId = $externalId;
        $externalUser->save();

        if (!empty($company)) {
            try {
                $user->setEmployment($company, !empty($position) ? $position : '');
            } catch (\application\components\Exception $e) {}
        }

        $phone = Texts::getOnlyNumbers($phone);
        if (!empty($phone)) {
            if (!$user->PrimaryPhoneVerify) {
                $user->PrimaryPhone = $phone;
                $user->PrimaryPhoneVerifyTime = null;
                $user->save();
            } elseif ($user->PrimaryPhone !== $phone) {
                $user->setContactPhone($phone);
            }
        }

        $jsonData = [];
        if (!empty($country)) {
            $jsonData['Country'] = $country;
        }
        if (!empty($city)) {
            $jsonData['City'] = $city;
        }
        if (!empty($jsonData)) {
            $userData = new UserData();
            $userData->EventId = $this->getEvent()->Id;
            $userData->CreatorId = $userData->UserId = $user->Id;
            $userData->Attributes = json_encode($jsonData, JSON_UNESCAPED_UNICODE);
            $userData->save();
        }

        $roleId = $request->getParam('RoleId');
        if ($roleId === null) {
            $roleId = 24;
        }
        $role = \event\models\Role::model()->findByPk($roleId);

        if ($role === null) {
            $roleId = 24;
            if ($this->getEvent()->Id == 831)
                $roleId = 64;
            $role = \event\models\Role::model()->findByPk($roleId);
        }

        $this->getEvent()->skipOnRegister = true;
        $this->getEvent()->registerUser($user, $role);

        $coupon = null;
        if ($couponCode != null) {
            $coupon = \pay\models\Coupon::model()->byEventId($this->getEvent()->Id)->byCode($couponCode)->find();

            if ($coupon !== null && $coupon->EventId == $this->getEvent()->Id) {
                try {
                    $coupon->activate($user, $user);
                } catch (\pay\components\Exception $e) {
                    //если при активации промо-кода происходит ошибка, аккаунт все равно создается, ошибку скрываем
                }
            }
        }

        $urlParams = ['eventIdName' => $this->getEvent()->IdName];
        if ($this->getAccount()->EventId == 1013)
            $urlParams['lang'] = 'en';

        $url = $user->getFastauthUrl(\Yii::app()->createUrl('/pay/cabinet/register', $urlParams), true);

        $result = ['PayUrl' => $url];
        if ($coupon != null) {
            $result['Discount'] = $coupon->Discount;
        }
        $this->setResult($result);
    }
}