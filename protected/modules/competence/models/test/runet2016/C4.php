<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;

class C4 extends Base
{
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.c4';
    }

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        $valid = false;
        if (is_array($this->$attribute)) {
            $sum = 0;
            foreach ($this->$attribute as $val) {
                $sum += $val;
            }

            if ($sum == 100)
                $valid = true;
        }

        if (!$valid)
            $this->addError($attribute, 'Сумма оборота всех компаний должна быть равной 100%');
    }
}