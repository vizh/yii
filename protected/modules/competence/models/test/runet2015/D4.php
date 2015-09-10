<?php
namespace competence\models\test\runet2015;

use competence\models\form\Single;
use competence\models\Question;

class D4 extends Single
{
    public function __get($name)
    {
        if ($name == 'Values') {
            return $this->getValues(parent::__get($name));
        }
        return parent::__get($name);
    }

    /**
     * @param $values
     * @return mixed
     * @throws \application\components\Exception
     */
    private function getValues($values)
    {
        $test = $this->getQuestion()->Test;
        $d3 = Question::model()->byTestId($test->Id)->byCode('D3')->find();
        $d3->setTest($test);

        $d3Value = $d3->getResult()['value'];
        if ($d3Value != 7) {
            foreach ($values as $i => $value) {
                if ($d3Value > $value->key) {
                    unset($values[$i]);
                }
            }
        }
        return $values;
    }

} 