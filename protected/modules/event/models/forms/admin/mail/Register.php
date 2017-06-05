<?php
namespace event\models\forms\admin\mail;

use application\components\form\EventItemCreateUpdateForm;
use event\models\Event;
use event\models\MailRegister;
use mail\components\MailBodyFieldsTranslator;
use mail\models\Layout;
use Yii;

/**
 * Class Register
 * @package event\models\forms\admin\mail
 *
 * @method MailRegister|null getActiveRecord()
 */
class Register extends EventItemCreateUpdateForm
{
    public $Subject;
    public $Body;
    public $Roles = [];
    public $RolesExcept = [];
    public $Delete = false;
    public $SendPassbook;
    public $Layout = Layout::OneColumn;
    public $SendTicket;

    /** @var MailRegister[] */
    protected $mails;

    use MailBodyFieldsTranslator;

    /**
     * @param Event $event
     * @param string $idMail ID редактируемого письма
     * @throws \CHttpException
     */
    public function __construct(Event $event, $idMail = null)
    {
        parent::__construct($event, null);

        $this->mails = isset($this->event->MailRegister)
            ? unserialize(base64_decode($this->event->MailRegister))
            : [];

        if ($idMail !== null) {
            foreach ($this->mails as $mail) {
                if ($mail->Id == $idMail) {
                    $this->model = $mail;
                }
            }

            if ($this->model === null) {
                throw new \CHttpException(500);
            }

            $this->loadData();
        }
    }

    /**
     * @inheritdoc
     */
    protected function loadData()
    {
        if ($this->isUpdateMode()) {
            $this->Subject = $this->model->Subject;
            $this->Body = $this->translateCode(
                file_get_contents($this->model->getViewPath())
            );
            $this->Roles = $this->model->Roles;
            $this->RolesExcept = $this->model->RolesExcept;
            $this->Layout = $this->model->Layout;
            $this->SendPassbook = isset($this->model->SendPassbook) ? $this->model->SendPassbook : false;
            $this->SendTicket = isset($this->model->SendTicket) ? $this->model->SendTicket : false;
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            ['Subject,Body', 'required'],
            ['Delete,Layout,Body', 'safe'],
            ['Roles, RolesExcept', '\application\components\validators\ExistValidator', 'className' => 'event\models\Role', 'attributeName' => 'Id'],
            ['SendPassbook,SendTicket', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Subject' => Yii::t('app', 'Тема письма'),
            'Body' => Yii::t('app', 'Тело письма'),
            'Roles' => Yii::t('app', 'Роли'),
            'RolesExcept' => Yii::t('app', 'Исключая роли'),
            'SendPassbook' => Yii::t('app', 'Отправлять Passbook файл'),
            'SendTicket' => Yii::t('app', 'Отправлять билет'),
            'Layout' => Yii::t('app', 'Шаблон')
        ];
    }

    /**
     * @return array
     */
    public function getEventRoleData()
    {
        $data = [];
        foreach ($this->event->getRoles() as $role) {
            $data[] = ['label' => "$role->Title ($role->Id)", 'value' => $role->Id];
        }
        return $data;
    }

    /**
     * @return array
     */
    public function getLayoutData()
    {
        return [
            Layout::None => Yii::t('app', 'Без шаблона'),
            Layout::OneColumn => Yii::t('app', 'Одноколоночный'),
            Layout::TwoColumn => Yii::t('app', 'Двухколоночный')
        ];
    }

    /**
     * @inheritdoc
     */
    public function initBodyFields()
    {
        return [
            'User.FullName' => [Yii::t('app', 'Полное имя пользователя'), '<?=$user->getFullName()?>'],
            'User.ShortName' => [Yii::t('app', 'Краткое имя пользователя. Имя или имя + отчество'), '<?=$user->getShortName()?>'],
            'User.RunetId' => [Yii::t('app', 'RUNET-ID пользователя'), '<?=$user->RunetId?>'],
            'Event.Title' => [Yii::t('app', 'Название меропрития'), '<?=$event->Title?>'],
            'TicketUrl' => [Yii::t('app', 'Ссылка на пригласительный'), '<?=$participant->getTicketUrl()?>'],
            'Role.Title' => [Yii::t('app', 'Роль на меропритие'), '<?=$role->Title?>'],
            'CalendarLinks' => [Yii::t('app', 'Добавление в календарь'), '<?$this->renderPartial(\'event.views.mail.register.parts.calendar\', [\'event\' => $event])?>'],
            'ParticipantMessage:label' => [
                Yii::t('app', 'Сообщение лога'),
                '
                <?php
                    $log = \event\models\ParticipantLog::model()->byParticipant($participant)->find();
                    if (!empty($log) && !empty($log->Message)) {
                        echo \'$_1: \' . $log->Message;
                    }
                ?>
            '
            ]
        ];
    }

    /**
     * @return MailRegister|null
     */
    public function createActiveRecord()
    {
        $this->model = new MailRegister($this->event);
        $this->mails[] = $this->model;
        return $this->updateActiveRecord();
    }

    /**
     * @return MailRegister|null
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        if ($this->Delete) {
            foreach ($this->mails as $k => $mail) {
                if ($mail->Id === $this->model->Id) {
                    unset($this->mails[$k]);
                    break;
                }
            }
        } else {
            $this->model->Subject = $this->Subject;
            $this->model->Layout = $this->Layout;
            $this->model->Roles = $this->Roles;
            $this->model->RolesExcept = $this->RolesExcept;
            $this->model->SendPassbook = $this->SendPassbook;
            $this->model->SendTicket = $this->SendTicket;
            file_put_contents($this->model->getViewPath(), $this->translatePreview($this->Body));
        }
        $this->event->MailRegister = base64_encode(serialize($this->mails));
        return $this->model;
    }

    public function isUpdateMode()
    {
        return !empty($this->model);
    }
}