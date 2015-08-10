<?php

namespace ruvents2\models\forms;

use application\components\helpers\ArrayHelper;
use event\models\Event;
use ruvents2\components\Exception;
use ruvents2\components\FormModel;
use Yii;

class ParticipantRegisterForm extends FormModel
{
    public $Id;
    public $Roles;

    public function rules()
    {
        return [
            ['Id, Roles', 'required'],
            ['Roles', 'validateRoles']
        ];
    }

    public function validateRoles($attribute)
    {
        /** @var Event $event */
        /** @noinspection PhpUndefinedMethodInspection */
        $event = Yii::app()->getController()->getEvent();
        $roles = ArrayHelper::getColumn($event->getRoles(), 'Id');
        /* toDo: Отладить работу с частями */
        $parts = $event->Parts;

        /* Параметр может является числом, определяющим роль на беспартийное мероприятие. */
        if (is_numeric($this->Roles) && !in_array($this->Roles, $roles))
            $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_ROLE_ID, $this->Roles));

        /* Параметр может являться ассоциативным массивом, закодированным в json, ключами которого
         * являются идентификаторы частей, а значениями - идентификаторы ролей */
        if (($jsonData = json_decode($this->Roles, true)) && is_array($jsonData)) {
            foreach ($jsonData as $PartId => $RoleId) {
                if (!is_numeric($RoleId) || !in_array($RoleId, $roles)) $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_ROLE_ID, $RoleId));
                if (!is_numeric($PartId) || !in_array($PartId, $parts)) $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_PART_ID, $PartId));
            }

            if ($this->hasErrors() === false)
                $this->Roles = $jsonData;
        }
    }
}