<?php
namespace partner\models\forms\user;

use event\models\Event;
use event\models\Role;
use user\models\forms\Register as BaseRegisterForm;

class Register extends BaseRegisterForm
{
    /** @var Event */
    private $event;

    public $Role;
    public $Hidden;

    public function __construct(Event $event)
    {
        parent::__construct(null);
        $this->event = $event;
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['Role', 'required'];
        $rules[] = ['Role', 'in', 'range' => array_keys($this->getRoleData())];
        $rules[] = ['Hidden', 'boolean'];
        foreach ($rules as $i => $rule) {
            if ($rule[0] == 'Email' && $rule[1] == 'required') {
                unset($rules[$i]);
            }
        }

        return $rules;
    }

    /**
     * @return array
     */
    public function getRoleData()
    {
        return \CHtml::listData($this->event->getRoles(), 'Id', 'Title');
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['EmailRandom'] = 'Сгенерировать случайный e-mail';
        $labels['Hidden'] = 'Добавить, как скрытого пользователя';
        $labels['Role'] = 'Роль';
        return $labels;
    }

    /**
     * @inheritdoc
     */
    protected function isHiddenUser()
    {
        return $this->Hidden == 1;
    }

    /**
     *
     */
    protected function internalCreateActiveRecord()
    {
        if (empty($this->Email)) {
            $this->Email = \CText::generateFakeEmail($this->event->Id);
        }
        parent::internalCreateActiveRecord();
        $role = Role::model()->findByPk($this->Role);
        $this->event->skipOnRegister = $this->isHiddenUser();
        if (!empty($this->event->Parts)) {
            $this->event->registerUserOnAllParts($this->model, $role);
        } else {
            $this->event->registerUser($this->model, $role);
        }
    }
}