<?php

namespace ruvents2\models\Forms\Participant;

use application\components\helpers\ArrayHelper;
use event\models\Role;
use ruvents2\components\form\RequestForm;
use Yii;

class Register extends RequestForm
{
    public $Id;
    public $Role;

//    public $Roles;

    public function rules()
    {
        return [
            ['Id', 'required'],
            ['Id', 'numerical', 'integerOnly' => true, 'min' => 1, 'max' => Yii::app()->params['RuventsMaxResults']],
            ['Role', 'in', 'range' => ArrayHelper::getColumn($this->getPossibleRoles(), 'Id')],
//            ['Roles', 'validateRoles']
        ];
    }

//    public function validateRoles($attribute)
//    {
//        /** @var Event $event */
//        /** @noinspection PhpUndefinedMethodInspection */
//        $event = Yii::app()->getController()->getEvent();
//        $roles = ArrayHelper::getColumn($this->getPossibleRoles(), 'Id');
//        /* toDo: Отладить работу с частями */
//        $parts = $event->Parts;
//
//        /* Параметр может является числом, определяющим роль на беспартийное мероприятие. */
//        if (is_numeric($this->Roles) && !in_array($this->Roles, $roles))
//            $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_ROLE_ID, $this->Roles));
//
//        /* Параметр может являться ассоциативным массивом, закодированным в json, ключами которого
//         * являются идентификаторы частей, а значениями - идентификаторы ролей */
//        if (($jsonData = json_decode($this->Roles, true)) && is_array($jsonData)) {
//            foreach ($jsonData as $PartId => $RoleId) {
//                if (!is_numeric($RoleId) || !in_array($RoleId, $roles)) $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_ROLE_ID, $RoleId));
//                if (!is_numeric($PartId) || !in_array($PartId, $parts)) $this->addError($attribute, Exception::getCodeMessage(Exception::INVALID_PART_ID, $PartId));
//            }
//
//            if ($this->hasErrors() === false)
//                $this->Roles = $jsonData;
//        }
//    }

    /** @var bool|null|Role[] */
    private $_possibleRoles = false;

    private function getPossibleRoles()
    {
        if ($this->_possibleRoles === false) {
            /** @noinspection PhpUndefinedMethodInspection */
            $this->_possibleRoles = Yii::app()->getController()->getEvent()->getRoles();
        }

        return $this->_possibleRoles;
    }
}