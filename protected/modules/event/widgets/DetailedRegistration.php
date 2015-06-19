<?php
namespace event\widgets;

use application\components\auth\identity\RunetId;
use application\components\utility\Texts;
use contact\models\Address;
use event\components\WidgetPosition;
use \event\models\forms\DetailedRegistration as DetailedRegistrationForm;
use event\models\Invite;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use user\models\User;

/**
 * Виджет детальной регистрации пользователя на меропритие
 * Class DetailedRegistration
 * @package event\widgets
 *
 */
class DetailedRegistration extends \event\components\Widget
{
    public function getAttributeNames()
    {
        return [
            'DefaultRoleId',
            'SelectRoleIdList',
            'RegisterUnvisibleUser',
            'ShowEmployment',
            'ShowFatherName',
            'ShowPhoto',
            'ShowPhone',
            'ShowBirthday',
            'ShowUserDataGroupLabel',
            'RegistrationBeforeInfo',
            'UseInvites',
            'RegistrationCompleteText'
        ];
    }

    /** @var \event\models\forms\DetailedRegistration */
    public $form;

    /** @var  UserData */
    public $userData = null;

    /**
     * @var Invite
     */
    public $invite = null;

    public function init()
    {
        parent::init();
        $this->initForm();
        if (isset($this->UseInvites) && $this->UseInvites) {
            $code = \Yii::app()->getRequest()->getParam('invite');
            $this->invite = Invite::model()->byEventId($this->getEvent()->Id)->byCode($code)->find();
            if ($this->invite == null || !empty($this->invite->UserId)) {
                $this->form->addError('Invite', \Yii::t('app','Для регистрации на мероприятие «{event}» требуется приглашение.', ['{event}' => $this->event->Title]));
            }
        }
    }

    /**
     * Инициализация основной формы
     */
    private function initForm()
    {
        $attributes = [
            'Email',
            'LastName',
            'FirstName'
        ];

        if (isset($this->ShowFatherName) && $this->ShowFatherName == 1) {
            $attributes[] = 'FatherName';
        }

        if (isset($this->ShowPhoto) && $this->ShowPhoto == 1) {
            $attributes[] = 'Photo';
        }

        if (isset($this->ShowPhone) && $this->ShowPhone == 1) {
            $attributes[] = 'PrimaryPhone';
        }

        if (isset($this->ShowBirthday) && $this->ShowBirthday == 1) {
            $attributes[] = 'Birthday';
        }

        if (isset($this->ShowEmployment) && $this->ShowEmployment == 1) {
            $attributes[] = 'Company';
            $attributes[] = 'Position';
        }

        $roles = [];
        if (isset($this->SelectRoleIdList)) {
            $roles = Role::model()->findAllByPk(explode(',', $this->SelectRoleIdList));
        }

        $user = \Yii::app()->getUser();
        $this->form = new DetailedRegistrationForm($this->getEvent(), $user->getCurrentUser(), $attributes, $roles);
        $this->form->registerVisibleUser = !isset($this->RegisterUnvisibleUser) || !$this->RegisterUnvisibleUser;
        $this->form->unsubscribeNewUser = $this->getEvent()->UnsubscribeNewUser;
    }

    public function getIsHasDefaultResources()
    {
        return true;
    }


    public function process()
    {
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $this->form->fillFromPost();
            /** @var User $user */
            $user = $this->form->isUpdateMode() ? $this->form->updateActiveRecord() : $this->form->createActiveRecord();
            if ($user !== null) {
                if ($this->invite !== null) {
                    $this->invite->activate($user);
                }
                elseif (isset($this->DefaultRoleId)) {
                    $this->getEvent()->registerUser($user, Role::model()->findByPk($this->DefaultRoleId));
                }
                $this->getController()->refresh();
            }
        }
    }


    public function run()
    {
        if ( !$this->event->isRegistrationClosed()) {
            $user = \Yii::app()->user;

            /** @var Participant $participant */
            $participant = null;
            if (!$user->getIsGuest()) {
                $participant = Participant::model()->byEventId($this->event->Id)->byUserId($user->getCurrentUser()->Id)->find();
            }

            if ($participant == null) {
                \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');
                $this->render('detailed-registration');
            } else {
                $this->render('detailed-registration-complete');
            }
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
}