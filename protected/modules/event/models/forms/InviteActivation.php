<?php
namespace event\models\forms;

class InviteActivation extends \CFormModel
{
    public $RunetId;
    public $FullName;
    public $Code;

    private $event;

    public function __construct(\event\models\Event $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->event = $event;
    }

    public function attributeLabels()
    {
        return [
            'RunetId' => \Yii::t('app', 'RUNET-ID владельца приглашения'),
            'FullName' => \YIi::t('app', 'Владелец приглашения'),
            'Code' => \Yii::t('app', 'Код приглашения')
        ];
    }

    public function rules()
    {
        return [
            ['FullName, Code', 'required'],
            ['RunetId', 'filter', 'filter' => [$this, 'filterUser']],
            ['Code', 'exist', 'className' => '\event\models\Invite', 'attributeName' => 'Code', 'criteria' => ['condition' => '"t"."UserId" IS NULL AND "t"."EventId" = :EventId', 'params' => ['EventId' => $this->event->Id]], 'message' => \Yii::t('app', 'Неверный код приглашения, либо приглашение было уже активировано.')]
        ];
    }

    public function filterUser($value)
    {
        $user = \user\models\User::model()->byVisible(true)->byRunetId($value)->find();
        if ($user == null) {
            $this->addError('FullName', \Yii::t('app', 'Не найден владелец приглашения.'));
        }
        return $value;
    }
}
