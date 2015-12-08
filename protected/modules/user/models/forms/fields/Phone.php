<?php
namespace user\models\forms\fields;

use application\components\form\FormModel;

/**
 * Class Phone
 * @package user\models\forms\fields
 *
 * Редактирование номера телефона пользоавтеля
 */
class Phone extends FormModel
{
    public $Phone;

    public function rules()
    {
        return [
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['Phone', 'unique', 'className' => '\user\models\User', 'attributeName' => 'PrimaryPhone',
                'criteria' => ['condition' => '"t"."Visible"']
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Phone' =>  \Yii::t('app', 'Телефон')
        ];
    }
}