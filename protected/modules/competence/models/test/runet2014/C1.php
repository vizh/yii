<?php
namespace competence\models\test\runet2014;

class C1 extends \competence\models\form\Input
{
    use MarketIndex;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [
            'value', 'numerical',
            'message' => 'Вводимое значение должно быть числом, дробная часть отделяется точкой.',
            'min' => 0,
            'tooSmall' => 'Вводимое значение не может быть меньше нуля'
        ];
        return $rules;
    }

    protected function getBaseQuestionCode()
    {
        return 'B3_'.$this->getMarketIndex();
    }


    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        if ($result['value'] == 2) {
            return $this->getBaseQuestion();
        }
        return parent::getPrev();
    }
}