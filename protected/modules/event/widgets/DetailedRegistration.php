<?php
namespace event\widgets;

use application\components\auth\identity\RunetId;
use application\components\utility\Texts;
use contact\models\Address;
use event\components\Widget;
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
 * @property int $DefaultRoleId
 * @property string $SelectRoleIdList
 * @property int $RegisterUnvisibleUser
 * @property int $WidgetRegistrationShowEmployment
 * @property int $WidgetRegistrationShowFatherName
 * @property int $WidgetRegistrationShowPhoto
 * @property int $WidgetRegistrationShowPhone
 * @property int $WidgetRegistrationShowBirthday
 * @property int $WidgetRegistrationShowContactAddress
 * @property int $WidgetRegistrationShowUserDataGroupLabel
 * @property string $RegistrationBeforeInfo
 * @property int $UseInvites
 * @property string $WidgetRegistrationCompleteText
 * @property string $WidgetRegistrationTitle
 * @property string $WidgetRegistrationCompanyTitle
 * @property string $WidgetRegistrationPositionTitle
 * @property string $WidgetRegistrationDetailedHideForAuthorize
 * @property string $WidgetRegistrationDetailedSubmitButtonLabel
 * @property string $WidgetRegistrationDetailedPositionTab
 */
class DetailedRegistration extends Widget
{
    public function getAttributeNames()
    {
        return [
            'DefaultRoleId',
            'WidgetRegistrationSelectRoleIdList',
            'RegisterUnvisibleUser',
            'WidgetRegistrationShowEmployment',
            'WidgetRegistrationShowFatherName',
            'WidgetRegistrationShowPhoto',
            'WidgetRegistrationShowPhone',
            'WidgetRegistrationShowBirthday',
            'WidgetRegistrationShowContactAddress',
            'WidgetRegistrationShowUserDataGroupLabel',
            'WidgetRegistrationShowHiddenUserDataFields',
            'WidgetRegistrationBeforeInfo',
            'WidgetRegistrationUseInvites',
            'WidgetRegistrationCompleteText',
            'WidgetRegistrationTitle',
            'WidgetRegistrationCompanyTitle',
            'WidgetRegistrationPositionTitle',
            'WidgetRegistrationDetailedHideForAuthorize',
            'WidgetRegistrationDetailedSubmitButtonLabel',
            'WidgetRegistrationDetailedPositionTab'
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
        if (isset($this->WidgetRegistrationUseInvites) && $this->WidgetRegistrationUseInvites) {
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
        $user = \Yii::app()->getUser();
        $this->form = new DetailedRegistrationForm($this, $user->getCurrentUser());
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
                $this->render('registration/complete');
            }
        }

    }

    /**
     * @return string
     */
    public function getTitleAdmin()
    {
        return \Yii::t('app', 'Детальная регистрация на мероприятии');
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return \Yii::t('app', 'Регистрация');
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        if (isset($this->WidgetRegistrationDetailedPositionTab) && $this->WidgetRegistrationDetailedPositionTab == 1) {
            return WidgetPosition::Tabs;
        }
        return WidgetPosition::Content;
    }

    /**
     * @return bool
     */
    public function getIsActive()
    {
        if ($this->getUser() !== null && isset($this->WidgetRegistrationDetailedHideForAuthorize) && $this->WidgetRegistrationDetailedHideForAuthorize == 1) {
            return false;
        }
        return true;
    }
}