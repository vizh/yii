<?php
namespace user\models\forms\edit;

class Employments extends \user\models\forms\edit\Base
{
    public $Employments = [];

    public function rules()
    {
        return [
            ['Employments', 'filter', 'filter' => [$this, 'filterEmployments']]
        ];
    }

    public function attributeLabels()
    {
        $formEmployment = new \user\models\forms\Employment();
        $labels = $formEmployment->attributeLabels();
        $labels['Date'] = \Yii::t('app', 'Период работы');
        return $labels;
    }

    public function setAttributes($values, $safeOnly = true)
    {
        if (isset($values['Employments'])) {
            foreach ($values['Employments'] as $value) {
                $form = new \user\models\forms\Employment();
                $form->attributes = $value;
                $this->Employments[] = $form;
            }
            unset($values['Employments']);
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function filterEmployments($employments)
    {
        $valid = true;
        foreach ($employments as $employment) {
            if (!$employment->validate()) {
                $valid = false;
            }
        }
        if (!$valid) {
            $this->addError('Employments', \Yii::t('app', 'Ошибка в заполнении Карьеры.'));
        }
        return $employments;
    }

    public function getMonthOptions()
    {
        $html = '<option value=""></option>';
        foreach (\Yii::app()->locale->getMonthNames('wide', true) as $month => $title) {
            $html .= '<option value="'.$month.'">'.$title.'</option>';
        }
        return $html;
    }

    public function getYearOptions()
    {
        $html = '<option value=""></option>';
        for ($y = date('Y'); $y >= 1980; $y--) {
            $html .= '<option value="'.$y.'">'.$y.'</option>';
        }
        return $html;
    }
}
