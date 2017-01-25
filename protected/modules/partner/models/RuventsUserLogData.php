<?php
namespace partner\models;

use Yii;

class RuventsUserLogData
{
    public $User;
    public $Operator;
    public $CreationTime;
    public $Action;
    public $Data = [];

    public function getActionMessage()
    {
        $actionMessageMap = [
            'user.create' => Yii::t('app', 'Создание пользователя'),
            'event.register' => Yii::t('app', 'Регистрация на мероприятие'),
            'event.unregister' => Yii::t('app', 'Удаление регистрации на мероприятие'),
            'badge' => Yii::t('app', 'Выдача бейджа'),
            'user.edit' => Yii::t('app', 'Изменение данных пользователя')
        ];
        if (isset($actionMessageMap[$this->Action])) {
            return $actionMessageMap[$this->Action];
        }

        return $this->Action;
    }

    public function appendData($field, $from, $to = null)
    {
        if (empty($from) && empty($to)) {
            return;
        }

        if ($field == 'Role') {
            if (!empty($from) && is_numeric($from) && $from !== 0) {
                $role = \event\models\Role::model()->findByPk($from);
                $from = $role->Title.' ('.$role->Id.')';
            }

            if (!empty($to) && is_numeric($to) && $to !== 0) {
                $role = \event\models\Role::model()->findByPk($to);
                $to = $role->Title.' ('.$role->Id.')';
            }
        }

        if (empty($from) || $from === 0) {
            $from = Yii::t('app', 'Не задано');
        }

        $item = new \stdClass();
        $item->Field = $field;
        $item->From = $from;
        $item->To = $to;
        $this->Data[] = $item;
    }
}