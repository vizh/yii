<?php
namespace competence\models\test\iidf15;

class Q1 extends \competence\models\form\Input
{
    public function rules()
    {
        return [
            ['value', 'email']
        ];
    }


    protected function getDefinedViewPath()
    {
        return 'competence.views.test.' . $this->getQuestion()->getTest()->Code . '.q1';
    }
}
