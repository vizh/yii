<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.09.14
 * Time: 12:41
 */

namespace raec\models\forms\brief;

use raec\models\BriefUserRole;
use user\models\forms\RegisterForm;
use user\models\User;

class Users extends \CFormModel
{
    public $Label;

    private $registerForm;

    public $Users = [];

    public function __construct($scenario = '')
    {
        $this->registerForm = new RegisterForm();
        parent::__construct($scenario);
    }

    public function rules()
    {
        return [
          ['Users', 'validateUsers']
        ];
    }

    public function validateUsers($attribute)
    {
        $valid = true;
        if (is_array($this->$attribute)) {
            if (sizeof($this->$attribute) > 0) {
                foreach ($this->$attribute as $i => $value) {
                    if (!User::model()->byRunetId($value['RunetId'])->exists() || !array_key_exists($value['RoleId'], $this->getRoleData())) {
                        $valid = false;
                        break;
                    }
                }
            }
        } else {
            $valid = false;
        }

        if (!$valid)
            $this->addError($attribute, \Yii::t('app', 'Ошибка в заполнении поля {label}.', ['{label}' => $this->getAttributeLabel($attribute)]));
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        $users = [];
        $criteria = new \CDbCriteria();
        $criteria->with = ['Employments.Company'];

        foreach ($this->Users as $value) {
            $user = new \stdClass();
            $user->Role = BriefUserRole::model()->findByPk($value['RoleId']);
            $user->User = User::model()->byRunetId($value['RunetId'])->find($criteria);
            $users[] = $user;
        }
        return $users;
    }

    public function attributeLabels()
    {
        return [
          'Users' => \Yii::t('app', 'Представители организации')
        ];
    }

    /**
     * @return RegisterForm
     */
    public function getRegisterForm()
    {
        return $this->registerForm;
    }


    private $roleData = null;

    /**
     * @return array
     */
    public function getRoleData()
    {
        if ($this->roleData == null) {
            $criteria = new \CDbCriteria();
            $criteria->order = '"t"."Title" ASC';
            $roles = BriefUserRole::model()->findAll($criteria);
            $this->roleData = \CHtml::listData($roles,'Id','Title');
        }
        return $this->roleData;
    }
}