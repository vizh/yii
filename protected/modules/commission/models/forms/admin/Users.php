<?php
namespace commission\models\forms\admin;

class Users extends \CFormModel
{
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
                $form = new \commission\models\forms\User();
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
            if (!$user->validate()) {
                $valid = false;
            }
        }
        if (!$valid) {
            $this->addError('Users', \Yii::t('app', 'Ошибка в заполнении участников.'));
        }
        return $users;
    }

    public function attributeLabels()
    {
        $formUser = new \commission\models\forms\User();
        $labels = $formUser->attributeLabels();
        return $labels;
    }

    private $roleList = null;

    public function getRoleList()
    {
        if ($this->roleList == null) {
            $formUser = new \commission\models\forms\User();
            $this->roleList = $formUser->getRoleList();
        }
        return $this->roleList;
    }
}
