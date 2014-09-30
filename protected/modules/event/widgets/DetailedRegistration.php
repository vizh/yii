<?php
namespace event\widgets;

use pay\models\EventUserAdditionalAttribute;

class DetailedRegistration extends \event\components\Widget
{
    /** @var \event\models\forms\DetailedRegistration */
    public $form;

    public function init()
    {
        parent::init();

        $user = \Yii::app()->user->getCurrentUser();
        $this->form = new \event\models\forms\DetailedRegistration($user);
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }


    public function process()
    {
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $this->form->attributes = $request->getParam(get_class($this->form));
            //$this->form->photo = \CUploadedFile::getInstance($this->form, 'photo');
            //$this->form->saveTempPhoto();
            if ($this->form->validate()) {
                $user = $this->updateUser($this->form->getUser());
                $role = \event\models\Role::model()->findByPk(1);
                $this->getEvent()->registerUser($user, $role);

                if (\Yii::app()->user->getIsGuest()) {
                    $identity = new \application\components\auth\identity\RunetId($user->RunetId);
                    $identity->authenticate();
                    if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
                        \Yii::app()->user->login($identity);
                    }
                }
                \Yii::app()->user->setFlash('SUCCESS_REGISTER', true);
                $this->getController()->refresh();
            }
        }
//        else
//            $this->form->clearTempPhoto();
    }

    /**
     * @param \user\models\User|null $user
     * @return \user\models\User
     */
    private function updateUser($user)
    {
        if ($user === null) {
            $user = new \user\models\User();
            $user->LastName = $this->form->lastName;
            $user->FirstName = $this->form->firstName;
            //$user->FatherName = $this->form->fatherName;
            $user->PrimaryPhone = $this->form->phone->CountryCode.$this->form->phone->CityCode.$this->form->phone->Phone;
            $user->Email = $this->form->email;
            $user->register();

            if (isset($this->getEvent()->UnsubscribeNewUser) && $this->getEvent()->UnsubscribeNewUser) {
                $user->Settings->UnsubscribeAll = true;
                $user->Settings->save();
            }
        }
        else {
            if (empty($user->PrimaryPhone))
                $user->PrimaryPhone = $this->form->phone->CountryCode.$this->form->phone->CityCode.$this->form->phone->Phone;
        }

        //$user->Birthday = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $this->form->birthday);
        $user->save();

        $employment = $user->getEmploymentPrimary();
        if ($employment === null || $employment->Position !== $this->form->position || $employment->Company->Name !== $this->form->company) {
            $user->setEmployment($this->form->company, $this->form->position);
        }

        //$this->updatePhone($user);
        //$this->updateAddress($user);
        //$this->form->savePhoto($user);

        //$this->fillAdditionalAttributes($user, ['birthday', 'birthPlace', 'passportSerial', 'passportNumber']);

        return $user;
    }

    private function updatePhone(\user\models\User $user)
    {
        $phone = $user->getContactPhone();
        if ($phone === null)
            $phone = new \contact\models\Phone();

        $phone->CountryCode = $this->form->phone->CountryCode;
        $phone->CityCode = $this->form->phone->CityCode;
        $phone->Phone = $this->form->phone->Phone;
        $phone->Type = \contact\models\PhoneType::Mobile;

        if ($phone->getIsNewRecord()) {
            $phone->save();
            $linkPhone = new \user\models\LinkPhone();
            $linkPhone->UserId = $user->Id;
            $linkPhone->PhoneId = $phone->Id;
            $linkPhone->save();
        } else {
            $phone->save();
        }
    }

    private function updateAddress(\user\models\User $user)
    {
        $address = $user->getContactAddress();
        if ($address == null)
            $address = new \contact\models\Address();
        $address->RegionId = $this->form->address->RegionId;
        $address->CountryId = $this->form->address->CountryId;
        $address->CityId = $this->form->address->CityId;
        $address->save();
        $user->setContactAddress($address);
    }

    private function fillAdditionalAttributes(\user\models\User $user, $names)
    {
        foreach ($names as $name) {
            $attribute = new EventUserAdditionalAttribute();
            $attribute->UserId = $user->Id;
            $attribute->EventId = $this->getEvent()->Id;
            $attribute->Name = $name;
            $attribute->Value = $this->form->$name;
            $attribute->save();
        }
    }

    public function run()
    {
        /** @var \event\models\Participant $participant */
        $participant = null;
        if (!\Yii::app()->user->getIsGuest()) {
            $participant = \event\models\Participant::model()->byEventId($this->event->Id)
                ->byUserId(\Yii::app()->user->getCurrentUser()->Id)->find();
        }

        if ($participant == null || $participant->RoleId == 24) {
            $this->render('detailed-registration');
        } else {
            $successRegister = \Yii::app()->user->getFlash('SUCCESS_REGISTER');
            $this->render('detailed-registration-complete', [
                'participant' => $participant,
                'successRegister' => $successRegister
            ]);
        }

    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Детальная регистрация на мероприятии');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return \event\components\WidgetPosition::Content;
    }
}