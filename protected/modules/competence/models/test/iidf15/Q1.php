<?php
namespace competence\models\test\iidf15;

class Q1 extends \competence\models\form\Input
{
    public function rules()
    {
        return [
            ['value', 'required'],
            ['value', 'email']
        ];
    }

    public function attributeLabels()
    {
        return [
            'value' => 'Email'
        ];
    }


    protected function getDefinedViewPath()
    {
        return 'competence.views.test.' . $this->getQuestion()->getTest()->Code . '.q1';
    }
}
