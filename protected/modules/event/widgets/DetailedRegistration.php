<?php
namespace event\widgets;

use application\components\auth\identity\RunetId;
use application\components\utility\Texts;
use contact\models\Address;
use event\components\WidgetPosition;
use \event\models\forms\DetailedRegistration as DetailedRegistrationForm;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use user\models\User;

class DetailedRegistration extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return [
            'DefaultRoleId',
            'RegisterUnvisibleUser',
            'ShowEmployment',
            'RegistrationBeforeInfo'
        ];
    }

    /** @var \event\models\forms\DetailedRegistration */
    public $form;

    /** @var  UserData */
    public $userData;

    public function init()
    {
        parent::init();

        $scenario = '';
        if (isset($this->ShowEmployment) && $this->ShowEmployment) {
            $scenario = DetailedRegistrationForm::ScenarioShowEmployment;
        }

        $this->form = new DetailedRegistrationForm(\Yii::app()->getUser()->getCurrentUser(), $scenario);
        $this->userData = new UserData();
        $this->userData->EventId = $this->getEvent()->Id;
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
            $this->userData->getManager()->setAttributes(
                $request->getParam(get_class($this->userData->getManager()))
            );

            $this->form->validate();
            $this->userData->getManager()->validate();

            if (!$this->form->hasErrors() && !$this->userData->getManager()->hasErrors() && isset($this->DefaultRoleId)) {
                $user = $this->updateUser($this->form->getUser());
                $role = Role::model()->findByPk($this->DefaultRoleId);
                $this->getEvent()->registerUser($user, $role);

                $this->userData->UserId = $user->Id;
                $this->userData->save();

                if (\Yii::app()->getUser()->getIsGuest()) {
                    $identity = new RunetId($user->RunetId);
                    $identity->authenticate();
                    if ($identity->errorCode == \CUserIdentity::ERROR_NONE) {
                        \Yii::app()->getUser()->login($identity);
                    }
                }
                $this->getController()->refresh();
            } else {
                $this->form->addErrors($this->userData->getManager()->getErrors());
            }
        }
    }


    public function run()
    {
        /** @var Participant $participant */
        $participant = null;
        if (!\Yii::app()->user->getIsGuest()) {
            $participant = Participant::model()->byEventId($this->event->Id)->byUserId(\Yii::app()->user->getCurrentUser()->Id)->find();
        }

        if ($participant == null) {
            \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
            $userData = new UserData();
            $userData->EventId = $this->getEvent()->Id;
            $this->render('detailed-registration');
        } else {
            $this->render('detailed-registration-complete');
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
        return WidgetPosition::Content;
    }


    /**
     * @param User $user
     * @return User
     */
    private function updateUser($user)
    {
        if ($user === null) {
            $user = new User();
            $user->LastName = $this->form->LastName;
            $user->FirstName = $this->form->FirstName;
            $user->FatherName = $this->form->FatherName;
            $user->PrimaryPhone = $this->form->PrimaryPhone;
            $user->Email = $this->form->Email;

            $user->register();

            if ($this->getEvent()->UnsubscribeNewUser) {
                $user->Settings->UnsubscribeAll = true;
                $user->Settings->save();
            }

            if (isset($this->RegisterUnvisibleUser) && !$this->RegisterUnvisibleUser) {
                $user->Visible = false;
            }
        }
        else {
            if (empty($user->PrimaryPhone)) {
                $user->PrimaryPhone = $this->form->PrimaryPhone;
            }
        }

        $user->FatherName = $this->form->FatherName;
        $user->Birthday = \Yii::app()->dateFormatter->format('yyyy-MM-dd', $this->form->Birthday);
        $user->save();

        if (isset($this->ShowEmployment) && $this->ShowEmployment) {
            $employment = $user->getEmploymentPrimary();
            if ($employment === null || $employment->Position !== $this->form->Position || $employment->Company->Name !== $this->form->Company) {
                $user->setEmployment($this->form->Company, $this->form->Position);
            }
        }

        $address = $user->getContactAddress();
        if ($address == null) {
            $address = new Address();
        }
        $address->RegionId = $this->form->Address->RegionId;
        $address->CountryId = $this->form->Address->CountryId;
        $address->CityId = $this->form->Address->CityId;
        $address->save();
        $user->setContactAddress($address);

        return $user;
    }
}