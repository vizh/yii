<?php
namespace competence\models\test\runet2016;

use competence\models\form\Base;
use competence\models\Question;
use competence\models\Result;

class F1 extends Base
{
    protected function getBaseQuestionCode()
    {
        return 'A1';
    }

    public function getPrev()
    {
        $result = $this->getBaseQuestion()->getResult();
        $code = 'E3_'.$result['value'];
        return Question::model()->byTestId($this->getQuestion()->TestId)->byCode($code)->find();
    }

    public function rules()
    {
        return [
            ['value', 'validateValue']
        ];
    }

    public function validateValue($attribute, $params)
    {
        if (is_array($this->$attribute)) {
            $i = 1;
            $result = [];
            foreach ($this->$attribute as $key => $values) {
                $result[$i] = $values;
                $i++;
                $fio = trim($values['fio']);
                if (strlen($fio) == 0) {
                    $this->addError($attribute, 'Поле "ФИО" не может быть пустым. Удалите не корректную строку и добавьте пользователя повторно.');
                    continue;
                }

                if (empty($values['runetId']) && filter_var($values['email'], FILTER_VALIDATE_EMAIL) === false) {
                    $this->addError($attribute, 'Для пользователя "'.$values['fio'].'" введен не валидный email. Удалите не корректную строку и добавьте пользователя повторно.');
                }
            }
            $this->$attribute = $result;
        }
    }

    public function getInternalExportValueTitles()
    {
        return ['(ФИО, RUNET-ID, Email)'];
    }

    public function getInternalExportData(Result $result)
    {
        $questionData = $result->getQuestionResult($this->question);
        $data = '';
        if (!empty($questionData['value'])) {
            foreach ($questionData['value'] as $row) {
                $runetid = isset($row['runetId']) ? $row['runetId'] : '-';
                $email = isset($row['email']) ? $row['email'] : '-';
                $data .= '('.$row['fio'].', '.$runetid.', '.$email.'); ';
            }
        }
        return [$data];
    }
}
