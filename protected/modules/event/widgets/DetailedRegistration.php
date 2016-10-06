<?php
namespace event\widgets;

use event\components\widget\WidgetRegistration;
use event\components\WidgetPosition;
use event\models\forms\DetailedRegistration as DetailedRegistrationForm;
use event\models\Invite as InviteModel;
use event\models\Participant;
use event\models\Role;
use event\models\UserData;
use user\models\User;

/**
 * Class DetailedRegistration Виджет детальной регистрации пользователя на меропритие
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
 * @property string $WidgetRegistrationPositionRequired Whether the position is required
 * @property string $WidgetRegistrationDetailedHideForAuthorize
 * @property string $WidgetRegistrationDetailedSubmitButtonLabel
 * @property string $WidgetRegistrationDetailedPositionTab
 * @property int $WidgetRegistrationShowDocument
 * @property string $WidgetRegistrationDetailedScript
 * @property string $WidgetRegistrationPrimaryFieldsOrderJson Json array specified order for the primary fields,
 * for example ["FirstName", "LastName", "Email"]
 */
class DetailedRegistration extends WidgetRegistration
{
    /**
     * @inheritdoc
     */
    public function getAttributeNames()
    {
        $names = parent::getAttributeNames();
        return array_merge($names, [
            'DefaultRoleId',
            'WidgetRegistrationSelectRoleIdList',
            'RegisterUnvisibleUser',
            'WidgetRegistrationShowEmployment',
            'WidgetRegistrationShowFatherName',
            'WidgetRegistrationShowPhoto',
            'WidgetRegistrationShowPhone',
            'WidgetRegistrationShowBirthday',
            'WidgetRegistrationShowDocument',
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
            'WidgetRegistrationDetailedScript',
            'WidgetRegistrationPrimaryFieldsOrderJson',
            'WidgetRegistrationPositionRequired'
        ]);
    }

    /**
     * @var DetailedRegistrationForm
     */
    public $form;

    /**
     * @var UserData
     */
    public $userData;

    /**
     * @var InviteModel
     */
    public $invite;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->initForm();
        if (isset($this->WidgetRegistrationUseInvites) && $this->WidgetRegistrationUseInvites) {
            $code = \Yii::app()->getRequest()->getParam('invite');
            $this->invite = InviteModel::model()->byEventId($this->getEvent()->Id)->byCode($code)->find();
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

    /**
     * @return bool
     */
    public function getIsHasDefaultResources()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function registerDefaultResources()
    {
        if (isset($this->WidgetRegistrationDetailedScript)) {
            \Yii::app()->getClientScript()->registerScript($this->getNameId(), $this->WidgetRegistrationDetailedScript);
        }

        parent::registerDefaultResources();
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $request = \Yii::app()->getRequest();
        if ($request->getIsPostRequest()) {
            $this->form->fillFromPost();
            /** @var User $user */
            $user = $this->form->isUpdateMode() ? $this->form->updateActiveRecord() : $this->form->createActiveRecord();
            if (is_null($user)) {
                return;
            }

            if (!is_null($this->invite)) {
                $this->invite->activate($user);
            } elseif (isset($this->DefaultRoleId)) {
                $this->getEvent()->registerUser($user, Role::model()->findByPk($this->DefaultRoleId));
            }

            $this->getController()->refresh();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->event->isRegistrationClosed()) {
            return;
        }

        \Yii::app()->getClientScript()->registerPackage('runetid.jquery.inputmask-multi');

        $user = \Yii::app()->user;

        /** @var Participant $participant */
        $participant = null;
        if (!$user->getIsGuest()) {
            $participant = Participant::model()
                ->byEventId($this->event->Id)
                ->byUserId($user->getCurrentUser()->Id)
                ->find();
        }

        if (is_null($participant)) {
            $this->render('detailed-registration');
        } else {
            $this->render('registration/complete');
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
        if ($this->getUser() && isset($this->WidgetRegistrationDetailedHideForAuthorize) && $this->WidgetRegistrationDetailedHideForAuthorize == 1) {
            return false;
        }

        return true;
    }
}
