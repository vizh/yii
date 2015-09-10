<?php
namespace competence\models\test\runet2015;

class C4 extends \competence\models\form\Base
{
    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateValue($attribute, $params)
    {
        $value = $this->value;
        for ($i = 1; $i <= 4; $i++) {
            if (empty($value[$i])) {
                $this->addError($attribute, 'Необходимо ввести названия всех четырех компаний');
                return false;
            }
        }
        return true;
    }

    /**
     * @return string|null
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2015.c4';
    }

} 