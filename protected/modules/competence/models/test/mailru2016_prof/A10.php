<?php
namespace competence\models\test\mailru2016_prof;

use competence\models\Result;

class A10 extends \competence\models\form\Base
{

    public $value = [];

    private $options;

    public function getOptions()
    {
        if ($this->options === null) {
            $this->options = $this->rotate('A10_opt', [
                83 => 'Mail.Ru Group',
                84 => 'Яндекс',
                85 => 'Google',
                86 => 'Facebook',
                87 => 'Одноклассники',
                88 => 'Rambler&Co',
                89 => 'ВКонтакте'
            ]);
            $this->options[90] = 'Не подходит ни к одной компании';
        }
        return $this->options;
    }

    private $values;

    public function getValues()
    {
        if ($this->values === null) {
            $this->values = $this->rotate('A10_val', [
                1 => 'Я часто пользуюсь продуктами / услугами этой компании',
                2 => 'Эта компания занимает прочную позицию на рынке',
                3 => 'Я слежу за всеми новостями, касающимися этой компании',
                4 => 'Мне понятны основные принципы политики и стратегия этой компании',
                5 => 'Это динамично развивающаяся компания',
                6 => 'Лидер инноваций в своей сфере',
                7 => 'В этой компании работают самые крупные специалисты данной сферы',
                8 => 'Я хотел бы работать в этой компании',
                9 => 'Компания прислушивается к своим пользователям',
                10=> 'Эта компания организует интересные IT-мероприятия в России'
            ]);
        }
        return $this->values;
    }

    public function rules()
    {
        return [
            ['value', 'checkAllValidator']
        ];
    }

    public function checkAllValidator($attribute, $params)
    {
        foreach (self::getValues() as $key => $value) {
            if (empty($this->value[$key])) {
                $this->addError('value', 'Для каждого из высказываний необходимо выбрать хотя бы один подходящий вариант.');
                return false;
            }
        }
        return true;
    }

    protected function getInternalExportValueTitles()
    {
        $titles = [
            1 => 'Я часто пользуюсь продуктами / услугами этой компании',
            2 => 'Эта компания занимает прочную позицию на рынке',
            3 => 'Я слежу за всеми новостями, касающимися этой компании',
            4 => 'Мне понятны основные принципы политики и стратегия этой компании',
            5 => 'Это динамично развивающаяся компания',
            6 => 'Лидер инноваций в своей сфере',
            7 => 'В этой компании работают самые крупные специалисты данной сферы',
            8 => 'Я хотел бы работать в этой компании',
            9 => 'Компания прислушивается к своим пользователям',
            10=> 'Эта компания организует интересные IT-мероприятия в России'
        ];
        return array_values($titles);
    }

    protected function getInternalExportData(Result $result)
    {
        $titles = [
            1 => 'Я часто пользуюсь продуктами / услугами этой компании',
            2 => 'Эта компания занимает прочную позицию на рынке',
            3 => 'Я слежу за всеми новостями, касающимися этой компании',
            4 => 'Мне понятны основные принципы политики и стратегия этой компании',
            5 => 'Это динамично развивающаяся компания',
            6 => 'Лидер инноваций в своей сфере',
            7 => 'В этой компании работают самые крупные специалисты данной сферы',
            8 => 'Я хотел бы работать в этой компании',
            9 => 'Компания прислушивается к своим пользователям',
            10=> 'Эта компания организует интересные IT-мероприятия в России'
        ];
        $keys = array_keys($titles);
        $questionData = $result->getQuestionResult($this->question);
        $data = [];
        foreach ($keys as $key) {
            $data[] = isset($questionData['value'][$key]) ? implode(',', $questionData['value'][$key]) : '';
        }
        return $data;
    }
}
