<?php
namespace event\models\forms;

class InviteRequest extends \CFormModel
{
    public $RunetId;
    public $FullName;

    public function attributeLabels()
    {
        return [
            'RunetId' => \Yii::t('app', 'RUNET-ID получателя приглашения'),
            'FullName' => \YIi::t('app', 'Получатель приглашения')
        ];
    }

    public function rules()
    {
        return [
            ['FullName', 'required'],
            ['RunetId', 'filter', 'filter' => [$this, 'filterUser']],
        ];
    }

    public function filterUser($value)
    {
        $user = \user\models\User::model()->byVisible(true)->byRunetId($value)->find();
        if ($user == null) {
            $this->addError('FullName', \Yii::t('app', 'Не найден получатель приглашения.'));
        }
        return $value;
    }
}
