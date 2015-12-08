<?php
namespace user\models\forms\fields;

use application\components\form\FormModel;

/**
 * Class Employment
 * @package user\models\forms\fields
 *
 * Редактирование места работы и занимаемая должность
 */
class Employment extends FormModel
{
    /** @var string Название компании */
    public $Company;

    /** @var string Занимаемая должность */
    public $Position;

    public function rules()
    {
        return [
            ['Company, Position', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Position', 'application\components\validators\InlineValidator', 'method' => [$this, 'validateEmployment']]
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateEmployment($attribute)
    {
        if (!empty($this->Position) && empty($this->Company)) {
            $this->addError($attribute, 'Поле "'. $this->getAttributeLabel('Position') .'" не может быть заполнено без поля "'. $this->getAttributeLabel('Company') .'"');
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Company' =>  \Yii::t('app', 'Компания'),
            'Position' =>  \Yii::t('app', 'Должность')
        ];
    }
}