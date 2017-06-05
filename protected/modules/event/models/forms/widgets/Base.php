<?php
namespace event\models\forms\widgets;

class Base extends \CFormModel
{
    public $Attributes = [];

    public function rules()
    {
        return [
            ['Attributes', 'filter', 'filter' => [$this, 'filterAttributes']]
        ];
    }

    public function filterAttributes($value)
    {
        if (!is_array($value)) {
            $this->addError('Attributes', \Yii::t('app', 'Не заполнены параметры виджета!'));
        }

        return $value;
    }

    public function getLocaleList()
    {
        return \Yii::app()->params['Languages'];
    }
} 