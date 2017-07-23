<?php

namespace raec\models\forms\admin;

use raec\models\forms\User as UserForm;
use Yii;

class Users extends \CFormModel
{
    /** @var UserForm[] */
    public $Users = [];

    public function rules()
    {
        return [
            ['Users', 'filter', 'filter' => [$this, 'filterUsers']]
        ];
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['Users'])) {
            foreach ($values['Users'] as $value) {
                $form = new UserForm();
                $form->attributes = $value;
                $this->Users[] = $form;
            }
            unset($values['Users']);
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function filterUsers($users)
    {
        $valid = true;
        foreach ($users as $user) {
            if (false === $user->validate()) {
                $valid = false;
            }
        }
        if ($valid === false) {
            $this->addError('Users', Yii::t('app', 'Ошибка в заполнении участников.'));
        }

        return $users;
    }

    public function attributeLabels()
    {
        static $labels;

        if ($labels === null) {
            $labels = (new UserForm())->attributeLabels();
        }

        return $labels;
    }

    public function getRoleList()
    {
        static $roles;

        if ($roles === null) {
            $roles = (new UserForm())->getRoleList();
        }

        return $roles;
    }
}
