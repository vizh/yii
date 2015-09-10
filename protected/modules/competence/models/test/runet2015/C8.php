<?php
namespace competence\models\test\runet2015;

use competence\models\form\Input;
use competence\models\Question;

class C8 extends Input
{
    use RouteMarket;

    public function rules()
    {
        return [
            ['value', 'numerical', 'message' => 'Вводимое значение должно быть числом', 'min' => 0, 'integerOnly' => true, 'tooSmall' => 'Вводимое значение не может быть меньше нуля', 'max' => 9999999]
        ];
    }

    /**
     * @throws \application\components\Exception
     * @return \competence\models\Question
     */
    public function getNext()
    {
        $test = $this->getQuestion()->Test;

        $code = str_replace('C8_', 'C9_', $this->getQuestion()->Code);
        $question = Question::model()->byCode($code)->byTestId($test->Id)->find();
        if ($question !== null) {
            $question->setTest($test);
            return $question;
        }
        return $this->getNextMarketQuestion($test);
    }


} 