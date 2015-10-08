<?php
namespace competence\models\test\runet2015;

use competence\models\Result;

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
            if (!empty($value[$i])) {
                return true;
            }
        }
        $this->addError($attribute, 'Необходимо ввести название хотя бы одной компании.');
        return false;
    }

    /**
     * @return string|null
     */
    protected function getDefinedViewPath()
    {
        return 'competence.views.test.runet2015.c4';
    }

    /**
     * @return array
     */
    protected function getInternalExportValueTitles()
    {
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $data[$i] = 'Компания ' . $i;
        }
        return $data;
    }


    /**
     * @param Result $result
     * @return array
     */
    protected function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        for ($i = 1; $i <= 4; $i++) {
            $data[$i] = isset($questionData['value'][$i]) ? $questionData['value'][$i] : '';
        }
        return $data;
    }


} 