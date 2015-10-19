<?php
namespace api\controllers\user;

use api\components\Exception;
use application\components\utility\Texts;
use user\models\User;

class CreateAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $email = $request->getParam('Email', null);
        $lastName = $request->getParam('LastName', null);
        $firstName = $request->getParam('FirstName', null);
        $fathertName = $request->getParam('FatherName', null);
        $password = $request->getParam('Password', null); //todo: deprecated
        $phone = $request->getParam('Phone', null);
        $visible = (bool) $request->getParam('Visible', true);

        if (empty($email) || empty($lastName) || empty($firstName)) {
            throw new Exception(204);
        }
        $emailValidator = new \CEmailValidator();
        if (!$emailValidator->validateValue($email)) {
            throw new Exception(205);
        }

        if ($visible && User::model()->byEmail($email)->byVisible(true)->exists()) {
            throw new Exception(206);
        }

        $user = new \user\models\User();
        $user->LastName = $lastName;
        $user->FirstName = $firstName;
        $user->FatherName = $fathertName;
        $user->Email = $email;
        $user->Visible = $visible;
        $phone = Texts::getOnlyNumbers($phone);
        if (!empty($phone)) {
            $user->PrimaryPhone = $phone;
        }

        if ($password !== null) {
            $user->Password = $password;
        }
        $user->register($visible);

        $oauthPermission = new \oauth\models\Permission();
        $oauthPermission->UserId  = $user->Id;
        $oauthPermission->AccountId = $this->getAccount()->Id;
        $oauthPermission->Verified = true;
        $oauthPermission->save();

        //todo: Добавить автоматическое подтверждение соглашения после регистрации
//    $user->Settings->Agreement = 1;
//    $user->Settings->save();

        $this->setEmployment($user);
        $this->setCity($user);

        $this->getAccount()->getDataBuilder()->createUser($user);
        if ($this->getAccount()->Role != 'mobile') {
            $this->getAccount()->getDataBuilder()->buildUserContacts($user);
        }
        $this->getAccount()->getDataBuilder()->buildUserEmployment($user);
        $this->getController()->setResult($this->getAccount()->getDataBuilder()->buildUserEvent($user));
    }

    /**
     * @param \user\models\User $user
     */
    private function setEmployment($user)
    {
        $request = \Yii::app()->getRequest();
        $companyName = $request->getParam('Company', null);
        $position = $request->getParam('Position', '');
        if (!empty($companyName))
        {
            $user->setEmployment($companyName, $position);
        }
    }

    /**
     * @param \user\models\User $user
     */
    private function setCity($user)
    {
        //todo: Добавить данные по городам и реализовать метод
//    $cityId = Registry::GetRequestVar('City', 0);
//    $city = GeoCity::GetById($cityId);
//    if ($city !== null)
//    {
//      $address = new ContactAddress();
//      $address->CityId = $city->CityId;
//      $address->Primary = 1;
//      $address->save();
//      $user->AddAddress($address);
//    }
    }
}
