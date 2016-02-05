<?php
namespace competence\models\test\mailru2016_prof;

use \competence\models\form\Input;

class C1 extends Input
{
    protected function getBaseQuestionCode()
    {
        return 'S1';
    }

    public function attributeLabels()
    {
        return [
            'value' => 'Год вашего рождения'
        ];
    }


    public function rules()
    {
        return [
            ['value', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'message' => 'Введите целое число.', 'min' => 1950, 'max' => 2010]
        ];
    }

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        if ($result['value'] == 1) {
            return $this->getQuestionByCode('S3_1');
        } else {
            return $this->getQuestionByCode('S3');
        }
    }
}