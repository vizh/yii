<?php
namespace api\controllers\ms;

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
        $couponCode = $request->getParam('CouponCode');

        $externalUser = \api\models\ExternalUser::model()
            ->byExternalId($externalId)->byPartner($this->getAccount()->Role)->find();
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

        $coupon = null;
        if ($couponCode != null)
        {
            /** @var $coupon \pay\models\Coupon */
            $coupon = \pay\models\Coupon::model()->byCode($couponCode)->find();
            if ($coupon == null)
                throw new \api\components\Exception(3006);
            elseif ($coupon->EventId != $this->getEvent()->Id)
                throw new \api\components\Exception(3006);

            try
            {
                $coupon->check();
            }
            catch (\pay\components\Exception $e)
            {
                throw new \api\components\Exception(408, [$e->getCode(), $e->getMessage()], $e);
            }
        }

        $user = new \user\models\User();
        $user->FirstName = $firstName;
        $user->LastName = $lastName;
        $user->Email = strtolower($email);
        $user->register(false);

        $user->Visible = false;
        $user->Temporary = true;
        $user->save();

        $user->Settings->UnsubscribeAll = true;
        $user->Settings->save();

        $externalUser = new \api\models\ExternalUser();
        $externalUser->Partner = $this->getAccount()->Role;
        $externalUser->UserId = $user->Id;
        $externalUser->ExternalId = $externalId;
        $externalUser->save();

        if (!empty($company))
        {
            try
            {
                $user->setEmployment($company, !empty($position) ? $position : '');
            }
            catch (\application\components\Exception $e)
            {
            }
        }


        $roleId = $request->getParam('RoleId');
        if ($roleId === null) {
            $roleId = 24;
            if ($this->getEvent()->Id == 831)
                $roleId = 64;
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

        if ($coupon != null)
        {
            $coupon->activate($user, $user);
        }

        $urlParams = ['eventIdName' => $this->getEvent()->IdName];
        if ($this->getAccount()->EventId == 1013)
            $urlParams['lang'] = 'en';

        $url = $user->getFastauthUrl(\Yii::app()->createUrl('/pay/cabinet/register', $urlParams));
        $this->setResult(['PayUrl' => $url]);
    }
}