<?php
namespace partner\models\forms\user;

use application\components\form\FormModel;
use user\models\User;

/**
 * Class Find
 * @package partner\models\forms\user
 */
class Find extends FormModel
{
    public $Label;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Label' => 'ФИО, RUNET-ID или Email участника'
        ];
    }

    public function rules()
    {
        return [
            ['Label', 'required'],
            [
                'Label',
                '\application\components\validators\ExistValidator',
                'className' => User::className(),
                'attributeName' => 'RunetId',
                'when' => function ($value) {
                    return is_numeric($value);
                }
            ],
            [
                'Label',
                '\application\components\validators\InlineValidator',
                'skipOnError' => true,
                'method' => function ($form, $attribute) {
                    if ($this->getUserActiveRecord()->count() != 1) {
                        $form->addError($attribute, \Yii::t('app', 'Пользователь не найден или найден более чем один.'));
                        return false;
                    }
                    return true;
                }
            ]
        ];
    }

    /**
     * @return User
     */
    private function getUserActiveRecord()
    {
        return User::model()->bySearch($this->Label)->byEmail($this->Label, false);
    }
}