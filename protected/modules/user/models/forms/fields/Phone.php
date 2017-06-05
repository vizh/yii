<?php
namespace user\models\forms\fields;

use application\components\form\CreateUpdateForm;

/**
 * Class Phone
 * @package user\models\forms\fields
 *
 * Редактирование номера телефона пользоавтеля
 */
class Phone extends CreateUpdateForm
{
    public $Phone;

    public function rules()
    {
        return [
            ['Phone', 'filter', 'filter' => '\application\components\utility\Texts::getOnlyNumbers'],
            ['Phone', 'length', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Phone' => \Yii::t('app', 'Телефон')
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!empty($this->Phone)) {
            $this->model->PrimaryPhone = $this->Phone;
            $this->model->save();
        }
    }

    /**
     * @inheritDoc
     */
    public function createActiveRecord()
    {
    }
}
