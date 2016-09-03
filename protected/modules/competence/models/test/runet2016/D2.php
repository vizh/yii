<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;

class D2 extends Base
{
    use RouteMarket;
    
    public $subMarkets = [];

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        if (is_array($this->$attribute)) {
            foreach ($this->$attribute as $raw) {
                $val = trim($raw);
                if (strlen($val) == 0) {
                    $this->addError($attribute, 'Необходимо оценить все факторы.');
                    return;
                } elseif (!is_numeric($val)) {
                    $this->addError($attribute, 'Вводимое значение должно быть числом, дробная часть отделяется точкой.');
                    return;
                } elseif ($val < 0) {
                    $this->addError($attribute, 'Вводимое значение не может быть меньше нуля');
                    return;
                }
            }            
        } else {
            $this->addError($attribute, 'Некорректный формат ответа.');
        }
    }

    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2016.d1';
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        return $this->getNextMarketQuestion($this->getQuestion()->Test);
    }
}