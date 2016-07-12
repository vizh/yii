<?php
namespace user\models\forms\fields;

use application\components\form\CreateUpdateForm;
use user\models\User;

/**
 * Class Employment
 * @package user\models\forms\fields
 *
 * Редактирование места работы и занимаемая должность
 */
class Employment extends CreateUpdateForm
{
    /** @var string Название компании */
    public $Company;

    /** @var string Занимаемая должность */
    public $Position;

    /** @var User */
    protected $model = null;

    public function rules()
    {
        return [
            ['Company, Position', 'filter',
                'filter' => '\application\components\utility\Texts::clear'],
            ['Position', 'application\components\validators\InlineValidator',
                'method' => [$this, 'validateEmployment']],
            ['Company, Position', 'length', 'max' => 255],
        ];
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function validateEmployment($attribute)
    {
        if (!empty($this->Position) && empty($this->Company)) {
            $this->addError($attribute,
                'Поле "'.$this->getAttributeLabel('Position').'" не может быть заполнено без поля "'.$this->getAttributeLabel('Company').'"');

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
            'Company' => \Yii::t('app', 'Компания'),
            'Position' => \Yii::t('app', 'Должность'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateActiveRecord()
    {
        if (!empty($this->Company)) {
            $employment = $this->model->getEmploymentPrimary();
            if ($employment === null || $employment->Company->Name !== $this->Company || $employment->Position !== $this->Position) {
                $this->model->setEmployment($this->Company, $this->Position);
            }
        }
    }
}
