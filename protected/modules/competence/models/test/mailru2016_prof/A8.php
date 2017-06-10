<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A8 extends \competence\models\form\Base
{

    public $value = [];

    public $other;

    protected $options;

    /**
     * @param int $id
     * @return null|string
     */
    public function getOptionLogo($id)
    {
        $urls = [
            1  => 'http://getlogo.org/img/yandex/55/x30/',
            2  => 'http://getlogo.org/img/mail/681/x30/',
            3  => 'http://getlogo.org/img/google/1122/x30/',
            4  => 'http://getlogo.org/img/vk/758/x30/',
            5  => 'http://getlogo.org/img/rambler-co/588/x15/',
            6  => 'http://getlogo.org/img/google/1122/x30/',
            7  => 'http://getlogo.org/img/facebook/1133/x30/',
            8  => 'http://getlogo.org/img/microsoft/226/x30/',
            9  => 'http://getlogo.org/img/kaspersky/11/x30/',
            10 => 'http://getlogo.org/img/parallels/1134/x30/',
            11 => 'http://getlogo.org/img/rbc/59/x30/',
            12 => 'http://getlogo.org/img/ok/1047/x30/',
        ];

        if (!isset($urls[$id])) {
            return null;
        }
        return \CHtml::image($urls[$id], '', ['style' => 'margin-bottom: ' . ($id === 5  ? '20'  : '5') . 'px;']);
    }

    /**
     * @return array|null
     */
    public function getOptions()
    {
        if ($this->options === null) {
            $this->options = $this->rotate('A8_opt', [
                1 => 'Яндекс',
                2 => 'Mail.Ru Group',
                3 => 'Google Russia',
                4 => 'ВКонтакте',
                5 => 'RAMBLER&Co',
                6 => 'Google Global',
                7 => 'Facebook',
                8 => 'Microsoft',
                9 => 'Kaspersky',
                10 => 'Parallels',
                11 => 'РБК',
                12 => 'Одноклассники'
            ]);
            $this->options[98] = 'Другое (укажите, какая именно)';
            $this->options[99] = 'Никто из перечисленных';
        }
        return $this->options;
    }

    public function rules()
    {
        return [
            ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка'],
            ['value', 'otherSelectionValidator']
        ];
    }

    public function otherSelectionValidator($attribute, $params)
    {
        if (in_array(98, $this->value) && strlen(trim($this->other)) == 0) {
            $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант компании');
            return false;
        }
        return true;
    }

    protected function getFormData()
    {
        return ['value' => $this->value, 'other' => $this->other];
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            1 => 'Яндекс',
            2 => 'Mail.Ru Group',
            3 => 'Google Russia',
            4 => 'ВКонтакте',
            5 => 'RAMBLER&Co',
            6 => 'Google Global',
            7 => 'Facebook',
            8 => 'Microsoft',
            9 => 'Kaspersky',
            10 => 'Parallels',
            11 => 'РБК',
            12 => 'Одноклассники',
            98 => 'Другое (укажите, какая именно)',
            99 => 'Никто из перечисленных'
        ];
        $titles['other'] = 'Другое - значение';
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            1 => 'Яндекс',
            2 => 'Mail.Ru Group',
            3 => 'Google Russia',
            4 => 'ВКонтакте',
            5 => 'RAMBLER&Co',
            6 => 'Google Global',
            7 => 'Facebook',
            8 => 'Microsoft',
            9 => 'Kaspersky',
            10 => 'Parallels',
            11 => 'РБК',
            12 => 'Одноклассники',
            98 => 'Другое (укажите, какая именно)',
            99 => 'Никто из перечисленных'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = !empty($questionData['value']) && in_array($key, $questionData['value']) ? 1 : '';
            if ($key == 98) {
                $data[] = $questionData['other'];
            }
        }
        return $data;
    }
}
